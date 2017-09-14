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
$pages =  ceil($count / 100);
$current_page = isset($_GET['page']) ? $_GET['page'] : 0;
$page_offset = $current_page * 50;


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
<!--[if IEMobile 7]><html class="no-js ie iem7" lang="en" dir="ltr"><![endif]-->
<!--[if lte IE 6]><html class="no-js ie lt-ie9 lt-ie8 lt-ie7" lang="en" dir="ltr"><![endif]-->
<!--[if (IE 7)&(!IEMobile)]><html class="no-js ie lt-ie9 lt-ie8" lang="en" dir="ltr"><![endif]-->
<!--[if IE 8]><html class="no-js ie lt-ie9" lang="en" dir="ltr"><![endif]-->
<!--[if (gte IE 9)|(gt IEMobile 7)]><html class="no-js ie" lang="en" dir="ltr" prefix="og: http://ogp.me/ns# article: http://ogp.me/ns/article# book: http://ogp.me/ns/book# profile: http://ogp.me/ns/profile# video: http://ogp.me/ns/video# product: http://ogp.me/ns/product#"><![endif]-->
<!--[if !IE]><!--><html class="no-js" lang="en" dir="ltr" prefix="og: http://ogp.me/ns# article: http://ogp.me/ns/article# book: http://ogp.me/ns/book# profile: http://ogp.me/ns/profile# video: http://ogp.me/ns/video# product: http://ogp.me/ns/product#"><!--<![endif]-->
<head>
  <meta charset="utf-8" />
  <meta name="MobileOptimized" content="width" />
  <meta http-equiv="cleartype" content="on" />
  <link rel="profile" href="http://www.w3.org/1999/xhtml/vocab" />
  <link rel="apple-touch-icon-precomposed" href="https://www.commondreams.org/sites/all/themes/omega_dreams/images/apple-touch/favicon-150x150.png" sizes="150x150" />
  <link rel="apple-touch-icon-precomposed" href="https://www.commondreams.org/sites/all/themes/omega_dreams/images/apple-touch/favicon-120x120.png" sizes="120x120" />
  <link rel="shortcut icon" href="https://www.commondreams.org/sites/all/themes/omega_dreams/favicon.ico" type="image/vnd.microsoft.icon" />
  <link rel="apple-touch-icon-precomposed" href="https://www.commondreams.org/sites/all/themes/omega_dreams/images/apple-touch/favicon.png" />
  <link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet" />
  <link rel="apple-touch-icon-precomposed" href="https://www.commondreams.org/sites/all/themes/omega_dreams/images/apple-touch/favicon-76x76.png" sizes="76x76" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0" />

  <link rel="canonical" href="/" />
  <link rel="shortlink" href="/" />

  <meta property="og:site_name" content="Common Dreams" />
  <meta property="og:type" content="website" />
  <meta property="og:url" content="/" />
  <meta property="og:title" content="Common Dreams" />
  <meta property="og:image" content="/sites/default/files/cd_stacked_white_facebook_commondreams.org_.png" />
  <meta name="twitter:site" content="@commondreams" />
  <meta name="twitter:site:id" content="14296273" />
  <meta name="twitter:creator" content="@commondreams" />
  <meta name="twitter:url" content="/" />
  <meta name="twitter:title" content="Common Dreams" />
  <meta name="twitter:image" content="/sites/default/files/cd_stacked_white_twitter_commondreams.png" />
  <meta itemprop="name" content="Common Dreams" />

  <title>Archive | Common Dreams</title>

  <style>
    @import url("https://www.commondreams.org/sites/all/themes/omega/omega/css/modules/system/system.base.css?ovid13");
    @import url("https://www.commondreams.org/sites/all/themes/omega/omega/css/modules/system/system.menus.theme.css?ovid13");
    @import url("https://www.commondreams.org/sites/all/themes/omega/omega/css/modules/system/system.messages.theme.css?ovid13");
    @import url("https://www.commondreams.org/sites/all/themes/omega/omega/css/modules/system/system.theme.css?ovid13");
    @import url("https://www.commondreams.org/modules/node/node.css?ovid13");
    @import url("https://www.commondreams.org/sites/all/themes/omega/omega/css/modules/field/field.theme.css?ovid13");
    @import url("https://www.commondreams.org/sites/all/themes/omega/omega/css/modules/search/search.theme.css?ovid13");
    @import url("https://www.commondreams.org/sites/all/themes/omega/omega/css/modules/user/user.base.css?ovid13");
    @import url("https://www.commondreams.org/sites/all/themes/omega/omega/css/modules/user/user.theme.css?ovid13");
  </style>
  <style>
    @import url("https://www.commondreams.org/sites/all/themes/omega_dreams/css/omega-dreams.normalize.css?ovid13");
    @import url("https://www.commondreams.org/sites/all/themes/omega_dreams/css/omega-dreams.hacks.css?ovid13");
    @import url("https://www.commondreams.org/sites/all/themes/omega_dreams/css/omega-dreams.styles.css?ovid13");
  </style>

  <!--[if lte IE 8]>
  <style>
    @import url("https://www.commondreams.org/sites/all/themes/omega_dreams/css/omega-dreams.no-query.css?ovid13");
  </style>
  <![endif]-->
  <style>
    @import url("https://www.commondreams.org/sites/all/themes/omega_dreams/css/layouts/cdreams/cdreams.layout.css?ovid13");
  </style>
  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
  <script>window.jQuery || document.write("<script src='/sites/all/modules/jquery_update/replace/jquery/1.7/jquery.min.js'>\x3C/script>")</script>
  <script src="//platform.twitter.com/widgets.js"></script>

  <style>
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
      padding-top: 15px;
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
</head>
<body class="html not-front not-logged-in page-node page-node- page-node-107342 node-type-page section-search404">
<a href="#main-content" class="element-invisible element-focusable">Skip to main content</a>
<div class="l-page has-no-sidebars">
  <div id="header-container">
    <header class="l-header" role="banner">
      <div class="l-branding">
        <a href="/" title="Home" rel="home" class="site-logo"><img src="/sites/default/files/cd_tagline_logo_blue.png" alt="Home" /></a>
      </div>

      <div class="l-region l-region--header">
        <nav id="block-menu-menu-top-buttons" role="navigation" class="block block--menu block--menu-menu-top-buttons">
          <ul class="menu"><li class="first leaf"><a href="http://action.commondreams.org/signup_page/subscribe" title="">EMAIL SUBSCRIPTION</a></li>
            <li class="last leaf"><a href="https://secure.actblue.com/donate/support-independent-media?refcode=header" title="">DONATE</a></li>
          </ul></nav>
        <div id="block-search-form" role="search" class="block block--search block--search-form">
          <div class="block__content">
<!--            <form class="search-block-form" action="/asd" method="post" id="search-block-form" accept-charset="UTF-8"><div><div class="container-inline">-->
<!--                  <h2 class="element-invisible">Search form</h2>-->
<!--                  <div class="form-item form-type-textfield form-item-search-block-form">-->
<!--                    <label class="element-invisible" for="edit-search-block-form--2">Search </label>-->
<!--                    <input title="Enter the terms you wish to search for." type="text" id="edit-search-block-form--2" name="search_block_form" value="" size="15" maxlength="128" class="form-text" />-->
<!--                  </div>-->
<!--                  <div class="form-actions form-wrapper" id="edit-actions"><input type="submit" id="edit-submit" name="op" value="Search" class="form-submit" /></div><input type="hidden" name="form_build_id" value="form-raV6wnRGDDyldbw5Cv-8O7N9TEvCRfrJhIptXNyKggs" />-->
<!--                  <input type="hidden" name="form_id" value="search_block_form" />-->
<!--                </div>-->
<!--              </div>-->
<!--            </form>  -->
          </div>
        </div>
      </div>
    </header>
  </div>

  <div id="navigation-container">
    <div class="l-region l-region--navigation">
      <div id="block-block-2" class="block block--block block--block-2">
        <div class="block__content">
          <p style="text-align: center;"><?php print date('l, F j, Y'); ?></p>
        </div>
      </div>
      <nav id="block-system-main-menu" role="navigation" class="block block--system block--menu block--system-main-menu">
        <ul class="menu"><li class="first leaf"><a href="/">Home</a></li>
          <li class="leaf"><a href="/world" title="International news and editorials published by Common Dreams, an independent media outlet based in Portland Maine since 1997">World</a></li>
          <li class="leaf"><a href="/war-peace" title="War &amp;amp; Peace news and editorials published by Common Dreams, an independent media outlet based in Portland Maine since 1997">War &amp; Peace</a></li>
          <li class="leaf"><a href="/economy" title="News and editorials related to the economy published by Common Dreams, an independent media outlet based in Portland Maine since 1997">Economy</a></li>
          <li class="leaf"><a href="/climate" title="News and editorials related to the climate, climate change, and global warming published by Common Dreams, an independent media outlet based in Portland Maine since 1997">Climate</a></li>
          <li class="leaf"><a href="/rights" title="News and editorials related to the human and civil rights published by Common Dreams, an independent media outlet based in Portland Maine since 1997">Rights</a></li>
          <li class="leaf"><a href="/solutions" title="Solutions to issues facing U.S. citizens and humanity within news and editorials published by Common Dreams, an independent media outlet based in Portland Maine since 1997">Solutions</a></li>
          <li class="leaf"><a href="/us" title="News and editorials related to issues within the United States published by Common Dreams, an independent media outlet based in Portland Maine since 1997">U.S.</a></li>
          <li class="last leaf"><a href="/canada" title="News and editorials related to issues within the Canada published by Common Dreams, an independent media outlet based in Portland Maine since 1997">Canada</a></li>
        </ul>
      </nav>
    </div>
  </div>
  <div class="l-main">
    <div class="l-content" role="main">
      <a id="main-content"></a>
      <h1>Common Dreams Archive</h1>
      <article role="article" class="node node--page node--full node--page--full">
        <div class="grid-size-12 node__content">

          <ul class="listings">

            <?php for ($i = $page_offset; $i < $page_offset + 100; $i++) : ?>
              <?php $data = scrape_html($files[$i]); ?>
              <?php if ($data['page_title']) : ?>
                <li>
                  <p class="title"><a href="<?php print $files[$i]; ?>"><?php print $data['page_title']; ?></a></p>
                  <?php if ($data['description']) : ?>
                    <p class="description"><?php print $data['description']; ?></p>
                  <?php endif; ?>
                </li>
              <?php endif; ?>
            <?php endfor; ?>
          </ul>

          <div class="pager">
            <ul>
              <?php if ($current_page > 0) : ?>
                <li><a href="<?php $_SERVER['REQUEST_URI']; ?>?page=<?php print $current_page - 1; ?>">< Previous</a></li>
              <?php endif; ?>
              <li><?php print $current_page; ?> of <?php print $pages; ?></li>
              <?php if ($current_page < $count) : ?>
                <li><a href="<?php $_SERVER['REQUEST_URI']; ?>?page=<?php print $current_page + 1; ?>">Next ></a></li>
              <?php endif; ?>
            </ul>
          </div>

        </div>
      </article>
    </div>

  </div>

  <footer class="l-footer" role="contentinfo">
    <div class="l-region l-region--footer">
      <div id="block-panels-mini-footer-panel" class="block block--panels-mini block--panels-mini-footer-panel">
        <div class="block__content">
          <div class="grid-3 panel-display panel-display--grid-3">
            <div class="grid-3-region grid-3-region--first">
              <div class="panel-pane pane-block pane-block-5">
                <h2 class="pane-title"><span>About Common Dreams</span></h2>
                <p>Our Mission:<br />To inform. To inspire.<br />To ignite change for the common good.<br /><br />Common Dreams has been providing breaking news &amp; views for the progressive community since 1997. We are independent, non-profit, advertising-free and 100% reader supported.</p>

                <ul><li><a href="/about-us">About Common Dreams</a></li><li><a href="/key-staff">Key Staff</a></li><li><a href="/writers-guidelines">Writers' Guidelines</a></li><li><a href="/commons-community-guidelines">The Commons - Community Guidelines</a></li><li><a href="/privacy-policy">Privacy Policy</a></li><li><a href="/jobs">Jobs</a></li></ul>    </div>
            </div>
            <div class="grid-3-region grid-3-region--second">
              <div class="panel-pane pane-block pane-block-4">
                <h2 class="pane-title"><span>Contact Us</span></h2>
                <p class="contact-map">Common Dreams<br />P.O. Box 443<br />Portland, ME 04112-0443<br />USA</p>

                <p class="contact-mail">via Email:</p>

                <ul><li><a href="mailto:editor@commondreams.org">Editor</a></li><li><a href="mailto:newstips@commondreams.org">News Tips?</a></li><li><a href="mailto:submissions@commondreams.org">Article Submissions</a></li><li><a href="mailto:news@commondreams.org">News Release Submissions</a></li><li><a href="mailto:webmaster@commondreams.org">Webmaster / General Info</a></li></ul>

                <p class="contact-phone">207.775.0488 (voice)<br /> 207.775.0489 (fax)</p>    </div>
            </div>
            <div class="grid-3-region grid-3-region--third">
              <div class="panel-pane pane-block pane-block-6">
                <h2 class="pane-title"><span>Common Dreams brings you the news that matters.</span></h2>
                <p><a href="https://secure.actblue.com/donate/support-independent-media?refcode=footer" target="_blank" class="button">SUPPORT Common Dreams</a></p>
              </div>
              <div class="panel-pane pane-block pane-block-8">
                <h2 class="pane-title"><span>Sign up for Newsletter</span></h2>
                <p><a class="button" href="http://action.commondreams.org/signup_page/subscribe">Click to Sign Up</a></p>    </div>
              <div class="panel-pane pane-block pane-block-7">
                <h2 class="pane-title"><span>Connect With Us</span></h2>
                <div class="footer-social"><span itemscope="" itemtype="http://schema.org/Organization"><a itemprop="sameAs" target="_blank" href="http://www.facebook.com/commondreams.org"><em class="fa fa-facebook-square"></em></a><a itemprop="sameAs" target="_blank" href="http://www.twitter.com/commondreams"><em class="fa fa-twitter-square"></em></a><a target="_blank" href="/rss.xml"><em class="fa fa-rss-square"></em></a><a itemprop="sameAs" target="_blank" href="https://plus.google.com/u/0/b/112945048567964551573?rel=publisher"><em class="fa fa-google-plus-square"></em></a></span></div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div id="block-block-3" class="block block--block block--block-3">
        <div class="block__content">
          <table style="margin-top: 10px;" border="0"><tbody><tr><td style="padding-right: 20px;">
                <div itemscope="" itemtype="http://schema.org/Organization"><a itemprop="url" href=""><img itemprop="logo" src="/sites/default/files/cd_stacked_white_600.png" alt="Common Dreams News and Views Published in Maine Since 1997" width="200" height="50" class="media-element file-default" data-file_info="%7B%22fid%22:%223%22,%22view_mode%22:%22default%22,%22fields%22:%7B%22format%22:%22default%22,%22field_file_image_alt_text%5Bund%5D%5B0%5D%5Bvalue%5D%22:%22%22,%22field_file_image_title_text%5Bund%5D%5B0%5D%5Bvalue%5D%22:%22%22%7D,%22type%22:%22media%22%7D" /></a>
                  <!--MEDIA-WRAPPER-END-1--></div>
              </td>
              <td>
                <p> </p>
              </td>
            </tr></tbody></table>  </div>
      </div>
    </div>
  </footer>
</div>
</body>
</html>
