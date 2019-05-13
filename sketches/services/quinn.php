<?php

if(isset($_GET["minTemp"]) && 
   isset($_GET["maxTemp"]) && 
   isset($_GET["zipcode"]) && 
   isset($_GET["timeIn"]) && 
   isset($_GET["timeOut"]) && 
   isset($_GET["rainTolerance"]) && 
   isset($_GET["parameterUpdate"]) && 
   isset($_GET["maintenance"])){
    $minTemp = $_GET["minTemp"];
    $maxTemp = $_GET["maxTemp"];
    $zipcode = $_GET["zipcode"];
    $timeIn = $_GET["timeIn"];
    $timeOut = $_GET["timeOut"];
    $rainTolerance = $_GET["rainTolerance"];
    $parameterUpdate = $_GET["parameterUpdate"];
    $maintenance = $_GET["maintenance"];
    $goodWeather = true;
    date_default_timezone_set("America/Chicago");
    if (date("H")<=2 && $parameterUpdate == 0) {
        $analyzedDay = "today";
    } else {
        $analyzedDay = "tomorrow";
    }
    if($timeIn%100>30){
        $timeIn=ceil($timeIn/100)*100;
    } 
    if($timeIn%100<=30){
        $timeIn=floor($timeIn/100)*100;
    }
    if($timeIn < 1000){
        $timeIn = "0" . $timeIn;
    }
    if($timeOut%100>30){
        $timeOut=ceil($timeOut/100)*100;
    }
    if($timeOut%100<=30){
        $timeOut=floor($timeOut/100)*100;
    }
    if($timeOut < 1000){
        $timeOut = "0" . $timeOut;
    }
    $commuteIn = strtotime($analyzedDay . $timeIn);
    $commuteOut = strtotime($analyzedDay . $timeOut);
    $url = "http://api.openweathermap.org/data/2.5/forecast/hourly?zip=" . $zipcode . "&units=imperial&appid=ae90bbba41d65b1f047a019e0a55de96&cnt=48";
    $contents = file_get_contents($url);
    $data = json_decode($contents, TRUE);
    foreach($data["list"] as $item) {
        if ($item["dt"] == $commuteIn || $item["dt"] == $commuteOut) {
            //echo json_encode($item);
            if($item["main"]["temp"] < $minTemp || $item["main"]["temp"] > $maxTemp){
                    $goodWeather == false; //temp isn't right
            }
            if(strpos(strtolower($item["weather"][0]["main"]),"rain") !== false){
                if ($rainTolerance == 0) {
                    $goodWeather == false; //no rain allowed
                }
            }
        }
    }
    echo "///";
    echo date("D M d", $commuteIn);
    echo "///";
    if ($goodWeather == true) {
        echo "0"; //happy face
    } else {
        echo "1"; //sad face
    }
    if ($maintenance == 1) {
    echo "<br>";
    echo "<br>";
    echo "Your zipcode is " . $zipcode . ". "; 
    echo "<br>";
    echo "Your minTemp is " . $minTemp . ". "; 
    echo "<br>";
    echo "Your maxTemp is " . $maxTemp . ". "; 
    echo "<br>";
    echo "Your rounded timeIn is " . $timeIn . " (" . $commuteIn . ").";
    echo "<br>";
    echo "Your rounded timeOut is " . $timeOut . " (" . $commuteOut . ")."; 
    echo "<br>";
    echo "Your zipcode is " . $zipcode . ". "; 
    echo "<br>";
    echo "Current Hour is " . date("H") . ". ";
    echo "<br>";
    echo "We have analyzed " . $analyzedDay . ". ";
    }
} else { 
    echo "///";
    echo "Bad Request.";
    echo "///";
    echo "2"; //
}

?>