
(function($) {

  CDream = {
   jVer: jQuery.fn.jquery.split('.').map(function(i){return('0'+i).slice(-2)}).join('.'),
   gridLayout: {}
 };

  CDream.gridLayout.resize = function(event) {
    var adjBound = CDream.jVer < '01.08.00';

    $('.l-content .grid-layout, .region-content .grid-layout').each(function() {
      var content  = $('.view-content', this);
      content = content.length ? content : $(this);
      
      var maxWidth = content.width(); 

      var w     = 0;
      var rowH  = 0;
      var group = [];
      var tile;
      
      content.children('.grid-tile').each(function() {
        $(this).height('auto').removeClass('omega').removeClass('alpha'); // Any residue settings.
        
        var mW = $(this).outerWidth(true) - 1;     // Margin / full space
        var cW = mW - IWapi.utils.parseCssSize($(this).css('marginRight'), this);

        // when the width overflows we are dealing with a new row.
        if (w + cW > maxWidth) {
          group[group.length - 1].addClass('omega');

          while (tile = group.pop()) IWapi.utils.setHeight(tile, rowH);
        
          w = 0;
          rowH = $(this).outerHeight();
        }
        else if (rowH < $(this).outerHeight()) {
          rowH = $(this).outerHeight();
        }

        // if first element in a row, add "alpha" CSS class
        if (group.length == 0) $(this).addClass('alpha');

        group.push($(this));
        w += mW;
      });
      
      // Flush out the final row.
      if (group.length > 0) {
        group[group.length - 1].addClass('omega');
        while (tile = group.pop()) IWapi.utils.setHeight(tile, rowH);
      }
    });
  }

  $(window).load(function() {
    CDream.gridLayout.resize();
    $(window).resize(CDream.gridLayout.resize);
  });

}(jQuery));;
(function($) {

Drupal.behaviors.image_caption = {
  attach: function (context, settings) {
    $(settings.image_caption.selector).once('caption', function(i) {      
      // Get caption from title attribute
      var captiontext = $(this).attr('title');
      if (!captiontext || captiontext.length === 0) {
        return; // skip if no caption text.
      }
      
      var imgwidth = $(this).width() ? $(this).width() : false;
      
      // Get image alignment and style to apply to container
      if($(this).attr('align')){
        var alignment = $(this).attr('align');
        $(this).css({'float':alignment}); // add to css float
        $(this).removeAttr('align');
      }else if($(this).css('float')){
        var alignment = $(this).css('float');
        $(this).removeClass("image-" + alignment);
      }else{
        var alignment = 'normal';
      }

      $(this).removeAttr('align');
      $(this).removeAttr('style');
      
      //Display inline block so it doesn't break any text aligns on the parent contatiner
      $(this).wrap("<span class=\"image-caption-container\"></span>");
      $(this).parent().addClass('image-caption-container-' + alignment);
      
      if (/(^| )(image-full|width-full)( |$)/i.exec($(this).attr("class"))) {
        $(this).parent().addClass('img-width-full');
      }
      else if(imgwidth) {
        $(this).width(imgwidth);
        $(this).parent().width(imgwidth);
      }

      // Append caption
      $(this).parent().append("<span style=\"display:block;\" class=\"image-caption\">" + captiontext + "</span>");
    });
  }
};

})(jQuery);
;
(function ($) {

Drupal.googleanalytics = {};

$(document).ready(function() {

  // Attach mousedown, keyup, touchstart events to document only and catch
  // clicks on all elements.
  $(document.body).bind("mousedown keyup touchstart", function(event) {

    // Catch the closest surrounding link of a clicked element.
    $(event.target).closest("a,area").each(function() {

      // Is the clicked URL internal?
      if (Drupal.googleanalytics.isInternal(this.href)) {
        // Skip 'click' tracking, if custom tracking events are bound.
        if ($(this).is('.colorbox') && (Drupal.settings.googleanalytics.trackColorbox)) {
          // Do nothing here. The custom event will handle all tracking.
          //console.info("Click on .colorbox item has been detected.");
        }
        // Is download tracking activated and the file extension configured for download tracking?
        else if (Drupal.settings.googleanalytics.trackDownload && Drupal.googleanalytics.isDownload(this.href)) {
          // Download link clicked.
          ga("send", {
            "hitType": "event",
            "eventCategory": "Downloads",
            "eventAction": Drupal.googleanalytics.getDownloadExtension(this.href).toUpperCase(),
            "eventLabel": Drupal.googleanalytics.getPageUrl(this.href),
            "transport": "beacon"
          });
        }
        else if (Drupal.googleanalytics.isInternalSpecial(this.href)) {
          // Keep the internal URL for Google Analytics website overlay intact.
          ga("send", {
            "hitType": "pageview",
            "page": Drupal.googleanalytics.getPageUrl(this.href),
            "transport": "beacon"
          });
        }
      }
      else {
        if (Drupal.settings.googleanalytics.trackMailto && $(this).is("a[href^='mailto:'],area[href^='mailto:']")) {
          // Mailto link clicked.
          ga("send", {
            "hitType": "event",
            "eventCategory": "Mails",
            "eventAction": "Click",
            "eventLabel": this.href.substring(7),
            "transport": "beacon"
          });
        }
        else if (Drupal.settings.googleanalytics.trackOutbound && this.href.match(/^\w+:\/\//i)) {
          if (Drupal.settings.googleanalytics.trackDomainMode !== 2 || (Drupal.settings.googleanalytics.trackDomainMode === 2 && !Drupal.googleanalytics.isCrossDomain(this.hostname, Drupal.settings.googleanalytics.trackCrossDomains))) {
            // External link clicked / No top-level cross domain clicked.
            ga("send", {
              "hitType": "event",
              "eventCategory": "Outbound links",
              "eventAction": "Click",
              "eventLabel": this.href,
              "transport": "beacon"
            });
          }
        }
      }
    });
  });

  // Track hash changes as unique pageviews, if this option has been enabled.
  if (Drupal.settings.googleanalytics.trackUrlFragments) {
    window.onhashchange = function() {
      ga("send", {
        "hitType": "pageview",
        "page": location.pathname + location.search + location.hash
      });
    };
  }

  // Colorbox: This event triggers when the transition has completed and the
  // newly loaded content has been revealed.
  if (Drupal.settings.googleanalytics.trackColorbox) {
    $(document).bind("cbox_complete", function () {
      var href = $.colorbox.element().attr("href");
      if (href) {
        ga("send", {
          "hitType": "pageview",
          "page": Drupal.googleanalytics.getPageUrl(href)
        });
      }
    });
  }

});

/**
 * Check whether the hostname is part of the cross domains or not.
 *
 * @param string hostname
 *   The hostname of the clicked URL.
 * @param array crossDomains
 *   All cross domain hostnames as JS array.
 *
 * @return boolean
 */
Drupal.googleanalytics.isCrossDomain = function (hostname, crossDomains) {
  /**
   * jQuery < 1.6.3 bug: $.inArray crushes IE6 and Chrome if second argument is
   * `null` or `undefined`, http://bugs.jquery.com/ticket/10076,
   * https://github.com/jquery/jquery/commit/a839af034db2bd934e4d4fa6758a3fed8de74174
   *
   * @todo: Remove/Refactor in D8
   */
  if (!crossDomains) {
    return false;
  }
  else {
    return $.inArray(hostname, crossDomains) > -1 ? true : false;
  }
};

/**
 * Check whether this is a download URL or not.
 *
 * @param string url
 *   The web url to check.
 *
 * @return boolean
 */
Drupal.googleanalytics.isDownload = function (url) {
  var isDownload = new RegExp("\\.(" + Drupal.settings.googleanalytics.trackDownloadExtensions + ")([\?#].*)?$", "i");
  return isDownload.test(url);
};

/**
 * Check whether this is an absolute internal URL or not.
 *
 * @param string url
 *   The web url to check.
 *
 * @return boolean
 */
Drupal.googleanalytics.isInternal = function (url) {
  var isInternal = new RegExp("^(https?):\/\/" + window.location.host, "i");
  return isInternal.test(url);
};

/**
 * Check whether this is a special URL or not.
 *
 * URL types:
 *  - gotwo.module /go/* links.
 *
 * @param string url
 *   The web url to check.
 *
 * @return boolean
 */
Drupal.googleanalytics.isInternalSpecial = function (url) {
  var isInternalSpecial = new RegExp("(\/go\/.*)$", "i");
  return isInternalSpecial.test(url);
};

/**
 * Extract the relative internal URL from an absolute internal URL.
 *
 * Examples:
 * - http://mydomain.com/node/1 -> /node/1
 * - http://example.com/foo/bar -> http://example.com/foo/bar
 *
 * @param string url
 *   The web url to check.
 *
 * @return string
 *   Internal website URL
 */
Drupal.googleanalytics.getPageUrl = function (url) {
  var extractInternalUrl = new RegExp("^(https?):\/\/" + window.location.host, "i");
  return url.replace(extractInternalUrl, '');
};

/**
 * Extract the download file extension from the URL.
 *
 * @param string url
 *   The web url to check.
 *
 * @return string
 *   The file extension of the passed url. e.g. "zip", "txt"
 */
Drupal.googleanalytics.getDownloadExtension = function (url) {
  var extractDownloadextension = new RegExp("\\.(" + Drupal.settings.googleanalytics.trackDownloadExtensions + ")([\?#].*)?$", "i");
  var extension = extractDownloadextension.exec(url);
  return (extension === null) ? '' : extension[1];
};

})(jQuery);
;
