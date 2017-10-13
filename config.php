<?php 
/** CONFIGURATION FILE **/
// Main URL : Same URL where the config.php file is located. Add a slash at the end.
define( 'Directory_Main', 'https://archive.commondreams.org/' );
// URL of the first directory to scan (relative to the main directory). Add a slash at the end.
define( 'Directory_Scan', './' );
// URL of the second directory to scan (relative to the main directory) *optional* If no second directory to scan, write 'false'. Add a slash at the end.
define( 'Directory_Scan2', false );
// Sitemap file URL (relative to the main directory).
define( 'File_Sitemap_URL', './sitemap.xml' );
// Create the sitemap file. Choose between : 'true' (means yes), 'false' (means no).
define( 'File_Sitemap_CHOICE', true );
// Scan the subdirectories. Choose between : 'true' (means yes), 'false' (means no).
define( 'Subdirectory', true );
// Change Frequency. Choose between : 'always','hourly','daily','weekly','monthly','yearly','never'.
define( 'Frequency', 'monthly' );
// Priority Frequency. Choose between : '0.0', '0.1', '0.2', '0.3', '0.4', '0.5', '0.6', '0.7', '0.8', '0.9', '1.0' .
define( 'Priority', '0.5' );
// File Extension to scan. Add all extensions separated by commas. List of common file extensions : http://www.fileinfo.com/filetypes/common.
$extensions_autorized='htm,html,pdf,txt,doc,php';
// Do not remove this line.
$extensions_autorized = explode(",",$extensions_autorized);
// File(s) to ignore during the scan. Add all files separated by commas. Example : config.php='config.php,test.php,file.css'.
$file_to_ignore='config.php';
// Do not remove this line.
$file_to_ignore = explode(",",$file_to_ignore);
/* CRON JOB */ 
// If you want the sitemap to be build periodically (daily, weekly, etc), you can set up a cron job so that your sitemap will update automatically. 
// The URL of the sitemap is : https://archive.commondreams.org/sitemap_generator.php
?>