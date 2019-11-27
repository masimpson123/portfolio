<?php

//$properPHPConnect = "We successfully pinged the server!";
//if ( extension_loaded('pdo') == 1 ) { //we confirm PHP Data Object extension is installed
//    $properPHPConnect = $properPHPConnect . " PDO is enabled, extension_loaded('pdo') = " . extension_loaded('pdo') . ", & here is what we got from the database:<br>";
//}

//echo($properPHPConnect);

require 'credentials.php';

$database = $_POST["currentDatabase"];
$table = $_POST["currentTable"];

$SQLStatement = "insert into " . $table . " ("; 

foreach ($_POST as $x => $x_value) {
    if($x != 'currentDatabase' && $x != 'currentTable'){
	$SQLStatement = $SQLStatement . $x . ', ';
    }	
}

// we remove the extra space and comma at the end
//string we're updating, start position, end position
$SQLStatement = substr($SQLStatement, 0, strlen($SQLStatement)-2);

$SQLStatement = $SQLStatement . ") values (";

foreach ($_POST as $x => $x_value) {
    if($x != 'currentDatabase' && $x != 'currentTable'){
	$SQLStatement = $SQLStatement . "'" . $x_value . "', ";
    }	
}

// we remove the extra space and comma at the end
//string we're updating, start position, end position
$SQLStatement = substr($SQLStatement, 0, strlen($SQLStatement)-2);
    
$SQLStatement = $SQLStatement . ")";

echo($SQLStatement);

//we create a PHP Data Object
$conn = new PDO('mysql:host=' . $servername . ';dbname=' . $database, $username, $password);
//we set some error handling attributes
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$preparedStatementOne = $conn->prepare($SQLStatement);
$preparedStatementOne->execute();

?>