<?php

//we confirm we've hit the server and that PDO is installed and enabled
//$properReturn = "We successfully pinged the server!";
//if ( extension_loaded('pdo') == 1 ) {
//    echo "PDO is enabled.";
//}
require 'credentials.php';
$database = $_POST["databaseName"];
$table = $_POST["droppedTableName"];
if(trim($database) != "" && trim($table) != ""){
    try {
    $conn = new PDO('mysql:host=' . $servername . ';dbname=' . $database, $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "DROP TABLE " . $table;
    // use exec() because no results are returned
    $conn->exec($sql);
    echo($sql);
    }
    catch(PDOException $e)
    {
    echo "Connection failed: " . $e->getMessage();
    }
}

?>