<?php
require_once('./config.php');

$limit = 49000;
$items = [];
$ignore = array_merge($file_to_ignore, array('.', '..' ));
$sitemaps = [];

function scan( $scan_directory,$main_url, &$items) {
  global $ignore,$extensions_autorized;
  $open_dir = opendir($scan_directory);
  while ( false !== ($file = readdir($open_dir))){
    if (in_array(utf8_encode($file),$ignore)) // Ignore the indicated file in the config file
      continue;
    if (is_dir($file)){ // If the scanned file is a directory and the option of the subdirectories is 'yes', so the scan go on
      if (defined('Subdirectory') AND Subdirectory) {
        scan($scan_directory.$file.'/',$main_url, $items);
      }
    }
    $fileinfo = pathinfo($scan_directory.$file);
    if (isset($fileinfo['extension']) AND  in_array($fileinfo['extension'],$extensions_autorized)){ // Include only the autorized file extensions
      if (filemtime($scan_directory.'/'.$file)==FALSE) { // Get the last modified date of the file
        $mod = date('Y-m-d',filectime($scan_directory.'/'.$file));
      } else {
        $mod = date('Y-m-d',filemtime($scan_directory.'/'.$file));
      }
      if ($scan_directory=='./') {
          $url_file=$main_url;
      } else {
          $url_file=$main_url.$scan_directory;
          $url_file=str_replace('./','',$url_file);
      }
      $items[] = '
        <url>
        <loc>'. $url_file.rawurlencode($file) .'</loc>
        <lastmod>' . $mod . '</lastmod>
        <changefreq>' . Frequency . '</changefreq>
        <priority>' . Priority . '</priority>
        </url>
      ';
    }
  }
  closedir($open_dir);
  return $items;
}

function buildPage($items, $page_num, &$sitemaps) {
  $sitemap_url = explode('.', File_Sitemap_URL);
  $sitemap_url = '.' . $sitemap_url[0] . $sitemap_url[1] . '-' . $page_num . '.' . $sitemap_url[2];
  $sitemaps[] = $sitemap_url;
  ob_start();
  header( 'Content-Type: application/xml' );
  echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
  echo '<?xml-stylesheet type="text/xsl" href="sitemap.xsl"?>' . "\n";
  echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
  foreach ($items as $item) {
      echo $item;
  }
  echo '</urlset>';
  file_put_contents($sitemap_url,ob_get_contents());
}

function buildSitemapIndex($sitemaps) {
    ob_start();
    header('');
    echo '<?xml version="1.0" encoding="UTF-8"?>';
    echo '<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
    foreach ($sitemaps as $sitemap) {
        echo '<sitemap>';
        echo '<loc>' . $sitemap . '</loc>';
        echo '<lastmod>' . date('Y-m-d\TH:i:s', time()) . '</lastmod>';
        echo '</sitemap>';
    }
    echo '</sitemapindex>';
  file_put_contents('./sitemap_index.xml', ob_get_contents());
}

$items = scan(Directory_Scan,Directory_Main, $items);
$chunked_items = array_chunk($items, $limit);
foreach ($chunked_items as $index => $chunk) {
    buildPage($chunk, $index + 1, $sitemaps);
}
if ($sitemaps) {
  buildSitemapIndex($sitemaps);
}
