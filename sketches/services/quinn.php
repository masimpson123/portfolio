<?php

if(isset($_GET["minTemp"]) && 
   isset($_GET["maxTemp"]) && 
   isset($_GET["zipcode"]) && 
   isset($_GET["timeIn"]) && 
   isset($_GET["timeOut"]) && 
   isset($_GET["rainTolerance"]) && 
   isset($_GET["parameterUpdate"]) && 
   isset($_GET["maintenance"])){
    date_default_timezone_set("America/Chicago");
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
    $currentHour = (int)date("H");
    $timeIn = ($timeIn % 100 > 30 ? $timeIn=ceil($timeIn/100)*100 : $timeIn);
    $timeIn = ($timeIn % 100 <= 30 ? floor($timeIn/100)*100 : $timeIn);
    $timeIn = ($timeIn < 1000 ? "0" . $timeIn : $timeIn);
    $timeOut = ($timeOut % 100 > 30 ? ceil($timeOut/100)*100 : $timeOut);
    $timeOut = ($timeOut % 100 <= 30 ? floor($timeOut/100)*100 : $timeOut);
    $timeOut = ($timeOut < 1000 ? "0" . $timeOut : $timeOut);
    $counselBlackOutStart = (($timeIn/100)-1);
    $counselBlackOutEnd = (($timeIn/100)+1);
    if($parameterUpdate == 0 && ($currentHour>=$counselBlackOutStart && $currentHour<=$counselBlackOutEnd)){
        echo "///";
        echo "BAU";
        echo "///";
        echo "4"; //no face
    } else if ($parameterUpdate == 1 || $currentHour>=$counselBlackOutStart || $currentHour<=$counselBlackOutEnd) {
        $analyzedDay = ($currentHour>=$counselBlackOutEnd) ? "tomorrow" : "today";
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
        $counsel = ($goodWeather == true) ? 1 : 0 ;
        echo $counsel
    }
    if ($maintenance == 1) {
        echo "<span style='font-family:sans-serif;line-height:150%;'>";
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
        echo "We have analyzed " . $analyzedDay . ", " . date("D M d", $commuteIn) . ". ";
        echo "<br>";
        echo "Reasons to not bike: " . $reasonsToNotBike;
        echo "<span style='color:red;font-weight: bold;'>";
        echo "<br>";
        echo "Here is the weather quinn analyzed: " . $analyzedWeather;
        echo "<br>";
        echo "The response is in Unix time, which is 5hrs ahead.";
        echo "</span>";
        echo "<br>";
        echo "Current Hour is " . $currentHour . ". ";
        echo "<br>";
        echo "Counsel Black Out Starts at hour " . $counselBlackOutStart . ". ";
        echo "<br>";
        echo "Counsel Black Out Ends at hour " . $counselBlackOutEnd . ". ";
        echo "</span>";
    }
} else { 
    echo "///";
    echo "Bad Request";
    echo "///";
    echo "2"; //broken face
}
?>