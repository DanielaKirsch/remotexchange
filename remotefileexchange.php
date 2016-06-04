<?php

$myrootfolder = '/home/dani/';

// look at the file if something changed
$tasklist = $myrootfolder.'Dropbox/0cfdatodo/tasklist.txt';

$taskdone = $myrootfolder.'Dropbox/0cfdatodo/taskdone.txt';

// folder for largefiles on local machine
$locallarge = $myrootfolder.'cfdalargeincoming/';

// folder for dropboxfiles
$dropboxlarge = $myrootfolder.'Dropbox/cfdalarge/';




$arraytasks = array();
 
$file_handle = fopen($tasklist, 'r');
	 
	while (!feof($file_handle)) {
	 
	  $line = fgets($file_handle);
	  array_push($arraytasks, $line);	 
	}
	 
	fclose($file_handle);

$arraydone = array();

$file_handle = fopen($taskdone, 'r');
	 
	while (!feof($file_handle)) {
	 
	  $line = fgets($file_handle);
	  array_push($arraydone, $line);	 
	}
	 
	fclose($file_handle);

$todo = array_diff($arraytasks, $arraydone);

$updatefiledone = "";

for ($i=0; $i < count($todo); $i++) { 
	
	// copy file from $locallarge to $dropboxlarge
	//print_r("nohup cp ".$locallarge.$todo[$i]" ".$dropboxlarge.$todo[$i]" > /dev/null &");
	shell_exec("nohup cp ".$locallarge.$todo[$i]." ".$dropboxlarge.$todo[$i]." > /dev/null &");
	shell_exec("nohup chmod 777 ".$dropboxlarge.$todo[$i]." > /dev/null &");

	$updatefiledone .= $todo[$i];


}


$file = fopen($taskdone,"w");
fwrite($file,$updatefiledone);
fclose($file);


?>