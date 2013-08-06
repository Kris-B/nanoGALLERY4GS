<?php

class nanogalleryData {
	var $baseDir='';
	var $images;
}

$images = array('images/20.11.A1B9.jpg','images/20.11.A1B9.jpg');
	$data = new nanogalleryData();
	$data->baseDir=dirname(dirname(dirname(__FILE__))).'/data/uploads/';		//getcwd();

	
$dh  = opendir($data->baseDir);
while (false !== ($filename = readdir($dh))) {
    $files[] = $filename;
}
$data->images=$files;


//print json_encode($images); // return them to the client in JSON format.

print json_encode($data); // return them to the client in JSON format.

exit;
?>