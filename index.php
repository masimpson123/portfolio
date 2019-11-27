<!DOCTYPE html>

<html lang="en-US">

<head>

	<title>Michael Simpson</title>

	<link rel="shortcut icon" href="icons/favicon.ico" type="image/x-icon" />

	<meta charset="UTF-8">
	<meta name="keywords" content="HTML, CSS, JavaScript, Augmented Reality, Mike, Michael, Simpson, DAAP, Design, Interaction Design, Graphic Design">
	<meta name="author" content="Michael Simpson">
	<meta name="description" content="Visual Interaction Design out of Seattle, WA!">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>

	<script src="scripts.js"></script>
	<link rel="stylesheet" type="text/css" href="styles.css">

	<script>

	(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
	(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
	m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	})(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

	ga('create', 'UA-58266436-1', 'auto');
	ga('send', 'pageview');

	</script>

</head>

<body id="body" onload="open(); resize_1()" onresize="resize_1(); topNavResponse(); subNavResponse()">

	<div id="cover">
		<div id="coverImg"><img class="loadingGraphic" src="icons/loading.gif" alt="Loading Hammer"/></div>
	</div>

	<script type="text/javascript">
		var h = window.innerHeight;
		document.getElementById("coverImg").style.marginTop = (h / 2) - 35 + "px";
	</script>

	<div id="coolStroke_1"></div>

	<div id="masterCard"></div>

	<!--SPLASH-->

	<div id="splash">

		<div id="circleMaster"></div>

		<div class="welcome">
			
			<div id="outsideLogo" onclick="retrieveBody()">
				<img class="blueLogo displayBlock" src="icons/logoBlue.png" alt="Logo">
				<img class="greenLogo displayNone" src="icons/logoGreen.png" alt="Logo">
			</div>

			<img id="tagline" src="icons/tagline.png" alt="Tagline" style="pointer-events:none;"> <!-- pointer-event property needs to be inline or it is ignored -->

			<div id="cvOpenBtnHolder">
				
				<div id="cvBtn" onmouseover="yellowBG(this)" onmouseout="blueBG(this)">
                    <a href="documents/resume.pdf" target="blank">
                    <div class="cvBtnLink">
                    <div class="copy_2 cvBtnTxt">CV</div>
                    </div>
                    </a>
				</div>
				
				<div id="onwardBtn" onclick="retrieveBody()" onmouseover="yellowBG(this)" onmouseout="blueBG(this)">
				    <img class="onwardBtnArrows" alt="Right Facing Arrows" src="icons/arrowRight.png">
				</div>

                <input id="passwordIntake" class="inputPW" type="password" placeholder="password" onkeyup="inputEnterKey(event)">
				
			</div>

			<div class="copy" id="boxOfGoods">

				<div class="goodItem">
				<div class="iconHolder">
				<img class="goodItemIcon" alt="Location" src="icons/iconLocation.png"/>
				</div>
				<div class="goodItemText">
				Seattle, WA
				</div>
				</div>

				<div class="goodItem">
				<div class="iconHolder">
				<img class="goodItemIcon" alt="E-Mail" src="icons/iconMail.png"/>
				</div>
				<div class="goodItemText">
				masimpson123@gmail.com
				</div>
				</div>

				<div class="goodItem">
				<div class="iconHolder">
				<img class="goodItemIcon" alt="Phone" src="icons/iconPhone.png"/>
				</div>
				<div class="goodItemText">
				513.376.1622
				</div>
				</div>

				<div class="goodItem">
					<a href="https://github.com/masimpson123" target="blank">
					<div class="goodItemHotSpot">
						<div class="iconHolder">
							<img class="goodItemIcon goodItemIconBlack" alt="Github" src="icons/iconGithub.png"/>
							<img class="goodItemIcon goodItemIconGreen" alt="Github" src="icons/iconGithubGreen.png"/>
						</div>
						<div class="goodItemText">Github</div>
					</div>
					</a>
				</div>

				<div class="goodItem">
					<a href="https://www.linkedin.com/in/michael-simpson-915a7824" target="blank">
					<div class="goodItemHotSpot">
						<div class="iconHolder">
							<img class="goodItemIcon goodItemIconBlack" alt="Linked In" src="icons/iconLinkedIn.png"/>
							<img class="goodItemIcon goodItemIconGreen" alt="Linked In" src="icons/iconLinkedInGreen.png"/>
						</div>
						<div class="goodItemText">Linked In</div>
					</div>
					</a>
				</div>

				<div class="goodItem">
					<a href="https://www.instagram.com/mikesimpson020289/?hl=en" target="blank">
					<div class="goodItemHotSpot">
					<div class="iconHolder">
						<img class="goodItemIcon goodItemIconBlack" alt="Instagram" src="icons/iconInstagram.png"/>
						<img class="goodItemIcon goodItemIconGreen" alt="Instagram" src="icons/iconInstagramGreen.png"/>
					</div>
					<div class="goodItemText">Instagram</div>
					</div>
					</a>
				</div>

			</div> <!-- close boxOfGoods -->

		</div> <!-- close welcome -->

	</div> <!-- close splash -->

    <span id="bodyContentHolder"></span>

</body>

</html>