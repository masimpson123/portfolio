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
    $analyzedWeather = "";
    $reasonsToNotBike = "";
    $commuteIn = 0;
    $commuteOut = 0;
    $analyzedDay = "";
    $adviceStop = (($timeIn/100)-1);
    $adviceStart = (($timeIn/100)+1);
    date_default_timezone_set("America/Chicago");
    if($timeIn%100>30){ //0-29min round down
        $timeIn=ceil($timeIn/100)*100;
    } 
    if($timeIn%100<=30){ //30-59min round up
        $timeIn=floor($timeIn/100)*100;
    }
    if($timeOut%100>30){
        $timeOut=ceil($timeOut/100)*100;
    }
    if($timeOut%100<=30){
        $timeOut=floor($timeOut/100)*100;
    }
    //Quinn stop updating council one hour before time in
    //Quinn start updating his council two hours after time in
    if($parameterUpdate == 0 && (date("H")>=$adviceStop && date("H")<=$adviceStart)){
        echo "///";
        echo "BAU";
        echo "///";
        echo "4"; //no face
    } else {
        if (date("H")>$adviceStart && $parameterUpdate == 0) { //after today's commute in we analyze tomorrow
            $analyzedDay = "tomorrow";
        } 
        if($parameterUpdate == 1 || date("H")<$adviceStop){ //before today's commute in we analyze today
            $analyzedDay = "today";
        }
        //We convert the users timein and timeout to unix time stamps.
        //We are given 48 forecasts.
        //We analyze one forecast that matches the $commuteIn timestamp.
        //We analyze one forecast that matches the $commuteOut timestamp.
        $commuteIn = strtotime($analyzedDay . $timeIn);
        $commuteOut = strtotime($analyzedDay . $timeOut);
        $url = "http://api.openweathermap.org/data/2.5/forecast/hourly?zip=" . $zipcode . "&units=imperial&appid=ae90bbba41d65b1f047a019e0a55de96&cnt=48";
        $contents = file_get_contents($url);
        $data = json_decode($contents, TRUE);
        foreach($data["list"] as $item) {
            if ($item["dt"] == $commuteIn || $item["dt"] == $commuteOut) {
                $analyzedWeather = $analyzedWeather . "<br>" . json_encode($item);
                if($item["main"]["temp"] < $minTemp || $item["main"]["temp"] > $maxTemp){
                        $goodWeather = false; //temp isn't right
                        $reasonsToNotBike = $reasonsToNotBike . "///temperature" . "///" . $item["main"]["temp"];
                }
                if(strpos(strtolower($item["weather"][0]["main"]),"rain") !== false){
                    if ($rainTolerance == 0) {
                        $goodWeather = false; //no rain allowed
                        $reasonsToNotBike = $reasonsToNotBike . "///rain";
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
    }
} else { 
    echo "///";
    echo "Bad Request";
    echo "///";
    echo "2"; //broken face
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
    echo "<br>";
    echo "Reasons to not bike " . $reasonsToNotBike . ". ";
    echo "<br>";
    echo "Here is the weather quinn analyzed " . $analyzedWeather;
    echo "<br>";
    echo "The response is in Unix time which is 5hrs ahead";
    echo "<br>";
    echo "Quinn stops advising at hour " . $adviceStop;
    echo "<br>";
    echo "Quinn starts advising at hour " . $adviceStart;
}
?>