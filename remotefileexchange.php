<?php

require 'config.php';





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

	$myfilename = trim($todo[$i]);
	
	// copy file from $locallarge to $dropboxlarge
	//print_r("nohup cp ".$locallarge.$todo[$i]" ".$dropboxlarge.$todo[$i]" > /dev/null &");
	shell_exec("nohup cp ".$locallarge.$myfilename." ".$dropboxlarge.$myfilename." > /dev/null &");
	shell_exec("nohup chmod 777 ".$dropboxlarge.$myfilename." > /dev/null &");

	
	$updatefiledone .= $myfilename."\n";


}


$file = fopen($taskdone,"a");
fwrite($file,$updatefiledone);
fclose($file);


?>