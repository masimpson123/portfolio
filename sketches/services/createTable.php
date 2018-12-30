<?php

//we confirm we've hit the server and that PDO is installed and enabled
//$properReturn = "We successfully pinged the server!";
//if ( extension_loaded('pdo') == 1 ) {
//    echo "PDO is enabled.";
//}
$servername = "michaelsimpsondesign.ipagemysql.com";
$username = "michael123";
$password = "theearth123";
$database = $_POST["databaseName"];
$table = $_POST["newTableName"];
if(trim($database) != "" && trim($table) != ""){
    try {
    $conn = new PDO('mysql:host=' . $servername . ';dbname=' . $database, $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "CREATE TABLE " . $table . " (guid int auto_increment key";
    //we loop through the $_POST Superglobal which is an 'associative array'
    foreach ($_POST as $x => $x_value) {
        if($x != 'databaseName' && $x != 'newTableName'){
        $sql = $sql . ", " . $x_value . ' varchar(100)';
        }
    }
    $sql = $sql . ")";
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