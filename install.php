<!DOCTYPE html>
<html lang="en">
<head>
	<!-- META -->
	<title>Sitemap generator</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
	<meta name="description" content="" />
	
	<!-- CSS -->
	<link rel="stylesheet" type="text/css" href="css/kickstart.css" media="all" />
	<link rel="stylesheet" type="text/css" href="css/style.css" media="all" /> 
	
	<!-- Javascript -->
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
	<script type="text/javascript" src="js/kickstart.js"></script>
</head>
<body>
<div class="grid">
	<div class="col_12" style="margin-top:10px;">
		<h1 class="center">
		<p><i class="icon-fire"></i></p>
		Sitemap generator - directory scan</h1>
	</div>
</div> <!-- End Grid -->
<div class="tab-content clearfix" style="margin:50px 50px 50px 50px">
<?php 
if(!empty($_POST['submit'])){
	$subdirectory = trim($_POST['subdirectory']); 
	$frequency = $_POST['frequency'];
	$priority = $_POST['priority'];
	$extensions_autorized = trim($_POST['extensions_autorized']);
	$file_to_ignore = trim($_POST['file_to_ignore']);
	$file_sitemap_choice = $_POST['file_sitemap_choice'];
	$file_sitemap_url = './'.trim($_POST['file_sitemap_url']);
	$dir_scan = './'.trim($_POST['dir_scan']);	 if(substr($dir_scan, -1) != "/"){ $dir_scan.='/';	}		
	if(!empty($_POST['dir_scan2'])){ $dir_scan2 = "'./".trim($_POST['dir_scan2'])."'"; 
			if(substr($dir_scan2, -1) != "/"){ $dir_scan2.='/';	}		}else {  $dir_scan2 = 'false'; }
	$dir_scan_url = trim($_POST['dir_scan_url']); if(substr($dir_scan_url, -1) != "/"){ $dir_scan_url.='/';	}
	/* CREATION DU FICHIER */
	$output='<?php '."\r\n";
	$output.='/** CONFIGURATION FILE **/'."\r\n";
	$output.="// Main URL : Same URL where the config.php file is located. Add a slash at the end.\r\n";	
	$output.="define( 'Directory_Main', '$dir_scan_url' );\r\n";
	$output.="// URL of the first directory to scan (relative to the main directory). Add a slash at the end.\r\n";
	$output.="define( 'Directory_Scan', '$dir_scan' );\r\n";
	$output.="// URL of the second directory to scan (relative to the main directory) *optional* If no second directory to scan, write 'false'. Add a slash at the end.\r\n";
	$output.="define( 'Directory_Scan2', $dir_scan2 );\r\n";	
	$output.="// Sitemap file URL (relative to the main directory).\r\n";	
	$output.="define( 'File_Sitemap_URL', '$file_sitemap_url' );\r\n";
	$output.="// Create the sitemap file. Choose between : 'true' (means yes), 'false' (means no).\r\n";	
	$output.="define( 'File_Sitemap_CHOICE', $file_sitemap_choice );\r\n";
	$output.="// Scan the subdirectories. Choose between : 'true' (means yes), 'false' (means no).\r\n";
	$output.="define( 'Subdirectory', $subdirectory );\r\n";	
	$output.="// Change Frequency. Choose between : 'always','hourly','daily','weekly','monthly','yearly','never'.\r\n";
	$output.="define( 'Frequency', '$frequency' );\r\n";
	$output.="// Priority Frequency. Choose between : '0.0', '0.1', '0.2', '0.3', '0.4', '0.5', '0.6', '0.7', '0.8', '0.9', '1.0' .\r\n";
	$output.="define( 'Priority', '$priority' );\r\n";
	$output.="// File Extension to scan. Add all extensions separated by commas. List of common file extensions : http://www.fileinfo.com/filetypes/common.\r\n";
	$output.='$extensions_autorized=\''.$extensions_autorized.'\';'."\r\n";
	$output.="// Do not remove this line.\r\n";
	$output.='$extensions_autorized = explode(",",$extensions_autorized);'."\r\n";
	$output.="// File(s) to ignore during the scan. Add all files separated by commas. Example : $file_to_ignore='config.php,test.php,file.css'.\r\n";
	$output.='$file_to_ignore=\''.$file_to_ignore.'\';'."\r\n";
	$output.="// Do not remove this line.\r\n";
	$output.='$file_to_ignore = explode(",",$file_to_ignore);'."\r\n";
	$output.="/* CRON JOB */ \r\n";
	$output.="// If you want the sitemap to be build periodically (daily, weekly, etc), you can set up a cron job so that your sitemap will update automatically. \r\n";
	$output.="// The URL of the sitemap is : ".$dir_scan_url."sitemap_generator.php\r\n";	 
	$output.="?>";
	$fichier=fopen("config.php","a+"); 
	$fput_ok =fputs($fichier,$output); 
	fclose($fichier);
	if($fput_ok){ echo '<div class="col_12"><div class="notice success"><i class="icon-ok icon-large"></i>Configuration file created. Please, delete this install.php file 
	<a href="#close" class="icon-remove"></a>
	<p>See the sitemap : <a class="button green" href="sitemap_generator.php">Go to Sitemap</a></p>
	<p>For a cron-job, this is the link : <b>'.$dir_scan_url.'sitemap_generator.php</b></p>
	<p>Also, you can consult the file <i>config-example.php</i></p>
	</div></div>'; } else { echo '<div class="col_12"><div class="notice error"><i class="icon-remove-sign icon-large"></i>Error. Try again and check if you have the permission to create the config file (check the CHMOD of the directory. Change to 775 before launching this script, and change to 644 after the creation of the config file).
	<a href="#close" class="icon-remove"></a></div></div>'; }
	}else {
?>
<form action="" method="post">
<table class="striped">
	<tr style="background-color:black;color:white"><td colspan="3">Important parameters</td></tr>
	<tr>
		<td>Website (main directory): same URL where the file sitemap_generator.php is located<br><div style="font-size:11px">(absolute URL)</div></td>
		<td><input type="text" name="dir_scan_url" size="70" value="<?php echo 'http://'.$_SERVER['SERVER_NAME'].dirname($_SERVER['PHP_SELF']).'/';  ?>"></td>
		<td>-The install file is actually located : <i> <?php echo 'http://'.$_SERVER['SERVER_NAME'].dirname($_SERVER['PHP_SELF']).'/';  ?></i></td>
	</tr>
	<tr>
		<td>Directory to scan <br><div style="font-size:11px">(relative to the main directory)</div></td>
		<td><input type="text" name="dir_scan" value="scan/file/" size="40"></td>
		<td>-This is the directory to scan and search all the files in it		
		<br>-Example : <?php echo 'http://'.$_SERVER['SERVER_NAME'].dirname($_SERVER['PHP_SELF']).'/';  ?>scan/file/
		</td>
	</tr>
	<tr style="background-color:black;color:white"><td colspan="3">Optional parameters</td></tr>
	<tr>
		<td>Second directory to scan <br><div style="font-size:11px">(relative to the main directory *optional*)</div></td>
		<td><input type="text" name="dir_scan2" size="40"></td>
		<td>-This is the second directory to scan and search all the files in it (optional)
		</td>
	</tr>
	<tr>
		<td>Create sitemap.xml file automatically (Choice and URL)<br><div style="font-size:11px">(relative to the main directory)</div></td>
		<td>
		<select name="file_sitemap_choice">
					<option value="true">yes</option><option value="false">no</option>		
			</select>
			URL : <input type="text" name="file_sitemap_url" value="sitemap.xml" size="40"></td>
		<td>
			<br>-Example : <?php echo 'http://'.$_SERVER['SERVER_NAME'].dirname($_SERVER['PHP_SELF']).'/';  ?>sitemap.xml
		</td>
	</tr>
	<tr>
		<td>Scan the subdirectories</td>
		<td>
			<select name="subdirectory" >
				<option value="true">yes</option><option value="false">no</option>		
			</select>
		</td>
		<td>
		<p>-<b>yes :</b> you want to scan all the files in the directories <u>and</u> all the sub-directories</p>
		<p>-<b>no :</b> you do not want to scan all the files in the sub-directories </p>
		</td>
	</tr>
	<tr>
		<td>Allowed File extensions</td>
		<td><input type="text" name="extensions_autorized" value="html,pdf,txt,doc,php" size="40">
			<br><a href="http://www.fileinfo.com/filetypes/common" target="_blank">List of common file extensions</a></td>
		<td>-Add here all the file extensions you want to include in the scan (and so in the sitemap)
		<br>-Example : html,doc,pdf</td>
	</tr>
	<tr>
		<td>Frequency</td>
		<td>
			<select name="frequency">
			<option value="always">always</option><option value="hourly">hourly</option><option value="daily">daily</option>
			<option value="weekly">weekly</option><option value="monthly"selected="selected">monthly</option><option value="yearly">yearly</option><option value="never">never</option>
			</select>
		</td>
		<td>How frequently a page is likely to change. This value provides general information to search engines and may not correlate exactly to how often they crawl the page.The value "always" should be used to describe documents that change each time they are accessed. The value "never" should be used to describe archived URLs.</td>
	</tr>
	<tr>
		<td>Priority</td>
		<td>
			<select name="priority">
					<option value="0.0">0%</option><option value="0.1">10%</option><option value="0.2">20%</option>
					<option value="0.3">30%</option><option value="0.4">40%</option><option value="0.5" selected="selected">50%</option>
					<option value="0.6">60%</option><option value="0.7">70%</option><option value="0.8">80%</option>
					<option value="0.9">90%</option><option value="1">100%</option>		
			</select>
		</td>
		<td>The priority of the URL relative to other URLs on your site. Valid values range from 0.0 to 1.0. This value does not affect how your pages are compared to pages on other sites-it only lets the search engines know which pages you deem most important for the crawlers.<br>The default priority of a page is 0.5.</td>
	</tr>
	<tr>
		<td>File to ignore</td>
		<td><textarea name="file_to_ignore" cols="70">config.php</textarea></td>
		<td>-Add here the files you want to ignore in the sitemap<br>
		<br>-Example : config.php,style.css,script.js</td>
	</tr>
	<tr>
		<td colspan="3"><center><input type="submit" name="submit" value="Create the config file" ></center></td>
	</tr>
</table>

<form>
<?php } ?>
</div>
</body>
</html>