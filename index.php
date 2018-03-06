<?php

// Directory listings.
$files = [];
$di = new RecursiveDirectoryIterator('./');
foreach (new RecursiveIteratorIterator($di) as $filename => $file) {
  if ($file->getExtension() == 'htm') {
    $files[] = $filename;
  }
}
$count = count($files);
$items_per_page = 25;
$pages = ceil($count / $items_per_page);
$current_page = isset($_GET['page']) ? $_GET['page'] : 1;
$page_offset = $current_page * $items_per_page;


// Scraping.
function scrape_html($file) {
  $data = [
    'page_title' => '',
    'description' => '',
  ];

  $dom = new DOMDocument;

  if (@$dom->loadHTMLFile($file)) {
    $list = $dom->getElementsByTagName("title");
    if ($list->length > 0) {
      $data['page_title'] = $list->item(0)->textContent;
    }

    $metas = $dom->getElementsByTagName('meta');
    foreach ($metas as $meta) {
      $name = strtolower($meta->getAttribute('name'));
      if ($name == 'description') {
        $data['description'] = $meta->getAttribute('content');
      }
    }
  }
  return $data;
}

?>
<!DOCTYPE html>
<!--[if IEMobile 7]>
<html class="no-js ie iem7" lang="en" dir="ltr"><![endif]-->
<!--[if lte IE 6]>
<html class="no-js ie lt-ie9 lt-ie8 lt-ie7" lang="en" dir="ltr"><![endif]-->
<!--[if (IE 7)&(!IEMobile)]>
<html class="no-js ie lt-ie9 lt-ie8" lang="en" dir="ltr"><![endif]-->
<!--[if IE 8]>
<html class="no-js ie lt-ie9" lang="en" dir="ltr"><![endif]-->
<!--[if (gte IE 9)|(gt IEMobile 7)]>
<html class="no-js ie" lang="en" dir="ltr"
      prefix="og: http://ogp.me/ns# article: http://ogp.me/ns/article# book: http://ogp.me/ns/book# profile: http://ogp.me/ns/profile# video: http://ogp.me/ns/video# product: http://ogp.me/ns/product#"><![endif]-->
<!--[if !IE]><!-->
<html class="no-js" lang="en" dir="ltr"
      prefix="og: http://ogp.me/ns# article: http://ogp.me/ns/article# book: http://ogp.me/ns/book# profile: http://ogp.me/ns/profile# video: http://ogp.me/ns/video# product: http://ogp.me/ns/product#">
<!--<![endif]-->
<head>
    <meta charset="utf-8"/>
    <meta http-equiv="cleartype" content="on"/>
    <link rel="shortcut icon" href="https://www.commondreams.org/sites/all/themes/omega_dreams/favicon.ico"
          type="image/vnd.microsoft.icon"/>
    <meta name="MobileOptimized" content="width"/>
    <link rel="apple-touch-icon-precomposed"
          href="https://www.commondreams.org/sites/all/themes/omega_dreams/images/apple-touch/favicon-150x150.png"
          sizes="150x150"/>
    <link rel="apple-touch-icon-precomposed"
          href="https://www.commondreams.org/sites/all/themes/omega_dreams/images/apple-touch/favicon.png"/>
    <link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet"/>
    <link rel="apple-touch-icon-precomposed"
          href="https://www.commondreams.org/sites/all/themes/omega_dreams/images/apple-touch/favicon-120x120.png"
          sizes="120x120"/>

    <meta property="og:site_name" content="Common Dreams"/>
    <meta property="og:type" content="website"/>
    <meta property="og:url" content="https://archive.commondreams.org"/>
    <meta property="og:title" content="Common Dreams Archived Content"/>
    <meta property="og:image"
          content="/sites/default/files/cd_stacked_white_facebook_commondreams.org_.png"/>
    <meta name="twitter:site" content="@commondreams"/>
    <meta name="twitter:site:id" content="14296273"/>
    <meta name="twitter:creator" content="@commondreams"/>
    <meta name="twitter:url" content="/"/>
    <meta name="twitter:title" content="Common Dreams"/>
    <meta name="twitter:image"
          content="/sites/default/files/cd_stacked_white_twitter_commondreams.png"/>
    <meta itemprop="name" content="Common Dreams"/>

    <title>Common Dreams Archived Articles Since 1997 | Common Dreams</title>

    <link itemprop="url" rel="canonical" href="https://www.commondreams.org/"/>
    <meta property="og:image"
          content="https://www.commondreams.org/sites/default/files/cd_stacked_white_facebook_commondreams.org_.png">
    <link type="text/css" rel="stylesheet" href="css/css_IK1p9DItyBxVvrPmvjrodstL8Zdt1hussVotRQYgWZ8.css" media="all"/>
    <link type="text/css" rel="stylesheet" href="css/css_zQ0gcJympZDPBlsc4r3oUU0oYTiOC76-FNTBUESjgKw.css" media="all"/>
    <link type="text/css" rel="stylesheet" href="css/css_CXpF3yiPFnPY2ep5yZdtMEiF4suMqIrK0flnJt0tUxI.css" media="all"/>

    <!--[if lte IE 8]>
    <link type="text/css" rel="stylesheet" href="css/css_wpJzFglesB33x_2-2FkObj7L7ABV__2H8VCDbmSfD5Q.css" media="all"/>
    <![endif]-->
    <link type="text/css" rel="stylesheet" href="css/css_f5MRPfWVasRfNy-x_DzIo2PKKF-5lh9Oq_rxffu_uQQ.css" media="all"/>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
    <script>window.jQuery || document.write("<script src='js/jquery.min.js'>\x3C/script>")</script>
    <script src="js/js_ALflW1qsV-wPL6o1rSDEQRU4nUcXy95j4wWybir5MUc.js"></script>
    <script src="js/js_CaLfg8G471nyYwgmuC2-ievdAnqE9J_KCTCKN6ZoyE4.js"></script>
    <script src="js/js_GdW4c3QuRKuLgT0IcbsFzRiRiPPjmBoj882j85OMt3w.js"></script>

    <!--[if (gte IE 6)&(lte IE 8)]>
    <script src="js/js_l1iEl-hY65c79QTBBcl2tmNsnQFuMrbhOOFZUO_dkyw.js"></script>
    <![endif]-->
    <script src="js/js_wr8JU6enzif-F_GrRxDR0oXwgeWJIACGSnhr9_ts8Mg.js"></script>
    <script src="js/js_fGg58nX_VeAqSnQqbTQ3_fwB7va_clld_ZWXm5msa9Q.js"></script>
    <script src="//platform.twitter.com/widgets.js"></script>
    <script src="js/js_qkszW65KIuWugDOAjTYzg6Hu6YH7bQgXZp45zDjLjHY.js"></script>
    <script>jQuery.extend(Drupal.settings, {
        "basePath": "\/",
        "pathPrefix": "",
        "image_caption": {"selector": ".node--full .node__content img, img.caption, .field--type-image.caption img"},
        "googleanalytics": {
          "trackOutbound": 1,
          "trackMailto": 1,
          "trackDownload": 1,
          "trackDownloadExtensions": "7z|aac|arc|arj|asf|asx|avi|bin|csv|doc(x|m)?|dot(x|m)?|exe|flv|gif|gz|gzip|hqx|jar|jpe?g|js|mp(2|3|4|e?g)|mov(ie)?|msi|msp|pdf|phps|png|ppt(x|m)?|pot(x|m)?|pps(x|m)?|ppam|sld(x|m)?|thmx|qtm?|ra(m|r)?|sea|sit|tar|tgz|torrent|txt|wav|wma|wmv|wpd|xls(x|m|b)?|xlt(x|m)|xlam|xml|z|zip",
          "trackDomainMode": "1"
        },
        "ctas": {
          "slide_down_from_top": {"delta": "47"},
          "modal_popup": {"delta": "cta_modal_winter_2017", "after_page_views": "3"}
        },
        "urlIsAjaxTrusted": {"\/": true}
      });</script>

    <style>
        .l-main {
            max-width: 700px;
            margin: 0 auto;
        }
        .panel-display--grid-3 {
            clear: both;
            overflow: hidden;
        }
        #google-search .gsc-control-cse {
            padding: 1em 0;
            width: auto;
        }
        #google-search .gsc-input-box {
            height: auto;
        }
        #google-search td.gsc-input input {
            font-size: 1rem;
            padding: 0.5rem;
            height: 2.25rem !important;
        }
        #google-search td.gsc-search-button {
            width: 1%;
        }
        #google-search td.gsc-search-button input.gsc-search-button-v2 {
            width: auto;
            height: 40px;
            padding: 12px 27px !important;
        }
        ul.listings {
            margin: 0;
            padding: 0;
        }
        .listings li {
            list-style: none;
            padding: 5px 0;
        }
        .listings li .title {
            font-size: 18px;
            line-height: normal;
        }
        .listings li .description {
            font-size: 14px;
            line-height: 14px;
        }
        .pager {
            margin-top: 15px;
            padding: 15px 0 30px;
            border-top: 1px solid #ccc;
        }
        .pager ul {
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: row;
            justify-content: center;
        }
        .pager ul li {
            list-style: none;
            padding: 0 15px;
        }
    </style>
    <!-- Global Site Tag (gtag.js) - Google Analytics -->
    <script async
            src="https://www.googletagmanager.com/gtag/js?id=UA-19360686-4"></script>
    <script>
      window.dataLayer = window.dataLayer || [];

      function gtag() {
        dataLayer.push(arguments)
      };
      gtag('js', new Date());

      gtag('config', 'UA-19360686-4');
    </script>
    <!-- END Global Site Tag (gtag.js) - Google Analytics -->
</head>
<body class="html front not-logged-in page-home">
<a href="#main-content" class="element-invisible element-focusable">Skip to main content</a>

<div id="navigation" class="slide-menu">
    <!--    <div id="close-slide-menu-button"><a href="#"><i class="fa fa-window-close-o"></i></a></div>-->
    <div class="slide-menu-container">
        <div class="l-region l-region--navigation">
            <div id="block-block-63" class="block block--block block--block-63">
                <div class="block__content">
                    <ul class="menu">
                        <li><a href="/">Home</a></li>
                        <li><a href="/email-subscription">Subscribe</a></li>
                        <li><a href="https://secure.actblue.com/donate/support-independent-media?refcode=menu"
                               target="blank">Donate</a></li>
                    </ul>
                </div>
            </div>
            <nav id="block-system-main-menu" role="navigation"
                 class="block block--system block--menu block--system-main-menu">

                <ul class="menu">
                    <li class="first leaf"><a href="/world"
                                              title="International news and editorials published by Common Dreams, an independent media outlet based in Portland Maine since 1997">World</a>
                    </li>
                    <li class="leaf"><a href="/war-peace"
                                        title="War &amp;amp; Peace news and editorials published by Common Dreams, an independent media outlet based in Portland Maine since 1997">War
                            &amp; Peace</a></li>
                    <li class="leaf"><a href="/economy"
                                        title="News and editorials related to the economy published by Common Dreams, an independent media outlet based in Portland Maine since 1997">Economy</a>
                    </li>
                    <li class="leaf"><a href="/climate"
                                        title="News and editorials related to the climate, climate change, and global warming published by Common Dreams, an independent media outlet based in Portland Maine since 1997">Climate</a>
                    </li>
                    <li class="leaf"><a href="/rights"
                                        title="News and editorials related to the human and civil rights published by Common Dreams, an independent media outlet based in Portland Maine since 1997">Rights</a>
                    </li>
                    <li class="leaf"><a href="/solutions"
                                        title="Solutions to issues facing U.S. citizens and humanity within news and editorials published by Common Dreams, an independent media outlet based in Portland Maine since 1997">Solutions</a>
                    </li>
                    <li class="leaf"><a href="/us"
                                        title="News and editorials related to issues within the United States published by Common Dreams, an independent media outlet based in Portland Maine since 1997">U.S.</a>
                    </li>
                    <li class="last leaf"><a href="/canada"
                                             title="News and editorials related to issues within the Canada published by Common Dreams, an independent media outlet based in Portland Maine since 1997">Canada</a>
                    </li>
                </ul>
            </nav>
            <div id="block-block-64" class="block block--block block--block-64">
                <div class="block__content">
                    <ul class="menu">
                        <li><a href="https://www.facebook.com/commondreams.org" target="blank"><img
                                        src="https://www.commondreams.org/sites/default/files/facebook-white-300.png"
                                        alt="Common Dreams on Facebook" width="30" height="40" style="vertical-align: middle;"/></a><a
                                    href="https://www.twitter.com/commondreams" target="blank"><img
                                        src="https://www.commondreams.org/sites/default/files/twitter-white-transparent-lg.png"
                                        alt="Common Dreams on Twitter" width="40" height="40"
                                        style="vertical-align: middle; margin-right: 8px; margin-left: 8px;"/></a><a
                                    href="/rss.xml"><img
                                        src="https://www.commondreams.org/sites/default/files/rss-white-lg.png"
                                        alt="Common Dreams RSS feed" width="40" height="40"
                                        style="vertical-align: middle;"/></a></li>
                    </ul>
                </div>
            </div>
            <div id="block-block-65" class="block block--block block--block-65">
                <div class="block__content">
                    <ul class="menu">
                        <li><a href="/about-us">Common Dreams, a non-profit newscenter, was founded in 1997</a></li>
                        <li><a href="/testimonials">Testimonials</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="l-page has-no-sidebars">
    <div id="header-container">
        <div id="header-top">
            <div class="l-header">
                <div class="col header-left">
                    <div id="mobile-menu-wrapper">
                        <a id="slide-menu-button" href="#">
                            <span class="slide-menu-lines"></span>
                            <span class="label">Sections</span>
                        </a>
                    </div>

                    <div id="search-icon">
                        <a id="search-toggle" href="#"><i class="fa fa-search"></i> </a>
                    </div>
                </div>

                <div class="col header-middle">
                    <div itemprop="publisher" itemscope itemtype="https://schema.org/Organization">
                        <meta itemprop="name" content="Common Dreams">
                        <meta itemprop="url"
                              content="https://www.commondreams.org/sites/default/files/cd_stacked_white_600.png">
                        <a href="/" title="Home" rel="home" class="site-logo">
                            <meta itemprop="foundingdate" content="1997"/>
                            <span itemprop="logo" itemscope itemtype="https://schema.org/ImageObject">
                  <img src="images/cd_stacked_blue.jpg" alt="Home"/>
                  <meta itemprop="url"
                        content="https://www.commondreams.org/sites/default/files/cd_stacked_white_600.png">
                  <meta itemprop="width" content="600">
                  <meta itemprop="height" content="60">
                </span>
                        </a>
                    </div>
                </div>

                <div class="col header-right">
                    <a class="button button--secondary" href="/email-subscription">SUBSCRIBE</a>
                    <a class="button button--primary"
                       href="https://secure.actblue.com/donate/support-independent-media?refcode=header"
                       target="_blank">DONATE</a>
                </div>
            </div>

        </div>

        <div id="header-content">
            <div class="l-region l-region--header">
                <div id="block-search-form" role="search" class="block block--search block--search-form">
                    <div class="block__content">
                        <form class="search-block-form" action="/" method="post" id="search-block-form"
                              accept-charset="UTF-8">
                            <div>
                                <div class="container-inline">
                                    <h2 class="element-invisible">Search form</h2>
                                    <div class="form-item form-type-textfield form-item-search-block-form">
                                        <label class="element-invisible" for="edit-search-block-form--2">Search </label>
                                        <input title="Enter the terms you wish to search for." type="text"
                                               id="edit-search-block-form--2" name="search_block_form" value=""
                                               size="15" maxlength="128" class="form-text"/>
                                    </div>
                                    <div class="form-actions form-wrapper" id="edit-actions">
                                        <button type="submit" id="edit-submit" name="op"
                                                value="&lt;i class=&quot;fa fa-search&quot;&gt;&lt;/i&gt;"
                                                class="form-button"><i class="fa fa-search"></i></button>
                                    </div>
                                    <input type="hidden" name="form_build_id"
                                           value="form-9zZlCYoBLck8p2JwlU-nVT1Hz55NmQfv88uVCyBKoOw"/>
                                    <input type="hidden" name="form_id" value="search_block_form"/>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!--    <div id="navigation-container">-->
        <!--      --><!--    </div>-->
    </div>


    <div class="l-main">
        <div class="l-content" role="main">
            <a id="main-content"></a>
            <h1>Common Dreams Archive</h1>
            <script>
              (function () {
                var cx = '016732745245266549351:wkpp-trbuh0';
                var gcse = document.createElement('script');
                gcse.type = 'text/javascript';
                gcse.async = true;
                gcse.src = 'https://cse.google.com/cse.js?cx=' + cx;
                var s = document.getElementsByTagName('script')[0];
                s.parentNode.insertBefore(gcse, s);
              })();
            </script>
            <div id="google-search">
                <gcse:search></gcse:search>
            </div>

            <article role="article"
                     class="node node--page node--full node--page--full">
                <div class="grid-size-12 node__content">

                    <ul class="listings">

                      <?php for ($i = $page_offset; $i < $page_offset + $items_per_page; $i++) : ?>
                        <?php $data = scrape_html($files[$i]); ?>
                        <?php if ($data['page_title']) : ?>
                              <li>
                                  <p class="title"><a
                                              href="<?php print $files[$i]; ?>"><?php print $data['page_title']; ?></a>
                                  </p>
                                <?php if ($data['description']) : ?>
                                    <p class="description"><?php print $data['description']; ?></p>
                                <?php endif; ?>
                              </li>
                        <?php endif; ?>
                      <?php endfor; ?>
                    </ul>

                    <div class="pager">
                        <ul>
                          <?php if ($current_page > 1) : ?>
                              <li>
                                  <a href="<?php $_SERVER['REQUEST_URI']; ?>?page=<?php print $current_page - 1; ?>"><
                                      Previous</a></li>
                          <?php endif; ?>
                            <li><?php print $current_page; ?>
                                of <?php print $pages; ?></li>
                          <?php if ($current_page < $count) : ?>
                              <li>
                                  <a href="<?php $_SERVER['REQUEST_URI']; ?>?page=<?php print $current_page + 1; ?>">Next ></a></li>
                          <?php endif; ?>
                        </ul>
                    </div>

                </div>
            </article>
        </div>

    </div>

    <footer class="l-footer" role="contentinfo">
        <div class="l-region l-region--footer">
            <div id="block-panels-mini-footer-panel"
                 class="block block--panels-mini block--panels-mini-footer-panel">
                <div class="block__content">
                    <div class="grid-3 panel-display panel-display--grid-3">
                        <div class="grid-3-region grid-3-region--first">
                            <div class="panel-pane pane-block pane-block-5">
                                <h2 class="pane-title">
                                    <span>About Common Dreams</span></h2>
                                <p>Our Mission:<br/>To inform. To inspire.<br/>To
                                    ignite change for the common good.<br/><br/>Common
                                    Dreams has been providing breaking news
                                    &amp; views for the progressive community
                                    since 1997. We are independent, non-profit,
                                    advertising-free and 100% reader supported.
                                </p>

                                <ul>
                                    <li>
                                        <a href="https://www.commondreams.org/about-us">About
                                            Common
                                            Dreams</a></li>
                                    <li>
                                        <a href="https://www.commondreams.org/key-staff">Key
                                            Staff</a></li>
                                    <li>
                                        <a href="https://www.commondreams.org/writers-guidelines">Writers'
                                            Guidelines</a></li>
                                    <li>
                                        <a href="https://www.commondreams.org/commons-community-guidelines">The
                                            Commons - Community Guidelines</a>
                                    </li>
                                    <li>
                                        <a href="https://www.commondreams.org/privacy-policy">Privacy
                                            Policy</a></li>
                                    <li>
                                        <a href="https://www.commondreams.org/jobs">Jobs</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="grid-3-region grid-3-region--second">
                            <div class="panel-pane pane-block pane-block-4">
                                <h2 class="pane-title"><span>Contact Us</span>
                                </h2>
                                <p class="contact-map">Common Dreams<br/>P.O.
                                    Box 443<br/>Portland, ME 04112-0443<br/>USA
                                </p>

                                <p class="contact-mail">via Email:</p>

                                <ul>
                                    <li>
                                        <a href="mailto:editor@commondreams.org">Editor</a>
                                    </li>
                                    <li>
                                        <a href="mailto:newstips@commondreams.org">News
                                            Tips?</a></li>
                                    <li>
                                        <a href="mailto:submissions@commondreams.org">Article
                                            Submissions</a></li>
                                    <li><a href="mailto:news@commondreams.org">News
                                            Release Submissions</a></li>
                                    <li>
                                        <a href="mailto:webmaster@commondreams.org">Webmaster
                                            / General Info</a></li>
                                </ul>

                                <p class="contact-phone">207.775.0488
                                    (voice)<br/> 207.775.0489 (fax)</p></div>
                        </div>
                        <div class="grid-3-region grid-3-region--third">
                            <div class="panel-pane pane-block pane-block-6">
                                <h2 class="pane-title"><span>Common Dreams brings you the news that matters.</span>
                                </h2>
                                <p>
                                    <a href="https://secure.actblue.com/donate/support-independent-media?refcode=footer"
                                       target="_blank" class="button">SUPPORT
                                        Common Dreams</a></p>
                            </div>
                            <div class="panel-pane pane-block pane-block-8">
                                <h2 class="pane-title"><span>Sign up for Newsletter</span>
                                </h2>
                                <p><a class="button"
                                      href="http://action.commondreams.org/signup_page/subscribe">Click
                                        to Sign Up</a></p></div>
                            <div class="panel-pane pane-block pane-block-7">
                                <h2 class="pane-title">
                                    <span>Connect With Us</span></h2>
                                <div class="footer-social"><span itemscope=""
                                                                 itemtype="http://schema.org/Organization"><a
                                                itemprop="sameAs"
                                                target="_blank"
                                                href="http://www.facebook.com/commondreams.org"><em
                                                    class="fa fa-facebook-square"></em></a><a
                                                itemprop="sameAs"
                                                target="_blank"
                                                href="http://www.twitter.com/commondreams"><em
                                                    class="fa fa-twitter-square"></em></a><a
                                                target="_blank" href="/rss.xml"><em
                                                    class="fa fa-rss-square"></em></a><a
                                                itemprop="sameAs"
                                                target="_blank"
                                                href="https://plus.google.com/u/0/b/112945048567964551573?rel=publisher"><em
                                                    class="fa fa-google-plus-square"></em></a></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="block-block-3" class="block block--block block--block-3">
                <div class="block__content">
                    <table style="margin-top: 10px;" border="0">
                        <tbody>
                        <tr>
                            <td style="padding-right: 20px;">
                                <div itemscope=""
                                     itemtype="http://schema.org/Organization">
                                    <a itemprop="url"
                                       href="https://www.commondreams.org"><img
                                                itemprop="logo"
                                                src="https://www.commondreams.org/sites/default/files/cd_stacked_white_600.png"
                                                alt="Common Dreams News and Views Published in Maine Since 1997"
                                                width="200" height="50"
                                                class="media-element file-default"
                                                data-file_info="%7B%22fid%22:%223%22,%22view_mode%22:%22default%22,%22fields%22:%7B%22format%22:%22default%22,%22field_file_image_alt_text%5Bund%5D%5B0%5D%5Bvalue%5D%22:%22%22,%22field_file_image_title_text%5Bund%5D%5B0%5D%5Bvalue%5D%22:%22%22%7D,%22type%22:%22media%22%7D"/></a>
                                    <!--MEDIA-WRAPPER-END-1--></div>
                            </td>
                            <td>
                                <p></p>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </footer>
</div>
</body>
</html>