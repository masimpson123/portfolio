<?php

//we confirm we've hit the server and that PDO is installed and enabled
//$properReturn = "We successfully pinged the server!";
//if ( extension_loaded('pdo') == 1 ) {
//    echo "PDO is enabled.";
//}

require 'credentials.php';

$database = $_POST["databaseSelect"];
try {
$conn = new PDO('mysql:host=' . $servername . ';', $username, $password);   
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$preparedStatementOne = $conn->prepare("use " . $database);
$preparedStatementOne->execute();
$preparedStatementTwo = $conn->prepare("show tables");
$preparedStatementTwo->execute();
$preparedStatementTwo->setFetchMode(PDO::FETCH_ASSOC);
$resultOne = $preparedStatementTwo->fetchAll();
$databaseInformation = "";
foreach($resultOne as $oneRow){
    $databaseInformation = $databaseInformation . '<br>';
    foreach($oneRow as $oneCell){
        $databaseInformation = $databaseInformation . $oneCell . ' ';
    }
} 
if(strlen($databaseInformation)>0){
echo($databaseInformation);
} else {
echo($database . " has no tables."); 
}
}
catch(PDOException $e)
{
echo "Connection failed: " . $e->getMessage();
}

?>