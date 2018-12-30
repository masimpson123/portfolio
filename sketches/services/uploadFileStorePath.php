<?php

$uploadPath = "../images/"; //where the file goes relative to this file
$downloadPath = "./images/"; //where the file comes from relative to the index

foreach ($_FILES as $value) { //we loop through the $_FILES Superglobal
	$target_file_upload = $uploadPath . basename($value["name"]); //create upload path and file name
    $target_file_download = $downloadPath . basename($value["name"]); //create download link
	move_uploaded_file($value["tmp_name"], $target_file_upload); //move_uploaded_file(file, new path) Moves an uploaded file to a new location
	//we open the file that stores file paths
	$myfile = fopen("filePaths.csv", "a") or die("Unable to open file!");
	//we write the file path of the image just uploaded
	fwrite($myfile, "$target_file_download".",");
}

fclose($myfile);

echo "we're not really using responses right now";

?>