<!doctype html>
<html lang="en">
  <head>
  </head>
  <body>
	
	<?php
	echo 'A few lines of PHP should have just sent an email to masimpson123@gmail.com';
	$to = "masimpson123@gmail.com";
	$subject = "My subject";
	$txt = "Hello world!";
	$headers = "From: michael@michaelsimpsondesign.com";
	mail($to,$subject,$txt,$headers);
	?> 
	
  </body>
</html>
