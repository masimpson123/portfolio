<?php
if(
is_numeric($_GET["zipcode"]) &&
is_numeric($_GET["minTemp"]) &&
is_numeric($_GET["maxTemp"]) &&
is_numeric($_GET["timeIn"]) &&
is_numeric($_GET["timeOut"]) &&
is_numeric($_GET["rainTolerance"]) &&
is_numeric($_GET["parameterUpdate"]) &&
is_numeric($_GET["maintenance"]) &&
strlen($_GET["zipcode"]) == 5 &&
(strlen($_GET["minTemp"]) == 1 || strlen($_GET["minTemp"]) == 2 || strlen($_GET["minTemp"]) == 3) &&
(strlen($_GET["maxTemp"]) == 1 || strlen($_GET["maxTemp"]) == 2 || strlen($_GET["maxTemp"]) == 3) &&
(strlen($_GET["timeIn"]) == 1 || strlen($_GET["timeIn"]) == 2 || strlen($_GET["timeIn"]) == 3 || strlen($_GET["timeIn"]) == 4) &&
(strlen($_GET["timeOut"]) == 1 || strlen($_GET["timeOut"]) == 2 || strlen($_GET["timeOut"]) == 3 || strlen($_GET["timeOut"]) == 4) &&
strlen($_GET["rainTolerance"]) == 1 &&
strlen($_GET["parameterUpdate"]) == 1 &&
strlen($_GET["maintenance"]) == 1 &&
($_GET["zipcode"] >= 0 && $_GET["zipcode"] <= 99999) &&
($_GET["minTemp"] >= -50 && $_GET["minTemp"] <= 150) &&
($_GET["maxTemp"] >= -50 && $_GET["maxTemp"] <= 150) &&
($_GET["timeIn"] >= 0 && $_GET["timeIn"] <= 2400) &&
($_GET["timeOut"] >= 0 && $_GET["timeOut"] <= 2400) &&
($_GET["rainTolerance"] == 0 || $_GET["rainTolerance"] == 1) &&
($_GET["parameterUpdate"] == 0 || $_GET["parameterUpdate"] == 1) &&
($_GET["maintenance"] == 0 || $_GET["maintenance"] == 1)
){
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
    $currentTime = time();
    $timeIn = ($timeIn % 100 > 30) ? ceil($timeIn/100)*100 : floor($timeIn/100)*100;
    $timeIn = ($timeIn < 1000 && $timeIn >= 100) ? "0" . $timeIn : $timeIn;
    $timeIn = ($timeIn < 100) ? "000" . $timeIn : $timeIn;
    $timeIn = strtotime("today" . $timeIn);
    $timeOut = ($timeOut % 100) > 30 ? ceil($timeOut/100)*100 : floor($timeOut/100)*100;
    $timeOut = ($timeOut < 1000 && $timeOut >= 100) ? "0" . $timeOut : $timeOut;
    $timeOut = ($timeOut < 100) ? "000" . $timeOut : $timeOut;
    $timeOut = strtotime("today" . $timeOut);
    $timeOut = ($currentTime>($timeIn+3600)) ? $timeOut + 86400 : $timeOut;
    $timeIn = ($currentTime>($timeIn+3600)) ? $timeIn + 86400 : $timeIn;
    $timeOut = ($timeOut <= $timeIn) ? $timeOut + 86400 : $timeOut;
    $counselBlackOutStart = $timeIn-3600;
    $counselBlackOutEnd = $timeIn+3600;
    if($parameterUpdate == 0 && ($currentTime>=$counselBlackOutStart && $currentTime<=$counselBlackOutEnd)){
        echo "///";
        echo "BAU";
        echo "///";
        echo "4";
    } else if ($parameterUpdate == 1 || $currentTime>=$counselBlackOutStart || $currentTime<=$counselBlackOutEnd) {
        $url = "http://api.openweathermap.org/data/2.5/forecast/hourly?zip=" . $zipcode . "&units=imperial&appid=ae90bbba41d65b1f047a019e0a55de96&cnt=48";
        $contents = file_get_contents($url);
        $data = json_decode($contents, TRUE);
        foreach($data["list"] as $item) {
            if ($item["dt"] == $timeIn || $item["dt"] == $timeOut) {
                $analyzedWeather = $analyzedWeather . "<br>" . json_encode($item);
                if($item["main"]["temp"] < $minTemp || $item["main"]["temp"] > $maxTemp){
                        $goodWeather = false;
                        $reasonsToNotBike = $reasonsToNotBike . "///temperature" . "///" . $item["main"]["temp"];
                }
                if(strpos(strtolower($item["weather"][0]["main"]),"rain") !== false){
                    if ($rainTolerance == 0) {
                        $goodWeather = false;
                        $reasonsToNotBike = $reasonsToNotBike . "///rain";
                    }
                }
            }
        }
        echo "///";
        echo date("D M d", $timeIn);
        echo "///";
        $counsel = ($goodWeather == true) ? 1 : 0;
        echo $counsel;
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
        echo "Your rounded timeIn is " . $timeIn . ", (" . date("D M d g:ia",$timeIn) . ").";
        echo "<br>";
        echo "Your rounded timeOut is " . $timeOut . ", (" . date("D M d g:ia",$timeOut) . ").";
        echo "<br>";
        echo "Reasons to not bike: " . $reasonsToNotBike;
        echo "<span style='color:red;font-weight: bold;'>";
        echo "<br>";
        echo "Here is the weather Quinn analyzed: " . $analyzedWeather;
        echo "<br>";
        echo "The response is in Unix time, which is 5hrs ahead.";
        echo "</span>";
        echo "<br>";
        echo "The Current Time is " . $currentTime . ", (" . date("D M d g:ia",$currentTime) . ").";
        echo "<br>";
        echo "Counsel Black Out Starts at Hour " . $counselBlackOutStart . ", (" . date("D M d g:ia",$counselBlackOutStart) . ").";
        echo "<br>";
        echo "Counsel Black Out Ends at Hour " . $counselBlackOutEnd . ", (" . date("D M d g:ia",$counselBlackOutEnd) . ").";
        echo "</span>";
    }
} else {
    echo "///";
    echo "Bad Request";
    echo "///";
    echo "2";
}
?>