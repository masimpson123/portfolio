<?php

echo "<br>";
echo "From PHP:";
echo "<br>";

//we loop through the $_POST Superglobal which is an 'associative array'
foreach ($_POST as $x => $x_value) {
    if($x == 'gender' && $x_value == 'female'){
        echo 'You are a woman.<br>';
    }
    if($x == 'gender' && $x_value == 'male'){
        echo 'You are a man.<br>';
    }
    if($x == 'dogStatus' && $x_value == 'yes'){
        echo 'You have a dog.<br>';
    }
    if($x == 'green' && $x_value == 'on'){
        echo 'You are green.<br>';
    }
    if($x == 'tough' && $x_value == 'on'){
        echo 'You are tough.<br>';
    }
    if($x == 'favoriteShow' && $x_value != ''){
        echo 'Your favorite show is '. $x_value .'.<br>';
    }
}

?>