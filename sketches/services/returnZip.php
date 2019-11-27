<?php
$filename = "master.zip";
$filepath = "./";
//MANDATORY HEADERS FOR ANGULAR
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');
//HTTP HEADERS FOR ZIP DOWNLOADS
header("Pragma: public");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Cache-Control: public");
header("Content-Description: File Transfer");
//header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=\"".$filename."\"");
//header("Content-Transfer-Encoding: binary");
header("Content-Length: ".filesize($filepath.$filename));
ob_end_flush();
@readfile($filepath.$filename);
?>