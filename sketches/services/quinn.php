<?php

$minTemp = $_GET["minTemp"];
$maxTemp = $_GET["maxTemp"];
$zipcode = $_GET["zipcode"];
$timeIn = $_GET["timeIn"];
$timeOut = $_GET["timeOut"];
$rainTolerance = $_GET["rainTolerance"];

echo "All is well. ";
echo "<br>";
echo "Your zipcode is " . $zipcode . ". "; 
echo "<br>";
echo "Your minTemp is " . $minTemp . ". "; 
echo "<br>";
echo "Your maxTemp is " . $maxTemp . ". "; 
echo "<br>";
echo "Your timeIn is " . $timeIn . ". "; 
echo "<br>";
echo "Your timeOut is " . $timeOut . ". "; 
echo "<br>";
echo "Your zipcode is " . $zipcode . ". "; 

if($timeIn%100>30){
    $timeIn=ceil($timeIn/100)*100;
} else {
    $timeIn=floor($timeIn/100)*100;
}
if($timeIn < 1000){
    $timeIn = "0" . $timeIn;
}
if($timeOut%100>30){
    $timeOut=ceil($timeOut/100)*100;
} else {
    $timeOut=floor($timeOut/100)*100;
}
if($timeOut < 1000){
    $timeOut = "0" . $timeOut;
}

echo "<br>";
echo "<br>";
echo $timeIn;
echo "<br>";
echo $timeOut;

$commuteIn = strtotime("May 12 2019 " . $timeIn);
$commuteOut = strtotime("May 12 2019 " . $timeOut);

echo "<br>";
echo "<br>";
echo "Commute In: ";
echo $commuteIn;
echo "<br>";
echo "Commute Out: ";
echo $commuteOut;

$url = 'http://api.openweathermap.org/data/2.5/forecast/hourly?zip=75039&units=imperial&appid=ae90bbba41d65b1f047a019e0a55de96&cnt=24';
 
//Once again, we use file_get_contents to GET the URL in question.
$contents = file_get_contents($url);
 
// Convert JSON string to Array
$data = json_decode($contents, TRUE);
//print_r($someArray);
foreach($data["list"] as $item) {
    if ($item["dt"] == $commuteIn || $item["dt"] == $commuteOut) {
        echo "<br>";
        echo "<br>";
        echo json_encode($item);
    }
}

?>