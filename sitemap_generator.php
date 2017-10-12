<?php
require_once('./config.php');
$ignore = array_merge($file_to_ignore, array('.', '..' )); 
function scan( $scan_directory,$main_url) {
	global $ignore,$extensions_autorized;
	$open_dir = opendir($scan_directory);
	while ( false !== ($file = readdir($open_dir))){
		if (in_array(utf8_encode($file),$ignore)) // Ignore the indicated file in the config file
			continue;		
		 if (is_dir($file)){ // If the scanned file is a directory and the option of the subdirectories is 'yes', so the scan go on
			if (defined('Subdirectory') AND Subdirectory) { 
				scan($scan_directory.$file.'/',$main_url); 
			}
		} 
		$fileinfo = pathinfo($scan_directory.$file); 
		if (isset($fileinfo['extension']) AND  in_array($fileinfo['extension'],$extensions_autorized)){ // Include only the autorized file extensions 
			if (filemtime($scan_directory.'/'.$file)==FALSE) { // Get the last modified date of the file
				$mod = date('Y-m-d',filectime($scan_directory.'/'.$file)); 
			} else {
				$mod = date('Y-m-d',filemtime($scan_directory.'/'.$file));
			}
			if($scan_directory=='./'){ $url_file=$main_url; } else { $url_file=$main_url.$scan_directory; $url_file=str_replace('./','',$url_file); }
	?>
    <url>
        <loc><?php echo $url_file.rawurlencode($file); ?> </loc>
        <lastmod><?php echo $mod; ?></lastmod>
        <changefreq><?php echo Frequency; ?></changefreq>
        <priority><?php echo Priority; ?></priority>
    </url><?php
		}
	}
	closedir($open_dir);
}

?>
<?php 
if(defined('File_Sitemap_CHOICE') AND File_Sitemap_CHOICE ){ // If the option to create a sitemap file is 'yes', the file will be created
	ob_start(); 
	header( 'Content-Type: application/xml' );
	echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
	echo '<?xml-stylesheet type="text/xsl" href="sitemap.xsl"?>' . "\n"; 
	echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
	scan(Directory_Scan,Directory_Main);
	if(defined('Directory_Scan2') AND Directory_Scan2 ){   // If a second directory to scan exist, scan go on
		scan(Directory_Scan2,Directory_Main );
	}
	echo '</urlset>';
	file_put_contents(File_Sitemap_URL,ob_get_contents());
}else{   
	echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
	scan(Directory_Scan,Directory_Main);
	if(defined('Directory_Scan2') AND Directory_Scan2){ // If a second directory to scan exist, scan go on
		scan(Directory_Scan2, Directory_Main);
	}
	echo '</urlset>';
} ?>
