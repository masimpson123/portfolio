<?php

$to = $_POST["destinationEmail"];
$subject = $_POST["subject"];
$txt = $_POST["message"];
$headers = "From: michael@michaelsimpsondesign.com" . "\r\n";
$headers .= 'MIME-Version: 1.0' . "\r\n";
$headers .= "Content-Type: text/plain; charset=\"utf-8\"\r\n";
mail($to,$subject,$txt,$headers);
echo 'Your message has been sent!<br><br>';

?> 