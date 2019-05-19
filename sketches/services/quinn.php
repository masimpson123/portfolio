<?php
if(
is_numeric($_GET["zipcode"]) &&
is_numeric($_GET["minTemp"]) &&
is_numeric($_GET["maxTemp"]) &&
is_numeric($_GET["timeIn"]) &&
is_numeric($_GET["timeOut"]) &&
is_numeric($_GET["rainTolerance"]) &&
is_numeric($_GET["nightRider"]) &&
is_numeric($_GET["parameterUpdate"]) &&
is_numeric($_GET["maintenance"]) &&
strlen($_GET["zipcode"]) == 5 &&
(strlen($_GET["minTemp"]) == 1 || strlen($_GET["minTemp"]) == 2 || strlen($_GET["minTemp"]) == 3) &&
(strlen($_GET["maxTemp"]) == 1 || strlen($_GET["maxTemp"]) == 2 || strlen($_GET["maxTemp"]) == 3) &&
(strlen($_GET["timeIn"]) == 1 || strlen($_GET["timeIn"]) == 2 || strlen($_GET["timeIn"]) == 3 || strlen($_GET["timeIn"]) == 4) &&
(strlen($_GET["timeOut"]) == 1 || strlen($_GET["timeOut"]) == 2 || strlen($_GET["timeOut"]) == 3 || strlen($_GET["timeOut"]) == 4) &&
strlen($_GET["rainTolerance"]) == 1 &&
strlen($_GET["nightRider"]) == 1 &&
strlen($_GET["parameterUpdate"]) == 1 &&
strlen($_GET["maintenance"]) == 1 &&
($_GET["zipcode"] >= 0 && $_GET["zipcode"] <= 99999) &&
($_GET["minTemp"] >= -50 && $_GET["minTemp"] <= 150) &&
($_GET["maxTemp"] >= -50 && $_GET["maxTemp"] <= 150) &&
($_GET["timeIn"] >= 0 && $_GET["timeIn"] <= 2400) &&
($_GET["timeOut"] >= 0 && $_GET["timeOut"] <= 2400) &&
($_GET["rainTolerance"] == 0 || $_GET["rainTolerance"] == 1) &&
($_GET["nightRider"] == 0 || $_GET["nightRider"] == 1) &&
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
    $nightRider = $_GET["nightRider"];
    $parameterUpdate = $_GET["parameterUpdate"];
    $maintenance = $_GET["maintenance"];
    $goodWeather = true;
    $analyzedWeather = "";
    $reasonsToNotBike = "";
    $currentTime = time();
    $oneDay = 86400;
    $oneHour = 3600;
    $oneMin = 60;
    $trueTimeIn = strtotime("today" . $timeIn);
    $timeIn = ($timeIn % 100 > 30) ? ceil($timeIn/100)*100 : floor($timeIn/100)*100;
    $timeIn = ($timeIn < 1000 && $timeIn >= 100) ? "0" . $timeIn : $timeIn;
    $timeIn = ($timeIn < 100) ? "000" . $timeIn : $timeIn;
    $timeIn = strtotime("today" . $timeIn);
    $trueTimeOut = strtotime("today" . $timeOut);
    $timeOut = ($timeOut % 100) > 30 ? ceil($timeOut/100)*100 : floor($timeOut/100)*100;
    $timeOut = ($timeOut < 1000 && $timeOut >= 100) ? "0" . $timeOut : $timeOut;
    $timeOut = ($timeOut < 100) ? "000" . $timeOut : $timeOut;
    $timeOut = strtotime("today" . $timeOut);
    $timeOut = ($currentTime>($timeIn+$oneHour)) ? $timeOut + $oneDay : $timeOut;
    $timeIn = ($currentTime>($timeIn+$oneHour)) ? $timeIn + $oneDay : $timeIn;
    $timeOut = ($timeOut <= $timeIn) ? $timeOut + $oneDay : $timeOut;
    $counselBlackOutStart = $timeIn-$oneHour;
    $counselBlackOutEnd = $timeIn+$oneHour;
    if($parameterUpdate == 0 && ($currentTime>=$counselBlackOutStart && $currentTime<=$counselBlackOutEnd)){
        echo "///";
        echo "BAU";
        echo "///";
        echo "4";
    } else if ($parameterUpdate == 1 || $currentTime>=$counselBlackOutStart || $currentTime<=$counselBlackOutEnd) {
        $timeIn = ($currentTime>$timeIn) ? $counselBlackOutEnd : $timeIn;
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
        if($nightRider == 0){
            $url = "http://api.openweathermap.org/data/2.5/forecast/hourly?zip=" . $zipcode . "&units=imperial&appid=ae90bbba41d65b1f047a019e0a55de96&mode=xml";
            $contents = file_get_contents($url);
            $xml = simplexml_load_string($contents);
            date_default_timezone_set("UTC");
            $sunrise = strtotime($xml->sun['rise']);
            $sunset = strtotime($xml->sun['set']);
            date_default_timezone_set("America/Chicago");
            if($trueTimeIn < $sunrise || $trueTimeIn > $sunset || $trueTimeOut < $sunrise || $trueTimeOut > $sunset){
                $goodWeather = false;
                $reasonsToNotBike = $reasonsToNotBike . "///darkness";
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
        echo "Your rounded timeIn is " . $timeIn . " (" . date("D M d g:ia",$timeIn) . ").";
        echo "<br>";
        echo "Your rounded timeOut is " . $timeOut . " (" . date("D M d g:ia",$timeOut) . ").";
        echo "<br>";
        echo "Your true timeIn is " . $trueTimeIn . " (" . date("D M d g:ia",$trueTimeIn) . ").";
        echo "<br>";
        echo "Your true timeOut is " . $trueTimeOut . " (" . date("D M d g:ia",$trueTimeOut) . ").";
        echo "<br>";
        echo "Sunrise is " . $sunrise . " (" . date("D M d g:ia",$sunrise) . ").";
        echo "<br>";
        echo "Sunset is " . $sunset . " (" . date("D M d g:ia",$sunset) . ").";
        echo "<br>";
        echo "The Current Time is " . $currentTime . " (" . date("D M d g:ia",$currentTime) . ").";
        echo "<br>";
        echo "Counsel Black Out Starts at Hour " . $counselBlackOutStart . " (" . date("D M d g:ia",$counselBlackOutStart) . ").";
        echo "<br>";
        echo "Counsel Black Out Ends at Hour " . $counselBlackOutEnd . " (" . date("D M d g:ia",$counselBlackOutEnd) . ").";
        echo "<br>";
        echo "Reasons to not bike: " . $reasonsToNotBike;
        echo "<span style='color:red;font-weight: bold;'>";
        echo "<br>";
        echo "Here is the weather Quinn analyzed: " . $analyzedWeather;
        echo "<br>";
        echo "The response is in Unix time, which is 5hrs ahead.";
        echo "</span>";
        echo "</span>";
    }
} else {
    echo "///";
    echo "Bad Request";
    echo "///";
    echo "2";
}
?>