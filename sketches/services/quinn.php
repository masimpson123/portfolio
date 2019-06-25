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
    $oneDay = 86400;
    $oneHour = 3600;
    $oneMin = 60;
    $currentTime = time();
    $timeIn = ($timeIn<10) ? "0" . $timeIn : $timeIn;
    $timeIn = ($timeIn<100) ? "0" . $timeIn : $timeIn;
    $timeIn = ($timeIn<1000) ? "0" . $timeIn : $timeIn;
    $timeOut = ($timeOut<10) ? "0" . $timeOut : $timeOut;
    $timeOut = ($timeOut<100) ? "0" . $timeOut : $timeOut;
    $timeOut = ($timeOut<1000) ? "0" . $timeOut : $timeOut;
    $trueTimeIn = strtotime("today" . $timeIn);
    $trueTimeOut = strtotime("today" . $timeOut);
    $roundedTimeIn = $trueTimeIn;
    $minutes = $roundedTimeIn%3600;
    $roundedTimeIn -= $minutes;
    $roundedTimeIn = ($minutes > 1800) ? $roundedTimeIn + $oneHour : $roundedTimeIn;
    $roundedTimeOut = $trueTimeOut;
    $minutes = $roundedTimeOut%3600;
    $roundedTimeOut -= $minutes;
    $roundedTimeOut = ($minutes > 1800) ? $roundedTimeOut + $oneHour : $roundedTimeOut;
    $counselDayShiftTime = $trueTimeIn + ($oneHour*2);
    if($currentTime > $counselDayShiftTime){
        $trueTimeIn = $trueTimeIn + $oneDay;
        $trueTimeOut = $trueTimeOut + $oneDay;
        $roundedTimeIn = $roundedTimeIn + $oneDay;
        $roundedTimeOut = $roundedTimeOut + $oneDay;
    }
    if($trueTimeIn > $trueTimeOut){
        $trueTimeOut = $trueTimeOut + $oneDay;
        $roundedTimeOut = $roundedTimeOut + $oneDay;
    }
    $sunriseToday = 0;
    $sunsetToday = 0;
    $sunriseTomorrow = 0;
    $sunsetTomorrow = 0;
    $url = "https://api.weatherbit.io/v2.0/forecast/hourly?postal_code=" . $zipcode . "&country=United%20States&key=fdf0338583c542c08f395c259700a693&units=I";
    $contents = file_get_contents($url);
    $data = json_decode($contents, TRUE);
    //echo json_encode($data);
    foreach($data["data"] as $item) {
        if ($item["ts"] == $roundedTimeIn || $item["ts"] == $roundedTimeOut) {
            $analyzedWeather = $analyzedWeather . "<br>" . json_encode($item);
            if($item["temp"] > $maxTemp){
                    $goodWeather = false;
                    $reasonsToNotBike = $reasonsToNotBike . "Too Hot " . $item["temp"];
            }
            if($item["temp"] < $minTemp){
                    $goodWeather = false;
                    $reasonsToNotBike = $reasonsToNotBike . "Too Cold " . $item["temp"];
            }
            if(strpos(strtolower($item["weather"]["description"]),"rain") !== false){
                if ($rainTolerance == 0) {
                    $goodWeather = false;
                    $reasonsToNotBike = $reasonsToNotBike . "Rain";
                }
            }
        }
    }
    if($nightRider == 0){
        $url = "http://api.openweathermap.org/data/2.5/weather?zip=" . $zipcode . "&units=imperial&appid=ae90bbba41d65b1f047a019e0a55de96&mode=xml";
        $contents = file_get_contents($url);
        $xml = simplexml_load_string($contents);
        date_default_timezone_set("UTC");
        $sunriseToday = strtotime($xml->city->sun['rise']);
        $sunsetToday = strtotime($xml->city->sun['set']);
        $sunriseTomorrow = $sunriseToday + $oneDay;
        $sunsetTomorrow = $sunsetToday + $oneDay;
        date_default_timezone_set("America/Chicago");
        if(
        $trueTimeIn < $sunriseToday || 
        ($trueTimeIn > $sunsetToday && $trueTimeIn < $sunriseTomorrow) ||
        $trueTimeIn > $sunsetTomorrow ||
        $trueTimeOut < $sunriseToday || 
        ($trueTimeOut > $sunsetToday && $trueTimeOut < $sunriseTomorrow) ||
        $trueTimeOut > $sunsetTomorrow
        ){
            $goodWeather = false;
            $reasonsToNotBike = $reasonsToNotBike . "Darkness";
        }
    }
    $counsel = ($goodWeather == true) ? 1 : 0;
    echo '{"AnalyzedDay":"'.date("D M d", $roundedTimeIn).'","Counsel":"'.$counsel.'","Rationale":"'.$reasonsToNotBike.'"}';  
    if ($maintenance == 1) {
        echo "<span style='font-family:sans-serif;line-height:150%;'>";
        echo "<br>";
        echo "<br>";
        echo "<hr>";
        echo "<br>";
        echo "<b>zipcode</b> from client is " . $zipcode . ". "; 
        echo "<br>";
        echo "<b>minTemp</b> from client is " . $minTemp . ". "; 
        echo "<br>";
        echo "<b>maxTemp</b> from client is " . $maxTemp . ". "; 
        echo "<br>";
        echo "<b>timeIn</b> from client is " . $timeIn . ". "; 
        echo "<br>";
        echo "<b>timeOut</b> from client is " . $timeOut . ". "; 
        echo "<br>";
        echo "<br>";
        echo "<hr>";
        echo "<br>";
        echo "<b>currentTime</b> is " . $currentTime . " (" . date("D M d g:ia",$currentTime) . ").";
        echo "<br>";
        echo "<b>counselDayShiftTime</b> is " . $counselDayShiftTime . " (" . date("D M d g:ia",$counselDayShiftTime) . ").";
        echo "<br>";
        echo "<b>trueTimeIn</b> is " . $trueTimeIn . " (" . date("D M d g:ia",$trueTimeIn) . ").";
        echo "<br>";
        echo "<b>trueTimeOut</b> is " . $trueTimeOut . " (" . date("D M d g:ia",$trueTimeOut) . ").";
        echo "<br>";
        echo "<b>roundedTimeIn</b> is " . $roundedTimeIn . " (" . date("D M d g:ia",$roundedTimeIn) . ").";
        echo "<br>";
        echo "<b>roundedTimeOut</b> is " . $roundedTimeOut . " (" . date("D M d g:ia",$roundedTimeOut) . ").";
        echo "<br>";
        if($nightRider == 0){
            echo "<b>sunriseToday</b> is " . $sunriseToday . " (" . date("D M d g:ia",$sunriseToday) . ").";
            echo "<br>";
            echo "<b>sunsetToday</b> is " . $sunsetToday . " (" . date("D M d g:ia",$sunsetToday) . ").";
            echo "<br>";
            echo "<b>sunriseTomorrow</b> is " . $sunriseTomorrow . " (" . date("D M d g:ia",$sunriseTomorrow) . ").";
            echo "<br>";
            echo "<b>sunsetTomorrow</b> is " . $sunsetTomorrow . " (" . date("D M d g:ia",$sunsetTomorrow) . ").";
            echo "<br>";
        }
        echo "<br>";
        echo "<hr>";
        echo "<br>";
        echo "Reasons to not bike: " . $reasonsToNotBike;
        echo "<br>";
        echo "Here is the weather Quinn analyzed: " . $analyzedWeather;
        echo "<br>";
        echo "The response is in Unix time.";
        echo "<br>";
        echo "<br>";
        echo "<hr>";
        echo "</span>";
    }
} else {
    echo '{"AnalyzedDay":"Bad Request","Counsel":"2","Rationale":""}';
}
?>