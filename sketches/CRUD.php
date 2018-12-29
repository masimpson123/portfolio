<!doctype html>
<html leng="en">
<head>
	<meta charset="utf-8">
	<title>Development Sketch</title>
	<meta name="description" content="Development Sketches">
	<meta name="author" content="SitePoint">
	<link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" rel="stylesheet">
	<script>
	
	var xhttpOne = new XMLHttpRequest(); //used to upload files and store file paths
	var xhttpTwo = new XMLHttpRequest(); //used to return list of file paths
	var xhttpThree = new XMLHttpRequest(); //used to return weather data
	var xhttpFour = new XMLHttpRequest(); //used to send form data to server
    var xhttpFive = new XMLHttpRequest(); //used to read MySQL database
    var xhttpSix = new XMLHttpRequest(); //used to create a MySQL database
    var xhttpSeven = new XMLHttpRequest(); //used to create a MySQL table
    var xhttpEight = new XMLHttpRequest(); //used to return all MySQL databases
    var xhttpNine = new XMLHttpRequest(); //used to insert a row in a table
	
	var arrayOfAllImages = []; //object we pass to PHP using $_POST superglobal
	
	var filePathsArray = [];
	
	var formData = {}; //object we pass to PHP using $_POST superglobal
	
	var parsedFormDataObject = "";
        
    var schemaReturnCheckVar; //used to hold intervals that wait for server responses
	
	function addImage(){ //we populate our array of images
	for(i=0;i<document.getElementById('fileMaster').files.length;i++){
		arrayOfAllImages.push(document.getElementById('fileMaster').files[i]);
	}
	console.log(arrayOfAllImages);
	}
	
	function submitForm(){ //we add each image from our array to our form and then send our form to PHP
	var fd = new FormData(); //we could create this using <form> in html
	for(i=0;i<arrayOfAllImages.length;i++){
		var file = arrayOfAllImages[i]
		console.log(file + " is added to form");
		fd.append("theFile" + i, file); //we add each image to our form
	}
	xhttpOne.open("POST", "services/uploadFileStorePath.php", true); //we initialize the request
	//xhttpOne.setRequestHeader("Content-type", "application/x-www-form-urlencoded"); //this header breaks image upload but is needed for other forms of inputs?
	xhttpOne.send(fd);
	//we reset our file input and image array
	document.getElementById('fileMaster').value = "";
	arrayOfAllImages = [];
	}
	
	function returnFilePaths(){
	xhttpTwo.open("POST", "services/returnFilePaths.php", true); //we initialize the request
	xhttpTwo.send();
	}

	function getWeather(){
	xhttpThree.open("POST", "http://api.openweathermap.org/data/2.5/weather?zip=98052&units=imperial&appid=ae90bbba41d65b1f047a019e0a55de96", true); //we initialize the request
	xhttpThree.send();
	}
	
	function parseFilePaths(){
	//we slice off the final character because it is always a comma
	//we split the string at commas into parts of an array
	filePathsArray = xhttpTwo.response.slice(0,xhttpTwo.response.length - 1).split(",");
	console.log(filePathsArray);
	createDownloadButtons();
	}
	
	function createDownloadButtons(){
	for(i=0;i<filePathsArray.length;i++){
		var anchor = document.createElement("a");
		anchor.href = filePathsArray[i];
		anchor.setAttribute("download","");
		var btn = document.createElement("button");
		anchor.appendChild(btn);
		document.getElementById('downloadButtonsHolder').appendChild(anchor);
	}
	}
	
	function gatherFormData(x){
    formData = {}
    //formData is a global object
	//There is no way to convert a form into an object with out a library, so we have to write a custom script. 
	var allInputs = document.getElementById(x).getElementsByTagName('input');
		for(i=0;i<allInputs.length;i++){ //we cycle through all the inputs of a particular form
			if(allInputs[i].type!='submit'){
				if(allInputs[i].type==='radio'){ //we ingest radio inputs in a particular way
					if(allInputs[i].checked===true){
					//console.log(allInputs[i].name + " is " + allInputs[i].value);
					formData[allInputs[i].name] = allInputs[i].value;
					}
				}
				if(allInputs[i].type==='checkbox'){ //we ingest checkboxes inputs in a particular way
					if(allInputs[i].checked===true){
					//console.log(allInputs[i].name + " is " + allInputs[i].value);
					formData[allInputs[i].name] = allInputs[i].value;
					} else {
					formData[allInputs[i].name] = "off";
					}
				}
				if(allInputs[i].type==='text'){ //we ingest text inputs in a particular way
					//console.log(allInputs[i].name + " is " + allInputs[i].value);
					formData[allInputs[i].name] = allInputs[i].value;
				}
			}
		}
		console.log(formData);
	}

	function parseFormDataObject(){
	//we convert the form data object into query string format
    //parsedFormDataObject is a globale variable and formData is a global object
	parsedFormDataObject = "";
	for (x in formData) {
		parsedFormDataObject = parsedFormDataObject + x + "=" + formData[x] + "&";
	}
	//we remove the final extra ampersand
	parsedFormDataObject = parsedFormDataObject.slice(0,parsedFormDataObject.length - 1); 
	console.log(parsedFormDataObject);
	}
	
	function sendParsedFormDataObjectToPHP(x){
    //third variable in .open determines if request is handles asynchronously or synchronously
	xhttpFour.open("POST", "services/formStudy.php", true); //we initialize the request
	xhttpFour.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttpFour.send(x);
	}    
    function readDatabaseReadTableCreateForm(x){
    gatherFormData('readDatabaseForm');
    parseFormDataObject();
 	xhttpFive.open("POST", "services/readTable.php", true); //we initialize the request
	xhttpFive.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttpFive.send(parsedFormDataObject);
    //We wait for a response to log it. If it doesn't come we clear the interval
    schemaReturnCheckVar = setInterval(schemaReturnCheckFun, 500, xhttpFive, 'tableDataAndInsertForm');
    setTimeout(clearReturnCheckFun,5000);
    }
    function insertRow(){
    gatherFormData('insertRowForm');
    parseFormDataObject();
 	xhttpNine.open("POST", "services/insertRow.php", true); //we initialize the request
	xhttpNine.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttpNine.send(parsedFormDataObject);
    //We wait for a response to log it. If it doesn't come we clear the interval
    schemaReturnCheckVar = setInterval(schemaReturnCheckFun, 500, xhttpNine, 'insertRowDatabaseResponseHolder');
    setTimeout(clearReturnCheckFun,5000);
    }
    function createDatabase(){
    gatherFormData('createDatabaseForm');
    parseFormDataObject(); //parses global formData object that gatherFormData() created;
	xhttpSix.open("POST", "services/createDatabase.php", true); //we initialize the request
	xhttpSix.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttpSix.send(parsedFormDataObject);
    }
    function createTable(){
    gatherFormData('createTableForm');
    parseFormDataObject(); //parses global formData object that gatherFormData() created;
	xhttpSeven.open("POST", "services/createTable.php", true); //we initialize the request
	xhttpSeven.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttpSeven.send(parsedFormDataObject);
    }
    function returnSchema(){
	xhttpEight.open("POST", "services/showDatabases.php", true); //we initialize the request
	xhttpEight.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttpEight.send();
    //We wait for a response to log it. If it doesn't come we clear the interval
    schemaReturnCheckVar = setInterval(schemaReturnCheckFun, 500, xhttpEight, 'schemaList');
    setTimeout(clearReturnCheckFun,5000);
    }
    function schemaReturnCheckFun(x,y){
        console.log('schema return check ran');
        if(x.response != ""){
        document.getElementById(y).innerHTML = x.response;
        clearInterval(schemaReturnCheckVar);
        }
    }
    function clearReturnCheckFun(){
    }
	
    //HTTP Request State Monitoring Functions
	xhttpOne.onreadystatechange = function() { //Tutorials want me to monitor status and ready state for reason...
	console.log('xhttpOne change detected');
	console.log('ready state: ' + xhttpOne.readyState); //0:REQUEST NOT INITIALIZED  -  1:SERVER CONNECTION ESTABLISHED  -  2:REQUEST RECEIVED  -  3:PROCESSING REQUEST  -  4:REQUEST FINISHED AND RESPONSE IS READY
	console.log('status ' + xhttpOne.status); //200:OK  -  403:FORBIDDEN  -  404:PAGE NOT FOUND 
	}
	xhttpTwo.onreadystatechange = function() { //Tutorials want me to monitor status and ready state for reason...
	console.log('xhttpTwo change detected');
	console.log('ready state: ' + xhttpTwo.readyState); //0:REQUEST NOT INITIALIZED  -  1:SERVER CONNECTION ESTABLISHED  -  2:REQUEST RECEIVED  -  3:PROCESSING REQUEST  -  4:REQUEST FINISHED AND RESPONSE IS READY
	console.log('status ' + xhttpTwo.status); //200:OK  -  403:FORBIDDEN  -  404:PAGE NOT FOUND 
	}
	xhttpThree.onreadystatechange = function() { //Tutorials want me to monitor status and ready state for reason...
	console.log('xhttpThree change detected');
	console.log('ready state: ' + xhttpThree.readyState); //0:REQUEST NOT INITIALIZED  -  1:SERVER CONNECTION ESTABLISHED  -  2:REQUEST RECEIVED  -  3:PROCESSING REQUEST  -  4:REQUEST FINISHED AND RESPONSE IS READY
	console.log('status ' + xhttpThree.status); //200:OK  -  403:FORBIDDEN  -  404:PAGE NOT FOUND 
	}	
	xhttpFour.onreadystatechange = function() { //Tutorials want me to monitor status and ready state for reason...
	console.log('xhttpFour change detected');
	console.log('ready state: ' + xhttpFour.readyState); //0:REQUEST NOT INITIALIZED  -  1:SERVER CONNECTION ESTABLISHED  -  2:REQUEST RECEIVED  -  3:PROCESSING REQUEST  -  4:REQUEST FINISHED AND RESPONSE IS READY
	console.log('status ' + xhttpFour.status); //200:OK  -  403:FORBIDDEN  -  404:PAGE NOT FOUND 
	}   
	xhttpFive.onreadystatechange = function() { //Tutorials want me to monitor status and ready state for reason...
	console.log('xhttpFive change detected');
	console.log('ready state: ' + xhttpFive.readyState); //0:REQUEST NOT INITIALIZED  -  1:SERVER CONNECTION ESTABLISHED  -  2:REQUEST RECEIVED  -  3:PROCESSING REQUEST  -  4:REQUEST FINISHED AND RESPONSE IS READY
	console.log('status ' + xhttpFive.status); //200:OK  -  403:FORBIDDEN  -  404:PAGE NOT FOUND 
	}
	xhttpSix.onreadystatechange = function() { //Tutorials want me to monitor status and ready state for reason...
	console.log('xhttpSix change detected');
	console.log('ready state: ' + xhttpSix.readyState); //0:REQUEST NOT INITIALIZED  -  1:SERVER CONNECTION ESTABLISHED  -  2:REQUEST RECEIVED  -  3:PROCESSING REQUEST  -  4:REQUEST FINISHED AND RESPONSE IS READY
	console.log('status ' + xhttpSix.status); //200:OK  -  403:FORBIDDEN  -  404:PAGE NOT FOUND 
	}
	xhttpSeven.onreadystatechange = function() { //Tutorials want me to monitor status and ready state for reason...
	console.log('xhttpSeven change detected');
	console.log('ready state: ' + xhttpSeven.readyState); //0:REQUEST NOT INITIALIZED  -  1:SERVER CONNECTION ESTABLISHED  -  2:REQUEST RECEIVED  -  3:PROCESSING REQUEST  -  4:REQUEST FINISHED AND RESPONSE IS READY
	console.log('status ' + xhttpSeven.status); //200:OK  -  403:FORBIDDEN  -  404:PAGE NOT FOUND 
	}
	xhttpEight.onreadystatechange = function() { //Tutorials want me to monitor status and ready state for reason...
	console.log('xhttpEight change detected');
	console.log('ready state: ' + xhttpEight.readyState); //0:REQUEST NOT INITIALIZED  -  1:SERVER CONNECTION ESTABLISHED  -  2:REQUEST RECEIVED  -  3:PROCESSING REQUEST  -  4:REQUEST FINISHED AND RESPONSE IS READY
	console.log('status ' + xhttpEight.status); //200:OK  -  403:FORBIDDEN  -  404:PAGE NOT FOUND 
	}
	xhttpNine.onreadystatechange = function() { //Tutorials want me to monitor status and ready state for reason...
	console.log('xhttpNine change detected');
	console.log('ready state: ' + xhttpNine.readyState); //0:REQUEST NOT INITIALIZED  -  1:SERVER CONNECTION ESTABLISHED  -  2:REQUEST RECEIVED  -  3:PROCESSING REQUEST  -  4:REQUEST FINISHED AND RESPONSE IS READY
	console.log('status ' + xhttpNine.status); //200:OK  -  403:FORBIDDEN  -  404:PAGE NOT FOUND
	}
	
    //Server Response Loggin Functions
	function logFileUploadResponses(){
	console.log("FILE UPLOAD 1");
	console.log("xhttpOne:");
	console.log(xhttpOne.response);
	console.log("FILE UPLOAD 2");
	console.log("xhttpTwo:");
	console.log(xhttpTwo.response);
	}	
	function logWeatherAPIResponse(){
	console.log("WEATHER");
	console.log("xhttpThree:");
	console.log(xhttpThree.response);
	if(xhttpThree.response){
		var weatherObject = JSON.parse(xhttpThree.response);
		console.log(weatherObject);
		console.log("temp:");
		console.log(weatherObject.main.temp);
		console.log("description:");
		console.log(weatherObject.weather[0].description);
	}
	}
	function logFormStudyResponse(){
	document.getElementById('formStudyResponseHolder').innerHTML = xhttpFour.response;
	}
    function logCreateDatabaseResponse(){
    console.log(xhttpSix.response);
    }
	
	</script>
	<style>
		body {
		font-family:'Roboto', sans-serif;
		font-size:12px;
		font-weight:500;
		line-height:normal;
		margin:0px;
		padding:0px;
		background-color:powderBlue;
		padding-top:25px;
		padding-bottom:25px;
		}
		.header, .footer {
		text-align:center;
		color:#ffffff;
		background-color:#bbbbbb;
		height:15px;
		padding-top:5px;
		padding-bottom:5px;
		width:100%;
		position:fixed;
		}
		.header{
		top:0px;
		}
		.footer{
		bottom:0px;
		}
		.button{
		width:100px;
		height:40px;
		border-radius:3px;
		background-color:#bbbbbb;
		line-height:40px;
		text-align:center;
		color:white;
		margin:auto;
		margin-top:25px;
		margin-bottom:25px;
		cursor:pointer;
		}
		.button:hover{
		background-color:#7f7f7f;
		}
		.slug10{
		width:10px;
		height:10px;
		}
		.slug100{
		width:100px;
		height:100px;
		}
		.noSelect{
		-webkit-user-select: none;
		-moz-user-select: none;
		-ms-user-select: none;
		-o-user-select: none;
		user-select: none;
		}
	</style>
</head>
<body>
	<div class="header">
	A code sketch by mike 06.01.17
	</div>
    
    <br>
    <br>
    <script>
        //the string object has some methods and properties built into it.
        document.write("hi, i hope all is well!".toUpperCase());
    </script>
    <br>
    <br>
    <br>
    
    <hr>
	
	<div class="button noSelect" onclick="addImage()">Add Image</div>
	<div class="button noSelect" onclick="submitForm()">Submit</div>
	<div class="button noSelect" onclick="returnFilePaths()">Return File Paths</div>
	<div class="button noSelect" onclick="parseFilePaths()">Parse File Paths</div>
	<div id="downloadButtonsHolder"></div>
	<div class="button noSelect" onclick="logFileUploadResponses()">Log Response</div>
	
	<input type="file" name="fileMaster" id="fileMaster" multiple>
	
	<hr>
	
	<div class="button noSelect" onclick="getWeather()">Get Weather</div>
	<div class="button noSelect" onclick="logWeatherAPIResponse()">Log Response</div>
	
	<hr>
	
	<form id="importantForm">
		Gender
		<input type="radio" name="gender" value="female">
		<input type="radio" name="gender" value="male">
		<br>
		Dog Status
		<input type="radio" name="dogStatus" value="yes">
		<input type="radio" name="dogStatus" value="no">
		<br>
		I am green
		<input type="checkbox" name="green">
		<br>
		I am tough
		<input type="checkbox" name="tough">
		<br>
		What is your favorite show?
		<input type="text" name="favoriteShow">
		<br>
	</form>
	
	<div class="button noSelect" onclick="gatherFormData('importantForm')">Gather Form</div>
	<div class="button noSelect" onclick="parseFormDataObject()">Parse Form</div>
	<div class="button noSelect" onclick="sendParsedFormDataObjectToPHP(parsedFormDataObject)">Send Form</div>
	<div class="button noSelect" onclick="logFormStudyResponse()">Log Response</div>
	
	<div id="formStudyResponseHolder"></div>
    
    <hr> <!--Read a table-->
    
    <form id="readDatabaseForm">
        Which database?
		<input type="text" name="databaseSelect" value="people">
		<br>
        Which table?
		<input type="text" name="tableSelect" value="coolPeople">
		<br>
	</form>
 
    <div class="button noSelect" onclick="readDatabaseReadTableCreateForm()">Read Table</div>
    
    <div id="tableDataAndInsertForm"></div>
    
    <div id="insertRowDatabaseResponseHolder"></div>

    <hr> <!--Create a Schema-->
    
    <form id="createDatabaseForm">
        Schema name?
		<input type="text" name="newDatabaseName">
		<br>
    </form>
    
    <div class="button noSelect" onclick="createDatabase()">Create Database</div>
    <div class="button noSelect" onclick="logCreateDatabaseResponse()">Log Response</div>
    
    <hr> <!--Create a Table-->
    
    <div class="button noSelect" onclick="returnSchema()">Return Schema</div>

    <div id="schemaList"></div>
    <br>
    
    <form id="createTableForm">
        Which schema?
		<input type="text" name="databaseName">
		<br>
        Table name?
		<input type="text" name="newTableName">
		<br>
    </form>

    <div class="button noSelect" onclick="createTable()">Create Table</div>
	
	<div class="footer">
	A code sketch by mike 06.01.17
	</div>
</body>
</html>

<!--

90% brightness:e5e5e5
80% brightness:cccccc
70% brightness:b2b2b2
60% brightness:999999
50% brightness:7f7f7f
40% brightness:656565
30% brightness:4c4c4c
20% brightness:333333
10% brightness:191919

A div with position:absolute positions itself relative to the other elements on the page, but the other elements on the page ignore the div with position:absolute

A div with position:fixed ignores all other elements on the page, and all other elements on the page ignore the div with position:fixed

Margins collapse by default. Objects that are 'floating' do not collapse their margins.

API - Application Program Interface

An API is a collection of methods or routines used by numerous pieces of sofware for communication. Lingua Franca. Protocols for information exchange.

Constructors create objects

Event object can be useful

Query Strings are your friend when passing infomation with AJAX

PHP: The object operator, ->, is used in object scope to access methods and properties of an object.

PHP: The double arrow operator, =>, is used as an access mechanism for arrays.

-->