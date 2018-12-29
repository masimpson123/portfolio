var locationCounter = 0; //0 outside, 1 inside;
var glideImages = new Array();
var autoSchedulerImages = new Array();
var boostImages = new Array();
var bonusImages = new Array();
var currentProject;
var winHeight = window.innerHeight;
var winWidth = window.innerWidth;
var subNavWidth;
var topNavHeight;
var subNavHeight;
var diameterOfListItem;
var masterCardOpacity = 0;
var circles = [];
var numOfCircles = Math.round(Math.sqrt((winWidth * winHeight)/500));
var myIntervals = [];
var firstStart = 0;
var mainPageTotalHeight = 0;
var projects = [];
var subNavHolders = [];
var subNavItemHolderHolders = [];
var subNavItemHolders = [];
var descriptionHolders = [];
var descriptions = [];
var passwordHolder = "";

//DYNAMIC SITE CONSTRUCTION
var xhttpOne = new XMLHttpRequest();
xhttpOne.onreadystatechange = function() {
    if(xhttpOne.readyState == 4){
        if(x.response != ""){
            document.getElementById(y).innerHTML = x.response;
            clearInterval(schemaReturnCheckVar);
            enterSite();
        } else {
            alert("You do not have permission to enter this portfolio. Please contact Mike at 513 376 1622.");
        }
    }
}
function retrieveBody(){
    passwordHolder = document.getElementById('passwordIntake').value;
    if(passwordHolder == ""){
        document.getElementById("passwordIntake").style.display="block";
    } else {
    var formData = new FormData();
    formData.append("password", passwordHolder);
    //xhttpOne.open("POST", "http://127.0.0.1/bodyContent.php", true); //we initialize the request development
    xhttpOne.open("POST", "bodyContent.php", true); //we initialize the request production
    xhttpOne.send(formData);
    }
}

//RESPONSIVENESS

function resize_1() {
	winHeight = window.innerHeight;
	winWidth = window.innerWidth;
	var trueWidth = widthChecker(winWidth, winHeight, topNavHeight, subNavHeight);
	var margin = (winWidth - trueWidth) / 2;
	var trueMargin = marginChecker(margin);
	var videos = document.getElementsByClassName("video");
	document.getElementById("circleMaster").style.height = winHeight + "px";
	document.getElementById("circleMaster").style.width = winWidth + "px";
    if(locationCounter==1){
	document.getElementById("magicBox").style.height = trueWidth * (9 / 16) + "px";
	document.getElementById("magicBox").style.width = trueWidth + "px";
	document.getElementById("magicBoxHolder").style.maxWidth = trueWidth + "px";
	document.getElementById("magicBoxHolder").style.marginLeft = trueMargin + "px";
	document.getElementById("rightArrow").style.marginTop = ((trueWidth * (9 / 16)) / 2) - 25 + "px";
	document.getElementById("leftArrow").style.marginTop = ((trueWidth * (9 / 16)) / 2) - 25 + "px";
	document.getElementById("openBtn").style.marginTop = ((trueWidth * (9 / 16)) / 2) - 40 + "px";
	document.getElementById("openBtn").style.marginLeft = (trueWidth / 2) - 40 + "px";
	document.getElementById("loadingMsg").style.marginTop = ((trueWidth * (9 / 16)) / 2) - 35 + "px";
	document.getElementById("loadingMsg").style.marginLeft = (trueWidth / 2) - 35 + "px";
	document.getElementById("loadingMsgCard").style.height = trueWidth * (9 / 16) + "px";
    }
	document.getElementById("coolStroke_1").style.width = winWidth - 8 + "px";
	document.getElementById("coolStroke_1").style.height = winHeight - 8 + "px";
	document.getElementById("coverImg").style.marginTop = (winHeight / 2) - 35 + "px";
	for (i = 0; i < videos.length; i++) {
		videos[i].style.height = trueWidth * (9 / 16) +"px";
		videos[i].style.width = trueWidth + "px";
	}
	var goodItemArray = document.getElementsByClassName("goodItem");
	if (winWidth >= 480) { //on large screens there are 3 columns and 2 rows
		document.getElementById("boxOfGoods").style.width= 480 + "px";
		document.getElementById("boxOfGoods").style.height= 140 + "px";
		for (i = 0; i < 3; i++) { //change the first 3
		goodItemArray[i].style.marginTop = 0 + "px";
		}
		for (i = 3; i < goodItemArray.length; i++) { //change the final 3
		goodItemArray[i].style.marginTop = 30 + "px";
		}
	} else { //on small screens there is are 2 columns and 3 rows
		document.getElementById("boxOfGoods").style.width= 320 + "px";
		document.getElementById("boxOfGoods").style.height= 225 + "px";
		for (i = 0; i < 2; i++) { //change the first 2
		goodItemArray[i].style.marginTop = 0 + "px";
		}
		for (i = 2; i < goodItemArray.length; i++) { //change the final 4
		goodItemArray[i].style.marginTop = 30 + "px";
		}
	}
	var height1 = document.getElementById("outsideLogo").clientHeight;
	var height2 = document.getElementById("tagline").clientHeight;
	var height3 = document.getElementById("cvBtn").clientHeight;
	var height4 = document.getElementById("boxOfGoods").clientHeight;
	var niceMargin = (winHeight - height1 - height2 - height3 - height4)/5;
	document.getElementById("outsideLogo").style.marginTop = niceMargin + "px";
	document.getElementById("tagline").style.marginTop = niceMargin + "px";
	document.getElementById("cvOpenBtnHolder").style.marginTop = niceMargin + "px";
	document.getElementById("boxOfGoods").style.marginTop = niceMargin + "px";
	operationHorizontalCenter();
}

function operationHorizontalCenter(){
	if(locationCounter==1){
		mainPageTotalHeight = 0;
		mainPageTotalHeight = mainPageTotalHeight + document.getElementById('nav').clientHeight + 24;
		mainPageTotalHeight = mainPageTotalHeight + document.getElementById('magicBoxHolder').clientHeight;
		//descriptionHeight[0].clientHeight = 0 when you are not viewing the Glide project
		var descriptionHeight = document.getElementsByClassName('descriptionHolder');
		var relevantDescriptionHeight;
		//we identify which project is open by cycling through the array of descriptionHeights
		for(i=0;i<descriptionHeight.length;i++){
			if(descriptionHeight[i].clientHeight){
			relevantDescriptionHeight = descriptionHeight[i].clientHeight;
			}
		}
		//we add the height of the description to mainPageTotalHeight
		//subNavHeight is calculated differently based on screen width. stacked v not stacked
		if(winWidth > (subNavWidth + 400 + 10)){ //not stacked
		mainPageTotalHeight = mainPageTotalHeight + relevantDescriptionHeight + 16; //one margin involved
		} else { //stacked
		mainPageTotalHeight = mainPageTotalHeight + relevantDescriptionHeight + diameterOfListItem + 8 + 10 + 16; //three margins involved
		}	
		//we set the actual offset
		if(Math.round((winHeight - mainPageTotalHeight) / 2) > 16){
		document.getElementById('nav').style.marginTop = Math.round((winHeight - mainPageTotalHeight) / 2) + 'px';
		} else {
		document.getElementById('nav').style.marginTop = 16 + 'px';
		}
	}
}

function topNavResponse(){
    if(locationCounter==1){
	var topNavItems = document.getElementsByClassName("topNavItem");
	if (winWidth >= 882) {
		document.getElementById("nav").style.width = 882 + "px";
		document.getElementById("nav").style.height = 46 + "px";
		topNavHeight = 70;
		topNavItems[0].style.width = 110 + "px";
		for (i = 1; i < topNavItems.length; i++) {
		topNavItems[i].style.width = 110 + "px";
		}
	} else if (winWidth >= 756 && winWidth <= 883) { 
		document.getElementById("nav").style.width = 756 + "px";
		document.getElementById("nav").style.height = 92 + "px";
		topNavHeight = 116;
		topNavItems[0].style.width = 740 + "px";
		for (i = 1; i < topNavItems.length; i++) {
		topNavItems[i].style.width = 110 + "px";
		}
	} else if (winWidth >= 378 && winWidth <= 755) {
		document.getElementById("nav").style.width = 378 + "px";
		document.getElementById("nav").style.height = 138 + "px";
		topNavHeight = 162;
		topNavItems[0].style.width = 362 + "px";
		for (i = 1; i < topNavItems.length; i++) {
		topNavItems[i].style.width = 110 + "px";
		}
	} else if (winWidth <= 378) {
		document.getElementById("nav").style.width = winWidth + "px";
		document.getElementById("nav").style.height = 138 + "px";
		topNavHeight = 162;
		topNavItems[0].style.width = winWidth - 16 + "px";
		for (i = 1; i < topNavItems.length; i++) {
		topNavItems[i].style.width = Math.floor((winWidth-48)/3) + "px";
		}
	}
    }
}

function calculateSubNavWidth() {
    var powerList = document.getElementById(currentProject).getElementsByClassName("subNavItem");
    var numberOfListItems = powerList.length;
    var listItemMargin = 8;
    diameterOfListItem = 30;
    subNavWidth = (listItemMargin * (numberOfListItems * 2)) + (diameterOfListItem * numberOfListItems);
}

function subNavResponse() {
    if(locationCounter==1){
    projects = document.getElementsByClassName("project");
    subNavHolders = document.getElementsByClassName("subNavHolder");
    subNavItemHolderHolders = document.getElementsByClassName("subNavItemHolderHolder");
    subNavItemHolders = document.getElementsByClassName("subNavItemHolder");
    descriptionHolders = document.getElementsByClassName("descriptionHolder");
    descriptions = document.getElementsByClassName("description");
    if (winWidth > (subNavWidth + 400 + 10)) { //when window width is greater than slide options width and description width combined. description is 400px wide unless screen is less than 400px wide. There is a 10px gap between nav and description when they're not stacked.
        for (i = 0; i < subNavHolders.length; i++) {
        subNavHolders[i].style.width = subNavWidth + 400 + 10 + "px";
        subNavItemHolderHolders[i].style.width = subNavWidth + "px";
        subNavItemHolders[i].style.width = subNavWidth + "px";
        descriptionHolders[i].style.width = 400 + "px";
        descriptionHolders[i].style.marginLeft = 10 + "px";
        descriptionHolders[i].style.marginTop = 0 + "px";
        projects[i].style.marginTop = 16 + "px";
        descriptions[i].style.width = 400 + "px";
        descriptions[i].style.textAlign = "left";
        subNavHeight = 92;
        }
    } else { //when window width is less than slide options width and description width, stack them
        for (i = 0; i < subNavHolders.length; i++) {
        subNavHolders[i].style.width = winWidth + "px";
        subNavItemHolderHolders[i].style.width = winWidth + "px";
        subNavItemHolders[i].style.width = subNavWidth + "px";
        descriptionHolders[i].style.width = winWidth + "px";
        descriptionHolders[i].style.marginLeft = 0 + "px";
        descriptionHolders[i].style.marginTop = 16 + "px";
        projects[i].style.marginTop = 8 + "px";
        descriptions[i].style.width = Math.floor(winWidth * .88) + "px";
        descriptions[i].style.textAlign = "center";
        subNavHeight = 142;
        }
    }
    }
}

//BACKGROUND CIRCLES
function circle(marginLeftGen, marginTopGen, upperThresholdGen, lowerThresholdGen, circleID, diameterGen, stateGen) {
	this.marginLeftGen = marginLeftGen;
	this.marginTopGen = marginTopGen;
	this.upperThresholdGen = upperThresholdGen;
	this.lowerThresholdGen = lowerThresholdGen;
	this.circleID = circleID;
	this.diameterGen = diameterGen;
	this.stateGen = stateGen;
	//Each pulseGen function is pulling values from its respective object. 
	//The scope of each pulseGen function is limited to its object.
	this.pulseGen = function () {
		if(diameterGen >= upperThresholdGen){
		stateGen = 'decreasing';
		}
		if(diameterGen <= lowerThresholdGen){
		stateGen = 'increasing';
		}
		if(stateGen == 'increasing'){
		diameterGen = diameterGen + 2;
		marginLeftGen = marginLeftGen - 1;
		marginTopGen = marginTopGen - 1;
		} else {
		diameterGen = diameterGen - 2;
		marginLeftGen = marginLeftGen + 1;
		marginTopGen = marginTopGen + 1;
		}
		var generativePulse = document.getElementById(circleID);
		generativePulse.style.marginLeft = marginLeftGen + 'px';
		generativePulse.style.marginTop = marginTopGen + 'px';
		generativePulse.style.height = diameterGen + 'px';
		generativePulse.style.width = diameterGen + 'px';
		generativePulse.style.borderRadius = diameterGen/2 + 'px';
	}
}

function startBGCircles(){
	if(firstStart==0){
		document.getElementById('circleMaster').style.width = winWidth + 'px';
		document.getElementById('circleMaster').style.height = winHeight + 'px';
		for (i=0;i<numOfCircles;i++) {
			a = Math.round(((winWidth + 100) * Math.random())-50); //marginLeftGen. we add 100 for initial width of circle and subtract 50 so its center point could potentially be in top left
			b = Math.round(((winHeight + 100) * Math.random())-50); //marginTopGen
			c = Math.round(200 * Math.random() + 100); //upperThresholdGen
			d = Math.round(90 * Math.random()); //lowerThresholdGen
			e = 'circle' + i; //circleID
			f = 0; //diameterGen
			g = 'increasing'; //stateGen
			//we create the housing
			var generatedCircle = document.createElement('div');
			generatedCircle.className = "circle";
			generatedCircle.id = e; //and tie it to its engine
			generatedCircle.setAttribute("onmouseover", "circleSelect(this)");
			generatedCircle.setAttribute("onmouseout", "circleDeselect(this)");
			document.getElementById('circleMaster').appendChild(generatedCircle);
			newCircle = new circle(a,b,c,d,e,f,g);
			circles.push(newCircle);
		}
	}
	for (i=0;i<numOfCircles;i++) {
		time = Math.round(25 * Math.random())+25;
		latestInterval = setInterval(circles[i].pulseGen,time); //We create a brand new setInterval object that is calling a specific circle objects pulseGen method at a regular interval. Each circle object is tied to a specific housing.
		myIntervals.push(latestInterval); //We store the ID of the setInterval object so that we can use the ID to clear the setInterval object later.
	}
	firstStart = 1; //flag prevents us from creating another batch of circles with duplicate IDs on subsequent starts
}

function stopBGCircles(){ //We are not stopping and then starting the same setInterval objects. We are stopping all of the interval objects that have IDs stored in the array myIntervals. Then, we are creating a new batch of setInterval objects.
		for (i=0;i<myIntervals.length;i++) {
			clearInterval(myIntervals[i]);
		}
	myIntervals = []; //we empty out myIntervals because once a setInterval object has been cleared, it is irrelevant. 
}

function circleSelect(x){
    x.style.backgroundColor = '#c0c8e1';
}

function circleDeselect(x){
    x.style.backgroundColor = '#e7e9f3';
}

//GENERAL UTILITIES

function open() { //triggered on load
setTimeout(open2, 1500);
}
function open2() { //master loading card is hidden; splash page is revealed
document.getElementById("cover").style.display = "none";
startBGCircles();
}

function arrowsReveal() {
var arrowsReveal = document.getElementById("arrows").style.visibility = "visible";
}
function arrowsHide() {
var arrowsHide = document.getElementById("arrows").style.visibility = "hidden";
}

function enterSite() {
stopBGCircles();
var fadeIn = setInterval(function(){
	if (masterCardOpacity < 1) {
	masterCardOpacity += 0.05;
	document.getElementById("masterCard").style.opacity=masterCardOpacity;
	} else {
	locationCounter = 1;
	document.getElementById("splash").style.display="none";
	document.getElementById("mainPage").style.display="block";
	ProjectReveal1();
	topNavResponse();
	subNavResponse();
	calculateSubNavWidth();
	resize_1();
	clearTimeout(fadeIn)
	var fadeInPartTwo = setInterval(function(){
		if (masterCardOpacity > 0) {
		masterCardOpacity -= 0.05;
		document.getElementById("masterCard").style.opacity=masterCardOpacity;
		} else {
		clearTimeout(fadeInPartTwo)
		}
	}, 15);
	}
}, 15);
}

function exitSite() {
var fadeIn = setInterval(function(){
	if (masterCardOpacity < 1) {
	masterCardOpacity += 0.05;
	document.getElementById("masterCard").style.opacity=masterCardOpacity;
	} else {
	locationCounter = 0;
	document.getElementById("splash").style.display="block";
	document.getElementById("mainPage").style.display="none";
	resize_1();
	clearTimeout(fadeIn)
	var fadeInPartTwo = setInterval(function(){
		if (masterCardOpacity > 0) {
		masterCardOpacity -= 0.05;
		document.getElementById("masterCard").style.opacity=masterCardOpacity;
		} else {
		clearTimeout(fadeInPartTwo)
		}
	}, 15);
	}
}, 15);
startBGCircles();
}

function yellowBG(x){
x.style.backgroundColor = "#83c454";
x.style.color = "#ffffff";
}
function blueBG(x){
x.style.backgroundColor = "#3769aa";
x.style.color = "#ffffff";
}

function widthChecker(x, y, nav1, nav2){
if (x >= (y - nav1 - nav2) * (16 / 9)){ //if width of page is greater than the height of the page minus both of the navs (i.e. a wide short page)
x = (y - nav1 - nav2) * (16 / 9); //trueWidth now equals the height of the page minus both the navs times 1.778
return x;
} else {
x = x;
return x; 
}
}

function marginChecker(x){
if (x <= 0){
x = 0;
return x;
} else {
return x; 
}
}

function hideVideos() {
var videos = document.getElementsByClassName("video");
for (i=0; i<videos.length; i++) {
videos[i].style.display = "none";
}
}

//TOP NAV

function ProjectReveal1() {
currentProject = "FirstProject";
document.getElementById("FirstProject").style.display = "block";
document.getElementById("SecondProject").style.display = "none";
document.getElementById("ThirdProject").style.display = "none";
document.getElementById("FourthProject").style.display = "none";
document.getElementById("FifthProject").style.display = "none";
document.getElementById("SixthProject").style.display = "none";
changeMedia1_Helper();
//we select the first toggle
var toggles = document.getElementById("FirstProject").getElementsByClassName('subNavItem');
addSelectedClass(toggles[0]);
toggles[0].style.backgroundColor = "#3769aa";
toggles[0].style.color = "#ffffff";
//we select the proper top nav item
var allTopNavBtns = document.getElementsByClassName('topNavItemBtn');
addSelectedClassTopNav(allTopNavBtns[0]);
allTopNavBtns[0].style.backgroundColor = "#3769aa";
allTopNavBtns[0].style.color = "#ffffff";
calculateSubNavWidth();
subNavResponse();
operationHorizontalCenter();
}
function ProjectReveal2() {
currentProject = "SecondProject";
document.getElementById("FirstProject").style.display = "none";
document.getElementById("SecondProject").style.display = "block";
document.getElementById("ThirdProject").style.display = "none";
document.getElementById("FourthProject").style.display = "none";
document.getElementById("FifthProject").style.display = "none";
document.getElementById("SixthProject").style.display = "none";
changeMedia10_Helper();
//we select the first toggle
var toggles = document.getElementById("SecondProject").getElementsByClassName('subNavItem');
addSelectedClass(toggles[0]);
toggles[0].style.backgroundColor = "#3769aa";
toggles[0].style.color = "#ffffff";
//we select the proper top nav item
var allTopNavBtns = document.getElementsByClassName('topNavItemBtn');
addSelectedClassTopNav(allTopNavBtns[1]);
allTopNavBtns[1].style.backgroundColor = "#3769aa";
allTopNavBtns[1].style.color = "#ffffff";
calculateSubNavWidth();
subNavResponse();
operationHorizontalCenter();
}
function ProjectReveal3() {
currentProject = "ThirdProject";
document.getElementById("FirstProject").style.display = "none";
document.getElementById("SecondProject").style.display = "none";
document.getElementById("ThirdProject").style.display = "block";
document.getElementById("FourthProject").style.display = "none";
document.getElementById("FifthProject").style.display = "none";
document.getElementById("SixthProject").style.display = "none";
changeMedia19_Helper();
//we select the first toggle
var toggles = document.getElementById("ThirdProject").getElementsByClassName('subNavItem');
addSelectedClass(toggles[0]);
toggles[0].style.backgroundColor = "#3769aa";
toggles[0].style.color = "#ffffff";
//we select the proper top nav item
var allTopNavBtns = document.getElementsByClassName('topNavItemBtn');
addSelectedClassTopNav(allTopNavBtns[2]);
allTopNavBtns[2].style.backgroundColor = "#3769aa";
allTopNavBtns[2].style.color = "#ffffff";
calculateSubNavWidth();
subNavResponse();
operationHorizontalCenter();
}
function ProjectReveal4() {
currentProject = "FourthProject";
document.getElementById("FirstProject").style.display = "none";
document.getElementById("SecondProject").style.display = "none";
document.getElementById("ThirdProject").style.display = "none";
document.getElementById("FourthProject").style.display = "block";
document.getElementById("FifthProject").style.display = "none";
document.getElementById("SixthProject").style.display = "none";
changeMedia28_Helper();
//we select the first toggle
var toggles = document.getElementById("FourthProject").getElementsByClassName('subNavItem');
addSelectedClass(toggles[0]);
toggles[0].style.backgroundColor = "#3769aa";
toggles[0].style.color = "#ffffff";
//we select the proper top nav item
var allTopNavBtns = document.getElementsByClassName('topNavItemBtn');
addSelectedClassTopNav(allTopNavBtns[3]);
allTopNavBtns[3].style.backgroundColor = "#3769aa";
allTopNavBtns[3].style.color = "#ffffff";
calculateSubNavWidth();
subNavResponse();
operationHorizontalCenter();
}
function ProjectReveal5() {
currentProject = "FifthProject";
document.getElementById("FirstProject").style.display = "none";
document.getElementById("SecondProject").style.display = "none";
document.getElementById("ThirdProject").style.display = "none";
document.getElementById("FourthProject").style.display = "none";
document.getElementById("FifthProject").style.display = "block";
document.getElementById("SixthProject").style.display = "none";
changeMedia37_Helper();
//we select the first toggle
var toggles = document.getElementById("FifthProject").getElementsByClassName('subNavItem');
addSelectedClass(toggles[0]);
toggles[0].style.backgroundColor = "#3769aa";
toggles[0].style.color = "#ffffff";
//we select the proper top nav item
var allTopNavBtns = document.getElementsByClassName('topNavItemBtn');
addSelectedClassTopNav(allTopNavBtns[4]);
allTopNavBtns[4].style.backgroundColor = "#3769aa";
allTopNavBtns[4].style.color = "#ffffff";
calculateSubNavWidth();
subNavResponse();
operationHorizontalCenter();
}
function ProjectReveal6() {
currentProject = "SixthProject";
document.getElementById("FirstProject").style.display = "none";
document.getElementById("SecondProject").style.display = "none";
document.getElementById("ThirdProject").style.display = "none";
document.getElementById("FourthProject").style.display = "none";
document.getElementById("FifthProject").style.display = "none";
document.getElementById("SixthProject").style.display = "block";
changeMedia46_Helper();
//we select the first toggle
var toggles = document.getElementById("SixthProject").getElementsByClassName('subNavItem');
addSelectedClass(toggles[0]);
toggles[0].style.backgroundColor = "#3769aa";
toggles[0].style.color = "#ffffff";
//we select the proper top nav item
var allTopNavBtns = document.getElementsByClassName('topNavItemBtn');
addSelectedClassTopNav(allTopNavBtns[5]);
allTopNavBtns[5].style.backgroundColor = "#3769aa";
allTopNavBtns[5].style.color = "#ffffff";
calculateSubNavWidth();
subNavResponse();
operationHorizontalCenter();
}

function topNavBtnSetter(x){
	if(x.classList.contains("selected")){
	x.style.backgroundColor = "#3769aa";
	x.style.color = "#ffffff";
	} else {
	x.style.backgroundColor = "#f5f5f5";
	x.style.color = "#afafaf";
	}
}

function addSelectedClassTopNav(x){
	var allNavItems = document.getElementsByClassName('topNavItemBtn');
	for(i=0;i<allNavItems.length;i++){
	allNavItems[i].classList.remove("selected");
	allNavItems[i].style.backgroundColor = "#f5f5f5";
	allNavItems[i].style.color = "#afafaf";
	}
	x.classList.add("selected");
	x.style.backgroundColor = "#83c454";
	x.style.color = "#ffffff";
}

//MAGIC BOX MEDIA
//MAGIC BOX MEDIA
//MAGIC BOX MEDIA

function changeMediaGeneralHelper(){ //hide loading msg and enable interface
document.getElementById("loadingMsg").style.display = "none";
document.getElementById("loadingMsgCard").style.display = "none";
document.getElementById("leftArrow").style.pointerEvents = "auto";
document.getElementById("rightArrow").style.pointerEvents = "auto";
document.getElementById("nav").style.pointerEvents = "auto";
for (i=0; i<subNavHolders.length; i++) {
subNavHolders[i].style.pointerEvents = "auto";
}
}

//function changeMediaMaster(a,b,c,d,e,f){
//hideVideos();
//a is open button state
//b is picture holder state
//c is video that should be revealed
//d is left arrow value
//e is right arrow value
//f is content text
//}

// PROJECT 1 MEDIA
// changeMedia functions 1-9 are reserved for project 1

function changeMedia1_Helper() {
document.getElementById("openBtn").style.display = "none";
document.getElementById("picture").style.display = "none";
document.getElementById("loadingMsg").style.display = "block";
document.getElementById("loadingMsgCard").style.display = "block";
glideImages[0] = new Image();
glideImages[0].src = "portfolioSliderImages/glide1.jpg";
glideImages[1] = new Image();
glideImages[1].src = "portfolioSliderImages/glide2.jpg";
glideImages[2] = new Image();
glideImages[2].src = "portfolioSliderImages/glide3.jpg";
glideImages[3] = new Image();
glideImages[3].src = "portfolioSliderImages/glide4.jpg";
glideImages[4] = new Image();
glideImages[4].src = "portfolioSliderImages/glide5.jpg";
document.getElementById("leftArrow").style.pointerEvents = "none";
document.getElementById("rightArrow").style.pointerEvents = "none";
document.getElementById("glideText").innerHTML = 'Glide is an augmented reality interface that makes motorcycle travel safer, easier and more delightful. Effective visual communication allows Glide to unobtrusively share critical information. <a href="documents/glideProcess.pdf" target="blank"><span class="copy_3">Process Book.</span></a>';
document.getElementById("nav").style.pointerEvents = "none";
for (i=0; i<subNavHolders.length; i++) {
subNavHolders[i].style.pointerEvents = "none";
}
setTimeout(changeMedia1, 2000); //first piece of content in its project
setTimeout(changeMediaGeneralHelper, 3000); //hide loading msg and enable interface
}
function changeMedia1() {
hideVideos();
document.getElementById("openBtn").style.display = "none";
document.getElementById("picture").style.display = "block";
document.getElementById("picture").src = glideImages[0].src;
document.getElementById("leftArrow").setAttribute("onclick", "toggle_5('FirstProject');changeMedia5()");
document.getElementById("rightArrow").setAttribute("onclick", "toggle_2('FirstProject');changeMedia2()");
document.getElementById("glideText").innerHTML = 'Glide is an augmented reality interface that makes motorcycle travel safer, easier and more delightful. Effective visual communication allows Glide to unobtrusively share critical information. <a href="documents/glideProcess.pdf" target="blank"><span class="copy_3">Process Book.</span></a>';
}
function changeMedia2() {
hideVideos();
document.getElementById("openBtn").style.display = "none";
document.getElementById("picture").style.display = "block";
document.getElementById("picture").src = glideImages[1].src;
document.getElementById("leftArrow").setAttribute("onclick", "toggle_1('FirstProject');changeMedia1()");
document.getElementById("rightArrow").setAttribute("onclick", "toggle_3('FirstProject');changeMedia3()");
document.getElementById("glideText").innerHTML = 'Glide helps to prevent common motorcycle accidents. Riders interact with Glide through voice commands, pupil detection, and interactions with the motorcycle (e.g. leaning / braking). <a href="documents/glideProcess.pdf" target="blank"><span class="copy_3">Process Book.</span></a>';
}
function changeMedia3() {
hideVideos();
document.getElementById("openBtn").style.display = "none";
document.getElementById("picture").style.display = "block";
document.getElementById("picture").src = glideImages[2].src;
document.getElementById("leftArrow").setAttribute("onclick", "toggle_2('FirstProject');changeMedia2()");
document.getElementById("rightArrow").setAttribute("onclick", "toggle_4('FirstProject');changeMedia4()");
document.getElementById("glideText").innerHTML = 'Glide shows the rider the information they need when they need it. For the majority of the rider’s experience, Glide is completely invisible. It does not intrude on the rider’s experience. <a href="documents/glideProcess.pdf" target="blank"><span class="copy_3">Process Book.</span></a>';
}
function changeMedia4() {
hideVideos();
document.getElementById("openBtn").style.display = "none";
document.getElementById("picture").style.display = "block";
document.getElementById("picture").src = glideImages[3].src;
document.getElementById("leftArrow").setAttribute("onclick", "toggle_3('FirstProject');changeMedia3()");
document.getElementById("rightArrow").setAttribute("onclick", "toggle_5('FirstProject');changeMedia5()");
document.getElementById("glideText").innerHTML = 'Glide’s daytime UI kit presents dark bold graphics on light backgrounds. The dark graphics jump out to the rider because they heavily contrast the rider’s bright, daytime environment.  <a href="documents/glideProcess.pdf" target="blank"><span class="copy_3">Process Book.</span></a>';
}
function changeMedia5() {
hideVideos();
document.getElementById("openBtn").style.display = "none";
document.getElementById("picture").style.display = "block";
document.getElementById("picture").src = glideImages[4].src;
document.getElementById("leftArrow").setAttribute("onclick", "toggle_4('FirstProject');changeMedia4()");
document.getElementById("rightArrow").setAttribute("onclick", "toggle_1('FirstProject');changeMedia1()");
document.getElementById("glideText").innerHTML = 'Glide’s nighttime UI kit presents white graphics on dark backgrounds. The white graphics jump out to the rider because they contrast the rider’s dim, nighttime environment. <a href="documents/glideProcess.pdf" target="blank"><span class="copy_3">Process Book.</span></a>';
}
function changeMedia6() {
}
function changeMedia7() {
}
function changeMedia8() {
}
function changeMedia9() {
}

// PROJECT 2 MEDIA
// changeMedia functions 10-18 are reserved for project 2

function changeMedia10_Helper() {
}
function changeMedia10() {
}
function changeMedia11() {
}
function changeMedia12() {
}
function changeMedia13() {
}
function changeMedia14() {
}
function changeMedia15() {
}
function changeMedia16() {
}
function changeMedia17() {
}
function changeMedia18() {
}

// PROJECT 3 MEDIA
// changeMedia functions 19-27 are reserved for project 3

function changeMedia19_Helper() {
}
function changeMedia19() {
}
function changeMedia20() {
}
function changeMedia21() {
}
function changeMedia22() {
}
function changeMedia23() {
}
function changeMedia24() {
}
function changeMedia25() {
}
function changeMedia26() {
}
function changeMedia27() {
}

// PROJECT 4 MEDIA
// changeMedia functions 28-36 are reserved for project 4

function changeMedia28_Helper() {
}	
function changeMedia28() {
}
function changeMedia29() {
}
function changeMedia30() {
}
function changeMedia31() {
}
function changeMedia32() {
}
function changeMedia33() {
}
function changeMedia34() {
}
function changeMedia35() {
}
function changeMedia36() {
}

// PROJECT 5 MEDIA
// changeMedia functions 37-45 are reserved for project 5

function changeMedia37_Helper() {
document.getElementById("openBtn").style.display = "none";
document.getElementById("picture").style.display = "none";
document.getElementById("loadingMsg").style.display = "block";
document.getElementById("loadingMsgCard").style.display = "block";
boostImages[0] = new Image();
boostImages[0].src = "portfolioSliderImages/boost1.jpg";
boostImages[1] = new Image();
boostImages[1].src = "portfolioSliderImages/boost2.jpg";
boostImages[2] = new Image();
boostImages[2].src = "portfolioSliderImages/boost3.jpg";
boostImages[3] = new Image();
boostImages[3].src = "portfolioSliderImages/boost4.jpg";
document.getElementById("leftArrow").style.pointerEvents = "none";
document.getElementById("rightArrow").style.pointerEvents = "none";
document.getElementById("boostText").innerHTML = 'Boost makes exercise easier and more effective. It is a smart phone app that pushes users to exercise thoroughly and helps them to record their exercise history. <a href="documents/boostProcess.pdf" target="blank"><span class="copy_3">Process Book.</span></a>';
document.getElementById("nav").style.pointerEvents = "none";
for (i=0; i<subNavHolders.length; i++) {
subNavHolders[i].style.pointerEvents = "none";
}
setTimeout(changeMedia37, 2000); //first piece of content in its project
setTimeout(changeMediaGeneralHelper, 3000); //hide loading msg and enable interface
}
function changeMedia37() {
hideVideos();
document.getElementById("openBtn").style.display = "none";
document.getElementById("picture").style.display = "block";
document.getElementById("picture").src = boostImages[0].src;
document.getElementById("leftArrow").setAttribute("onclick", "toggle_5('FifthProject');changeMedia41()");
document.getElementById("rightArrow").setAttribute("onclick", "toggle_2('FifthProject');changeMedia38()");
document.getElementById("boostText").innerHTML = 'Boost makes exercise easier and more effective. It is a smart phone app that pushes users to exercise thoroughly and helps them to record their exercise history. <a href="documents/boostProcess.pdf" target="blank"><span class="copy_3">Process Book.</span></a>';
}
function changeMedia38() {
hideVideos();
document.getElementById("openBtn").style.display = "none";
document.getElementById("picture").style.display = "block";
document.getElementById("picture").src = boostImages[1].src;
document.getElementById("leftArrow").setAttribute("onclick", "toggle_1('FifthProject');changeMedia37()");
document.getElementById("rightArrow").setAttribute("onclick", "toggle_3('FifthProject');changeMedia39()");
document.getElementById("boostText").innerHTML = 'Users input the kind of workout that they desire (shoulder, leg, cardio, or core), and the intensity that they desire relative to their last workout (lighter, heavier, or the same). <a href="documents/boostProcess.pdf" target="blank"><span class="copy_3">Process Book.</span></a>';
}
function changeMedia39() {
hideVideos();
document.getElementById("openBtn").style.display = "none";
document.getElementById("picture").style.display = "block";
document.getElementById("picture").src = boostImages[2].src;
document.getElementById("leftArrow").setAttribute("onclick", "toggle_2('FifthProject');changeMedia38()");
document.getElementById("rightArrow").setAttribute("onclick", "toggle_4('FifthProject');changeMedia40()");
document.getElementById("boostText").innerHTML = 'Boost can more effectively create workouts if it knows what kind of equipment the user has available to them. The user can assign equipment to different workout locations. <a href="documents/boostProcess.pdf" target="blank"><span class="copy_3">Process Book.</span></a>';
}
function changeMedia40() {
hideVideos();
document.getElementById("openBtnLink").setAttribute("href","prototypes/boostPrototype/boost.html");
document.getElementById("openBtn").style.display = "block";
document.getElementById("picture").style.display = "block";
document.getElementById("picture").src = boostImages[3].src;
document.getElementById("leftArrow").setAttribute("onclick", "toggle_3('FifthProject');changeMedia39()");
document.getElementById("rightArrow").setAttribute("onclick", "toggle_1('FifthProject');changeMedia37()");
document.getElementById("boostText").innerHTML = 'This web prototype showcases core interaction patterns of Boost. The prototype was created using HTML, CSS, Javascript, Photoshop CS5, and Illustrator CS5. <a href="documents/boostProcess.pdf" target="blank"><span class="copy_3">Process Book.</span></a>';
}
function changeMedia41() {
}
function changeMedia42() {
}
function changeMedia43() {
}
function changeMedia44() {
}
function changeMedia45() {
}

// PROJECT 6 MEDIA
// changeMedia functions 46-54 are reserved for project 6

function changeMedia46_Helper() {
document.getElementById("openBtn").style.display = "none";
document.getElementById("picture").style.display = "none";
document.getElementById("loadingMsg").style.display = "block";
document.getElementById("loadingMsgCard").style.display = "block";
bonusImages[0] = new Image();
bonusImages[0].src = "portfolioSliderImages/bonus1.jpg";
bonusImages[1] = new Image();
bonusImages[1].src = "portfolioSliderImages/bonus2.jpg";
document.getElementById("leftArrow").style.pointerEvents = "none";
document.getElementById("rightArrow").style.pointerEvents = "none";
document.getElementById("bonusText").innerHTML = 'Often, the difference between a good user interface and a great user interface is effective motion design. Here is a collection of highlights from various motion design projects.';
document.getElementById("leftArrow").setAttribute("onclick", "toggle_3('SixthProject');changeMedia48()");
document.getElementById("rightArrow").setAttribute("onclick", "toggle_2('SixthProject');changeMedia47()");
document.getElementById("bonusText").innerHTML = 'Often, the difference between a good user interface and a great user interface is effective motion design. Here is a collection of highlights from various motion design projects.';
document.getElementById("nav").style.pointerEvents = "none";
for (i=0; i<subNavHolders.length; i++) {
subNavHolders[i].style.pointerEvents = "none";
}
setTimeout(changeMedia46, 2000); //first piece of content in its project
setTimeout(changeMediaGeneralHelper, 3000); //hide loading msg and enable interface
}
function changeMedia46() {
hideVideos();
document.getElementById("openBtn").style.display = "none";
document.getElementById("picture").style.display = "none";
document.getElementById("bonusVideo").style.display = "block";
document.getElementById("leftArrow").setAttribute("onclick", "toggle_3('SixthProject');changeMedia48()");
document.getElementById("rightArrow").setAttribute("onclick", "toggle_2('SixthProject');changeMedia47()");
document.getElementById("bonusText").innerHTML = 'Often, the difference between a good user interface and a great user interface is effective motion design. Here is a collection of highlights from various motion design projects.';
}
function changeMedia47() {
hideVideos();
document.getElementById("openBtnLink").setAttribute("href","documents/graphiteSketch.pdf");
document.getElementById("openBtn").style.display = "block";
document.getElementById("picture").style.display = "block";
document.getElementById("picture").src = bonusImages[0].src;
document.getElementById("leftArrow").setAttribute("onclick", "toggle_1('SixthProject');changeMedia46()");
document.getElementById("rightArrow").setAttribute("onclick", "toggle_3('SixthProject');changeMedia48()");
document.getElementById("bonusText").innerHTML = 'The drawings in this sketchbook were created using three weights of mechanical pencil: 0.9mm 2B, 0.7mm HB, and 0.5mm 2H. The pages were created in 30 - 90 minutes.';
}
function changeMedia48() {
hideVideos();
document.getElementById("openBtnLink").setAttribute("href","documents/inkSketch.pdf");
document.getElementById("openBtn").style.display = "block";
document.getElementById("picture").style.display = "block";
document.getElementById("picture").src = bonusImages[1].src;
document.getElementById("leftArrow").setAttribute("onclick", "toggle_2('SixthProject');changeMedia47()");
document.getElementById("rightArrow").setAttribute("onclick", "toggle_1('SixthProject');changeMedia46()");
document.getElementById("bonusText").innerHTML = 'The drawings in this sketchbook were created using Prismacolor colored pencils and Staedtler pigment liners. The majority of the pages were created within 45 - 90 minutes.';
}
function changeMedia49() {
}
function changeMedia50() {
}
function changeMedia51() {
}
function changeMedia52() {
}
function changeMedia53() {
}
function changeMedia54() {
}

//SUB NAV
//SUB NAV
//SUB NAV

function toggle_1(x){
var relevantToggles = document.getElementById(x).getElementsByClassName('subNavItem');
addSelectedClass(relevantToggles[0]);
}
function toggle_2(x){
var relevantToggles = document.getElementById(x).getElementsByClassName('subNavItem');
addSelectedClass(relevantToggles[1]);
}
function toggle_3(x){
var relevantToggles = document.getElementById(x).getElementsByClassName('subNavItem');
addSelectedClass(relevantToggles[2]);
}
function toggle_4(x){
var relevantToggles = document.getElementById(x).getElementsByClassName('subNavItem');
addSelectedClass(relevantToggles[3]);
}
function toggle_5(x){
var relevantToggles = document.getElementById(x).getElementsByClassName('subNavItem');
addSelectedClass(relevantToggles[4]);
}
function toggle_6(x){
var relevantToggles = document.getElementById(x).getElementsByClassName('subNavItem');
addSelectedClass(relevantToggles[5]);
}
function toggleSetter(x){
	if(x.classList.contains("selected")){
	x.style.backgroundColor = "#3769aa";
	x.style.color = "#ffffff";
	} else {
	x.style.backgroundColor = "#f5f5f5";
	x.style.color = "#afafaf";
	}
}
function addSelectedClass(x){
	var allToggles = document.getElementsByClassName('subNavItem');
	for(i=0;i<allToggles.length;i++){
	allToggles[i].classList.remove("selected");
	allToggles[i].style.backgroundColor = "#f5f5f5";
	allToggles[i].style.color = "#afafaf";
	}
	x.classList.add("selected");
	x.style.backgroundColor = "#83c454";
	x.style.color = "#ffffff";
}

//#3769aa is blue
//#f5f5f5 is light gray
//#afafaf is dark gray
//#83c454 is green
//#ffffff is white