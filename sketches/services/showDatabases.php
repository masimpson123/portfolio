<?php

//we confirm we've hit the server and that PDO is installed and enabled
//$properReturn = "We successfully pinged the server!";
//if ( extension_loaded('pdo') == 1 ) {
//    echo "PDO is enabled.";
//}

require 'credentials.php';

try {
$conn = new PDO('mysql:host=' . $servername . ';', $username, $password);   
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$preparedStatementOne = $conn->prepare("show databases");
$preparedStatementOne->execute();
$preparedStatementOne->setFetchMode(PDO::FETCH_ASSOC);
$resultOne = $preparedStatementOne->fetchAll();
$databaseInformation = "";
foreach($resultOne as $oneRow){
    $databaseInformation = $databaseInformation . '<br>';
    foreach($oneRow as $oneCell){
        $databaseInformation = $databaseInformation . $oneCell . ' ';
    }
} 
echo($databaseInformation);
}
catch(PDOException $e)
{
echo "Connection failed: " . $e->getMessage();
}

?>