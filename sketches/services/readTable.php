<?php

//$properReturn = "We successfully pinged the server!";
//if ( extension_loaded('pdo') == 1 ) { //we confirm PHP Data Object extension is installed
//    $properReturn = $properReturn . " PDO is enabled, extension_loaded('pdo') = " . extension_loaded('pdo') . ", & here is what we got from the database:<br>";
//}
//echo($properReturn);

$servername = "michaelsimpsondesign.ipagemysql.com";
$username = "michael123";
$password = "theearth123";
$database = $_POST["databaseSelect"];
$table = $_POST["tableSelect"];

try { //We conduct two SQL Queries. One to count the table rows. One to return the table contents.
//we create a PHP Data Object
$conn = new PDO('mysql:host=' . $servername . ';dbname=' . $database, $username, $password);
//we set some error handling attributes
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$preparedStatementOne = $conn->prepare("SELECT * FROM " . $table);
$preparedStatementOne->execute();
$preparedStatementTwo = $conn->prepare("SELECT count(GUID) FROM " . $table);
$preparedStatementTwo->execute();
$preparedStatementThree = $conn->prepare("SELECT column_name FROM information_schema.columns WHERE table_name='" . $table . "'");
$preparedStatementThree->execute();

//we set the fetch mode to associative array
//associative arrays of string keys
//indexed arrays have numeric keys
//by default both are returned so we must decalare our fetch mode
$preparedStatementOne->setFetchMode(PDO::FETCH_ASSOC);
$resultOne = $preparedStatementOne->fetchAll();
$preparedStatementTwo->setFetchMode(PDO::FETCH_ASSOC);
$resultTwo = $preparedStatementTwo->fetchAll(); 
$preparedStatementThree->setFetchMode(PDO::FETCH_ASSOC);
$resultThree = $preparedStatementThree->fetchAll();
    
$tableInformation = "";
foreach($resultOne as $oneRow){
    $tableInformation = $tableInformation . '<br>';
    foreach($oneRow as $oneCell){
        $tableInformation = $tableInformation . $oneCell . ' ';
    }
}
echo($tableInformation);
    
foreach($resultTwo as $oneRow){
    foreach($oneRow as $oneCell){
        $rowCount = $oneCell;
    }
}
echo "<br><br>" . $table . " Row Count: " . $rowCount;

$tableColumns = "
<br><form id='insertRowForm'>
<br>current database <input type='text' name='currentDatabase' value='" . $database . "' readonly>
<br>current table <input type='text' name='currentTable' value='" . $table . "' readonly>
";
foreach($resultThree as $oneRow){
    foreach($oneRow as $oneCell){
        if($oneCell != 'guid'){ //all my tables have the first column named 'guid' and set to auto_increment
        $tableColumns = $tableColumns . '<br>' . $oneCell . ' <input type="text" name="' . $oneCell . '">';
        }
    }
}
$tableColumns = $tableColumns . ' </form><div class="button noSelect" onclick="insertRow()">Insert Row</div>';
echo($tableColumns);
}
catch(PDOException $e)
{
echo "<br>Connection failed: " . $e->getMessage();
}

?>