<?php

$password = $_POST["password"];

if($password == 'bingo'){ 
echo <<<EOT

<!-- MAIN PAGE -->
<!-- MAIN PAGE -->
<!-- MAIN PAGE -->


<div id="mainPage">

<div id="nav">
    <div id="insideLogo" onclick="exitSite()" class="topNavItem cursorDefault whiteBackground">
        <div class="insideLogoHotSpot">
        <img class="insideLogo blueLogo displayBlock" src="icons/logoBlue.png" alt="Logo">
        <img class="insideLogo greenLogo displayNone" src="icons/logoGreen.png" alt="Logo">
        </div>
    </div>
    <div class="topNavItem topNavItemBtn" id="p01" onclick="ProjectReveal1(this);addSelectedClassTopNav(this)" onmouseover="yellowBG(this)" onmouseout="topNavBtnSetter(this)">
        <div class="topNavItemTxt copy">Sonosite</div>
    </div>
    <div class="topNavItem topNavItemBtn" id="p02" onclick="ProjectReveal2(this);addSelectedClassTopNav(this)" onmouseover="yellowBG(this)" onmouseout="topNavBtnSetter(this)">
        <div class="topNavItemTxt copy">Glide</div>
    </div>
    <div class="topNavItem topNavItemBtn noMouse" id="p03" onclick="ProjectReveal3(this);addSelectedClassTopNav(this)" onmouseover="yellowBG(this)" onmouseout="topNavBtnSetter(this)">
        <div class="topNavItemTxt copy">Coming Soon</div>
    </div>
    <div class="topNavItem topNavItemBtn noMouse" id="p04" onclick="ProjectReveal4(this);addSelectedClassTopNav(this)" onmouseover="yellowBG(this)" onmouseout="topNavBtnSetter(this)">
        <div class="topNavItemTxt copy">Coming Soon</div>
    </div>
    <div class="topNavItem topNavItemBtn" id="p05" onclick="ProjectReveal5(this);addSelectedClassTopNav(this)" onmouseover="yellowBG(this)" onmouseout="topNavBtnSetter(this)">
        <div class="topNavItemTxt copy">Boost</div>
    </div>
    <div class="topNavItem topNavItemBtn" id="p06" onclick="ProjectReveal6(this);addSelectedClassTopNav(this)" onmouseover="yellowBG(this)" onmouseout="topNavBtnSetter(this)">
        <div class="topNavItemTxt copy">Visual</div>
    </div>
</div>

<!--MAGICBOX-->

<div class="magicBoxHolder" id="magicBoxHolder" onmouseover="arrowsReveal()" onmouseout="arrowsHide()">

    <div id="arrows">
        <div class="arrow leftArrow" id="leftArrow" onmouseover="yellowBG(this)" onmouseout="blueBG(this)"><img class="arrowIconLeft" src="icons/arrowLeft.png" alt="Left Arrow"/></div>
        <div class="arrow rightArrow" id="rightArrow" onmouseover="yellowBG(this)" onmouseout="blueBG(this)"><img class="arrowIconRight" src="icons/arrowRight.png" alt="Right Arrow"/></div>
    </div>

    <a id="openBtnLink" href="" target="blank"><div id="openBtn" onmouseover="yellowBG(this)" onmouseout="blueBG(this)"><img class="openBtnIcon" src="icons/iconOpen.png" alt="Open Button"></div></a>	

    <div id="magicBox">
        <div id="loadingSpinnerBG"></div>
        <div id="loadingSpinner"><img class="loadingGraphic" src="icons/loading.gif" alt="Loading Hammer"/></div>
        <img onload="enableUI()" id="picture" src="" alt="Important Image"/>
        <iframe id="bonusVideo" class="video" src="https://player.vimeo.com/video/170714674" allowfullscreen></iframe>
    </div>
</div>

<!--ONE-->

<div class="project" id="FirstProject">
    <div class="subNavHolder">
        <div class="subNavItemHolderHolder">
            <div class="subNavItemHolder">
                <div class="subNavItem copy" onclick="changeMedia1();addSelectedClass(this)" onmouseover="yellowBG(this)" onmouseout="toggleSetter(this)">
                <div class="subNavItemTxt">1</div>
                </div>
                <div class="subNavItem copy" onclick="changeMedia2();addSelectedClass(this)" onmouseover="yellowBG(this)" onmouseout="toggleSetter(this)">
                <div class="subNavItemTxt">2</div>
                </div>
                <div class="subNavItem copy" onclick="changeMedia3();addSelectedClass(this)" onmouseover="yellowBG(this)" onmouseout="toggleSetter(this)">
                <div class="subNavItemTxt">3</div>
                </div>
                <div class="subNavItem copy" onclick="changeMedia4();addSelectedClass(this)" onmouseover="yellowBG(this)" onmouseout="toggleSetter(this)">
                <div class="subNavItemTxt">4</div>
                </div>
                <div class="subNavItem copy" onclick="changeMedia5();addSelectedClass(this)" onmouseover="yellowBG(this)" onmouseout="toggleSetter(this)">
                <div class="subNavItemIcon"><img alt="Open Prototype" class="icon iconDark" src="icons/subNavIconInteractionDark.png"><img alt="Open Prototype" class="icon iconLight" src="icons/subNavIconInteractionLight.png"></div>
                </div>
            </div>
        </div>
        <div class="descriptionHolder">
            <div class="copy description">
            <div id="sonositeText"></div>
            </div>
        </div>
    </div>
</div>

<!--PROJECT TWO - CHANGEMEDIA FUNCTION 10-18 ARE RESERVED FOR PROJECT TWO-->

<div class="project" id="SecondProject">
    <div class="subNavHolder">
        <div class="subNavItemHolderHolder">
            <div class="subNavItemHolder">
                <div class="subNavItem copy" onclick="changeMedia10();addSelectedClass(this)" onmouseover="yellowBG(this)" onmouseout="toggleSetter(this)">
                <div class="subNavItemTxt">1</div>
                </div>
                <div class="subNavItem copy" onclick="changeMedia11();addSelectedClass(this)" onmouseover="yellowBG(this)" onmouseout="toggleSetter(this)">
                <div class="subNavItemTxt">2</div>
                </div>
                <div class="subNavItem copy" onclick="changeMedia12();addSelectedClass(this)" onmouseover="yellowBG(this)" onmouseout="toggleSetter(this)">
                <div class="subNavItemTxt">3</div>
                </div>
                <div class="subNavItem copy" onclick="changeMedia13();addSelectedClass(this)" onmouseover="yellowBG(this)" onmouseout="toggleSetter(this)">
                <div class="subNavItemTxt">4</div>
                </div>
                <div class="subNavItem copy" onclick="changeMedia14();addSelectedClass(this)" onmouseover="yellowBG(this)" onmouseout="toggleSetter(this)">
                <div class="subNavItemTxt">5</div>
                </div>
            </div>
        </div>
        <div class="descriptionHolder">
            <div class="copy description">
            <div id="glideText"></div>
            </div>
        </div>
    </div>
</div>

<!--THIRD-->

<div class="project" id="ThirdProject">
    <div class="subNavHolder">
        <div class="subNavItemHolderHolder">
            <div class="subNavItemHolder">
            </div>
        </div>
        <div class="descriptionHolder">
            <div class="copy description">
            <div id=""></div>
            </div>
        </div>
    </div>
</div>

<!--FOURTH-->

<div class="project" id="FourthProject">
    <div class="subNavHolder">
        <div class="subNavItemHolderHolder">
            <div class="subNavItemHolder">
            </div>
        </div>
        <div class="descriptionHolder">
            <div class="copy description">
            <div id=""></div>
            </div>
        </div>
    </div>
</div>

<!--FIFTH-->

<div class="project" id="FifthProject">
    <div class="subNavHolder">
        <div class="subNavItemHolderHolder">
            <div class="subNavItemHolder">
                <div class="subNavItem copy" onclick="changeMedia37();addSelectedClass(this)" onmouseover="yellowBG(this)" onmouseout="toggleSetter(this)">
                <div class="subNavItemTxt">1</div>
                </div>
                <div class="subNavItem copy" onclick="changeMedia38();addSelectedClass(this)" onmouseover="yellowBG(this)" onmouseout="toggleSetter(this)">
                <div class="subNavItemTxt">2</div>
                </div>
                <div class="subNavItem copy" onclick="changeMedia39();addSelectedClass(this)" onmouseover="yellowBG(this)" onmouseout="toggleSetter(this)">
                <div class="subNavItemTxt">3</div>
                </div>
                <div class="subNavItem" onclick="changeMedia40();addSelectedClass(this)" onmouseover="yellowBG(this)" onmouseout="toggleSetter(this)">
                <div class="subNavItemIcon"><img alt="Open Prototype" class="icon iconDark" src="icons/subNavIconInteractionDark.png"><img alt="Open Prototype" class="icon iconLight" src="icons/subNavIconInteractionLight.png"></div>
                </div>
            </div>
        </div>
        <div class="descriptionHolder">
            <div class="copy description">
            <div id="boostText"></div>
            </div>
        </div>
    </div>
</div>

<!--SIXTH-->

<div class="project" id="SixthProject">
    <div class="subNavHolder">
        <div class="subNavItemHolderHolder">
            <div class="subNavItemHolder">
                <div class="subNavItem copy" onclick="changeMedia46();addSelectedClass(this)" onmouseover="yellowBG(this)" onmouseout="toggleSetter(this)">
                <div class="subNavItemIcon"><img alt="Watch Motion Reel" class="icon iconDark" src="icons/subNavIconVideoDark.png"><img alt="Watch Motion Reel" class="icon iconLight" src="icons/subNavIconVideoLight.png"></div>
                </div>
                <div class="subNavItem copy" onclick="changeMedia47();addSelectedClass(this)" onmouseover="yellowBG(this)" onmouseout="toggleSetter(this)">
                <div class="subNavItemIcon"><img alt="Open Task Flows" class="icon iconDark" src="icons/subNavIconDocumentDark.png"><img alt="Open Task Flows" class="icon iconLight" src="icons/subNavIconDocumentLight.png"></div>
                </div>
                <div class="subNavItem copy" onclick="changeMedia48();addSelectedClass(this)" onmouseover="yellowBG(this)" onmouseout="toggleSetter(this)">
                <div class="subNavItemIcon"><img alt="Open Task Flows" class="icon iconDark" src="icons/subNavIconDocumentDark.png"><img alt="Open Task Flows" class="icon iconLight" src="icons/subNavIconDocumentLight.png"></div>
                </div>
            </div>
        </div>
        <div class="descriptionHolder">
            <div class="copy description">
            <div id="bonusText"></div>
            </div>
        </div>
    </div>
</div>

</div> <!-- close mainPage -->

EOT;
}
    
?>