<?php

require 'config.php';


// check if there are new files in the folder

$newlargefiles = scandir($locallarge);

// get all thumbs

$thumblist = scandir($thumbnailfolder);

$newthumbs = array_diff($newlargefiles, $thumblist);


// create thumbnails
// copy to temp
foreach ($newthumbs as $key => $value) {
	# code...
	
		copy($locallarge.$value, $templargefolder.$value);

		shell_exec('/usr/local/bin/mogrify -resize 500 '.$templargefolder.$value);

		copy($templargefolder.$value, $thumbnailfolder.$value);
}


$arraytasks = array();
 
$file_handle = fopen($tasklist, 'r');
	 
	while (!feof($file_handle)) {
	 
	  $line = fgets($file_handle);
	  array_push($arraytasks, trim($line));	 
	}
	 
	fclose($file_handle);

$arraydone = array();

$file_handle = fopen($taskdone, 'r');
	 
	while (!feof($file_handle)) {
	 
	  $line = fgets($file_handle);

	  array_push($arraydone, trim($line));	 
	}
	 
	fclose($file_handle);

$todo = array_diff($arraytasks, $arraydone);


$updatefiledone = "";

$todos = 0;

foreach ($todo as $key => $value) {

	$myfilename = trim($value);
	
	if($myfilename != "" && file_exists($locallarge.$myfilename)) {

		$todos++;

		copy($locallarge.$myfilename, $dropboxlarge.$myfilename);
		chmod($dropboxlarge.$myfilename, 0777);

		$updatefiledone .= $myfilename."\n";
	}


}

if($todos > 0) {
	$file = fopen($taskdone,"a");
	fwrite($file,$updatefiledone);
	fclose($file);
}


?>