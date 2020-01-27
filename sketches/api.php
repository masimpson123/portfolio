<!doctype html>
<html leng="en">
<head>
	<meta charset="utf-8">
	<title>Development Sketch</title>
	<meta name="description" content="Development Sketches">
	<meta name="author" content="SitePoint">
	<link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
	<script>
	
	var xhttpOne = new XMLHttpRequest(); //used to upload files and store file paths
	var xhttpTwo = new XMLHttpRequest(); //used to return list of file paths
	var xhttpThree = new XMLHttpRequest(); //used to return weather data
	var xhttpFour = new XMLHttpRequest(); //used to send form data to server
    var xhttpFive = new XMLHttpRequest(); //used to read MySQL database
    var xhttpSix = new XMLHttpRequest(); //used to send an Email
    var xhttpSeven = new XMLHttpRequest(); //used to create a MySQL table
    var xhttpEight = new XMLHttpRequest(); //used to return all MySQL databases
    var xhttpNine = new XMLHttpRequest(); //used to insert a row in a table
    var xhttpTen = new XMLHttpRequest(); //used to return all tables of one database
    var xhttpEleven = new XMLHttpRequest(); //used to create custom download progress
    var xhttpTwelve = new XMLHttpRequest(); //used to delete a MySQL table
	var xhttpThirteen = new XMLHttpRequest(); //python test
	
	var arrayOfAllImages = []; //object we pass to PHP using $_POST superglobal
	var filePathsArray = [];
	var formData = {}; //object we pass to PHP using $_POST superglobal
	var parsedFormDataObject = "";
    var fileTotal = 0;
    var percentLoaded = 0;
	
	function addImage(){ //we populate our array of images
	for(i=0;i<document.getElementById('fileMaster').files.length;i++){
		arrayOfAllImages.push(document.getElementById('fileMaster').files[i]);
	}
	console.log(arrayOfAllImages);
	}
	
	function parseFilePaths(){
	//we slice off the final character because it is always a comma
	//we split the string at commas into parts of an array
	filePathsArray = xhttpTwo.response.slice(0,xhttpTwo.response.length - 1).split(",");
    console.log('Currently Stored Filepaths:');
	console.log(filePathsArray);
	createDownloadButtons();
	}
	
	function createDownloadButtons(){
    document.getElementById('downloadButtonsHolder').innerHTML="";
	for(i=0;i<filePathsArray.length;i++){
        if(filePathsArray[i].length>0){
		var anchor = document.createElement("a");
		anchor.href = filePathsArray[i];
		anchor.setAttribute("download","");
		var btn = document.createElement("button");
		anchor.appendChild(btn);
		document.getElementById('downloadButtonsHolder').appendChild(anchor);
        }
	}
	}
	
	function gatherFormData(x){
    formData = {}
    //formData is a global object
	//There is no way to convert a form into an object with out a library, so we have to write a custom script. 
	var allInputs = document.getElementById(x).getElementsByTagName('input');
    var allTextareas = document.getElementById(x).getElementsByTagName('textarea');
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
        for(i=0;i<allTextareas.length;i++){ //we cycle through all the textareas of a particular form
            formData[allTextareas[i].name] = allTextareas[i].value;
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
        
    function addColumnToNewTable(){
        var allInputsInForm = document.getElementById('createTableForm').getElementsByTagName('INPUT');
        var text = document.createTextNode("Column " + (allInputsInForm.length - 1) + " name? ");
        var input = document.createElement("input");
        input.setAttribute('type', 'text');
        input.setAttribute('name', "column" + (allInputsInForm.length - 1) + "name");
        var lineBreak = document.createElement('br');
        var parent = document.getElementById("createTableForm");
        parent.appendChild(text);
        parent.appendChild(input);
        parent.appendChild(lineBreak);
    }
	
    //REQUEST SEND FUNCTIONS
	function submitForm(){ //we add each image from our array to our form and then send our form to PHP
    addImage();
	var fd = new FormData(); //we could create this using <form> in html
	for(i=0;i<arrayOfAllImages.length;i++){
		var file = arrayOfAllImages[i]
		console.log(file + " is added to form");
		fd.append("theFile" + i, file); //we add each image to our form
	}
	xhttpOne.open("POST", "services/uploadFileStorePath.php"); //we initialize the request
	//xhttpOne.setRequestHeader("Content-type", "application/x-www-form-urlencoded"); //this header breaks image upload but is needed for other forms of inputs?
	xhttpOne.send(fd);
	//we reset our file input and image array
	document.getElementById('fileMaster').value = "";
	arrayOfAllImages = [];
	}
	function returnFilePaths(){
	xhttpTwo.open("POST", "services/returnFilePaths.php"); //we initialize the request
	xhttpTwo.send();
	}
	function getWeather(){
    console.log(document.getElementById('zipInput').value);
	xhttpThree.open("POST", "http://api.openweathermap.org/data/2.5/weather?zip="+document.getElementById('zipInput').value+"&units=imperial&appid=ae90bbba41d65b1f047a019e0a55de96", true); //we initialize the request
	xhttpThree.send();
	}
	function sendParsedFormDataObjectToPHP(){
    gatherFormData('importantForm');
    parseFormDataObject();
    document.getElementById('payloadHolder').innerHTML = "PAYLOAD<br>" + parsedFormDataObject;
	xhttpFour.open("POST", "services/formStudy.php"); //we initialize the request
	xhttpFour.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttpFour.send(parsedFormDataObject);
	}    
    function readDatabaseReadTableCreateForm(){
    gatherFormData('readDatabaseForm');
    parseFormDataObject();
 	xhttpFive.open("POST", "services/readTable.php"); //we initialize the request
	xhttpFive.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttpFive.send(parsedFormDataObject);
    }
    function createTable(){
    gatherFormData('createTableForm');
    parseFormDataObject(); //parses global formData object that gatherFormData() created;
	xhttpSeven.open("POST", "services/createTable.php"); //we initialize the request
	xhttpSeven.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttpSeven.send(parsedFormDataObject);
    }
    function dropTable(){
    gatherFormData('dropTableForm');
    parseFormDataObject(); //parses global formData object that gatherFormData() created;
	xhttpTwelve.open("POST", "services/dropTable.php"); //we initialize the request
	xhttpTwelve.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttpTwelve.send(parsedFormDataObject);
    }
    function returnSchema(){
	xhttpEight.open("POST", "services/showDatabases.php"); //we initialize the request
	xhttpEight.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttpEight.send();
    }
    function returnAllTables(){
    gatherFormData('returnTablesForm');
    parseFormDataObject(); //parses global formData object that gatherFormData() created;
	xhttpTen.open("POST", "services/showTables.php"); //we initialize the request
	xhttpTen.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttpTen.send(parsedFormDataObject);
    }
    function insertRow(){
    gatherFormData('insertRowForm');
    parseFormDataObject();
 	xhttpNine.open("POST", "services/insertRow.php"); //we initialize the request
	xhttpNine.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttpNine.send(parsedFormDataObject);
    }
    function sendEmail(){
    gatherFormData('sendEmail');
    parseFormDataObject();
	xhttpSix.open("POST", "services/sendEmail.php"); //we initialize the request
	xhttpSix.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttpSix.send(parsedFormDataObject);
    }
    function download() {
    xhttpEleven.open("GET", "./services/returnZip.php", true);
    xhttpEleven.responseType = "blob";
    var progressBar={};
    xhttpEleven.onprogress = function(e) {
    fileTotal = xhttpEleven.getResponseHeader('Content-Length');
    percentLoaded = e.loaded/fileTotal;
    console.log(e.loaded);
    console.log(fileTotal);
    console.log(percentLoaded);
    document.getElementById('bingo').innerHTML=""; //clear svg container
    drawCircle(percentLoaded);
    };
    xhttpEleven.onloadstart = function() {
    console.log('load start');
    document.getElementById('downloadIcon').style.display="none";
    document.getElementById('spinnerIcon').style.display="block";
    };
    xhttpEleven.onloadend = function() {
    console.log('load end');
    document.getElementById('downloadIcon').style.display="block";
    document.getElementById('spinnerIcon').style.display="none";
    document.getElementById('bingo').innerHTML=""; //clear svg container
    var url = window.URL.createObjectURL(new Blob([xhttpEleven.response]));
    var a = document.createElement('a');
    document.body.appendChild(a);
    a.setAttribute('style', 'display: none');
    a.href = url;
    a.download = 'niceDownload.zip';
    a.click();
    };
    xhttpEleven.send();
    }
	function pythonTest(){
    	console.log("pythonTest() ran");
	xhttpThirteen.open("GET", "http://localhost:5020/", true); //we initialize the request
	xhttpThirteen.send();
	}
	
    //HTTP Request State Monitoring Functions
	xhttpOne.onreadystatechange = function() { //Tutorials want me to monitor status and ready state for reason...
        //0:REQUEST NOT INITIALIZED  -  1:SERVER CONNECTION ESTABLISHED  -  2:REQUEST RECEIVED  -  3:PROCESSING REQUEST  -  4:REQUEST FINISHED AND RESPONSE IS READY
        console.log('xhttpOne READY STATE: ' + xhttpOne.readyState); 
        //200:OK  -  403:FORBIDDEN  -  404:PAGE NOT FOUND
        console.log('xhttpOne STATUS: ' + xhttpOne.status);
        if(xhttpOne.readyState == 4){
        returnFilePaths();
        }
	}
	xhttpTwo.onreadystatechange = function() { //Tutorials want me to monitor status and ready state for reason...
        //0:REQUEST NOT INITIALIZED  -  1:SERVER CONNECTION ESTABLISHED  -  2:REQUEST RECEIVED  -  3:PROCESSING REQUEST  -  4:REQUEST FINISHED AND RESPONSE IS READY
        console.log('xhttpTwo READY STATE: ' + xhttpTwo.readyState); 
        //200:OK  -  403:FORBIDDEN  -  404:PAGE NOT FOUND
        console.log('xhttpTwo STATUS: ' + xhttpTwo.status);
        if(xhttpTwo.readyState == 4){
        parseFilePaths();
        }
	}
	xhttpThree.onreadystatechange = function() { //Tutorials want me to monitor status and ready state for reason...
        //0:REQUEST NOT INITIALIZED  -  1:SERVER CONNECTION ESTABLISHED  -  2:REQUEST RECEIVED  -  3:PROCESSING REQUEST  -  4:REQUEST FINISHED AND RESPONSE IS READY
        console.log('xhttpThree READY STATE: ' + xhttpThree.readyState); 
        //200:OK  -  403:FORBIDDEN  -  404:PAGE NOT FOUND
        console.log('xhttpThree STATUS: ' + xhttpThree.status);
        if(xhttpThree.readyState == 4){
            document.getElementById('getWeatherResponseHolder').innerHTML = (JSON.parse(xhttpThree.response).name).toUpperCase() + " WEATHER: <br><br>" + xhttpThree.response + "<br><br>";
            console.log((JSON.parse(xhttpThree.response).name).toUpperCase());
        }
	}	
	xhttpFour.onreadystatechange = function() { //Tutorials want me to monitor status and ready state for reason...
        //0:REQUEST NOT INITIALIZED  -  1:SERVER CONNECTION ESTABLISHED  -  2:REQUEST RECEIVED  -  3:PROCESSING REQUEST  -  4:REQUEST FINISHED AND RESPONSE IS READY
        console.log('xhttpFour READY STATE: ' + xhttpFour.readyState); 
        //200:OK  -  403:FORBIDDEN  -  404:PAGE NOT FOUND
        console.log('xhttpFour STATUS: ' + xhttpFour.status);
        if(xhttpFour.readyState == 4){
        document.getElementById('formStudyResponseHolder').innerHTML = xhttpFour.response;
        }
	}   
	xhttpFive.onreadystatechange = function() { //Tutorials want me to monitor status and ready state for reason...
        //0:REQUEST NOT INITIALIZED  -  1:SERVER CONNECTION ESTABLISHED  -  2:REQUEST RECEIVED  -  3:PROCESSING REQUEST  -  4:REQUEST FINISHED AND RESPONSE IS READY
        console.log('xhttpFive READY STATE: ' + xhttpFive.readyState); 
        //200:OK  -  403:FORBIDDEN  -  404:PAGE NOT FOUND
        console.log('xhttpFive STATUS: ' + xhttpFive.status);
        if(xhttpFive.readyState == 4){
        document.getElementById('tableDataAndInsertForm').innerHTML = xhttpFive.response;
        }
	}
	xhttpSix.onreadystatechange = function() { //Tutorials want me to monitor status and ready state for reason...
        //0:REQUEST NOT INITIALIZED  -  1:SERVER CONNECTION ESTABLISHED  -  2:REQUEST RECEIVED  -  3:PROCESSING REQUEST  -  4:REQUEST FINISHED AND RESPONSE IS READY
        console.log('xhttpSix READY STATE: ' + xhttpSix.readyState); 
        //200:OK  -  403:FORBIDDEN  -  404:PAGE NOT FOUND
        console.log('xhttpSix STATUS: ' + xhttpSix.status);
        if(xhttpSix.readyState == 4){
        document.getElementById('sendEmailResponseHolder').innerHTML = xhttpSix.response;
        }
	}
	xhttpSeven.onreadystatechange = function() { //Tutorials want me to monitor status and ready state for reason...
        //0:REQUEST NOT INITIALIZED  -  1:SERVER CONNECTION ESTABLISHED  -  2:REQUEST RECEIVED  -  3:PROCESSING REQUEST  -  4:REQUEST FINISHED AND RESPONSE IS READY
        console.log('xhttpSeven READY STATE: ' + xhttpSeven.readyState); 
        //200:OK  -  403:FORBIDDEN  -  404:PAGE NOT FOUND
        console.log('xhttpSeven STATUS: ' + xhttpSeven.status);
        if(xhttpSeven.readyState == 4){
        document.getElementById('newTableResponseHolder').innerHTML = xhttpSeven.response;
        }
	}
	xhttpEight.onreadystatechange = function() { //Tutorials want me to monitor status and ready state for reason...
        //0:REQUEST NOT INITIALIZED  -  1:SERVER CONNECTION ESTABLISHED  -  2:REQUEST RECEIVED  -  3:PROCESSING REQUEST  -  4:REQUEST FINISHED AND RESPONSE IS READY
        console.log('xhttpEight READY STATE: ' + xhttpEight.readyState); 
        //200:OK  -  403:FORBIDDEN  -  404:PAGE NOT FOUND
        console.log('xhttpEight STATUS: ' + xhttpEight.status);
        if(xhttpEight.readyState == 4){
        document.getElementById('schemaList').innerHTML = xhttpEight.response;
        }
	}
	xhttpNine.onreadystatechange = function() { //Tutorials want me to monitor status and ready state for reason...
        //0:REQUEST NOT INITIALIZED  -  1:SERVER CONNECTION ESTABLISHED  -  2:REQUEST RECEIVED  -  3:PROCESSING REQUEST  -  4:REQUEST FINISHED AND RESPONSE IS READY
        console.log('xhttpNine READY STATE: ' + xhttpNine.readyState); 
        //200:OK  -  403:FORBIDDEN  -  404:PAGE NOT FOUND
        console.log('xhttpNine STATUS: ' + xhttpNine.status);
        if(xhttpNine.readyState == 4){
        document.getElementById('insertRowDatabaseResponseHolder').innerHTML = xhttpNine.response;
        }
	}
	xhttpTen.onreadystatechange = function() { //Tutorials want me to monitor status and ready state for reason...
        //0:REQUEST NOT INITIALIZED  -  1:SERVER CONNECTION ESTABLISHED  -  2:REQUEST RECEIVED  -  3:PROCESSING REQUEST  -  4:REQUEST FINISHED AND RESPONSE IS READY
        console.log('xhttpTen READY STATE: ' + xhttpTen.readyState); 
        //200:OK  -  403:FORBIDDEN  -  404:PAGE NOT FOUND
        console.log('xhttpTen STATUS: ' + xhttpTen.status);
        if(xhttpTen.readyState == 4){
        document.getElementById('tableList').innerHTML = xhttpTen.response;
        }
	}
	xhttpEleven.onreadystatechange = function() { //Tutorials want me to monitor status and ready state for reason...
        //0:REQUEST NOT INITIALIZED  -  1:SERVER CONNECTION ESTABLISHED  -  2:REQUEST RECEIVED  -  3:PROCESSING REQUEST  -  4:REQUEST FINISHED AND RESPONSE IS READY
        console.log('xhttpEleven READY STATE: ' + xhttpEleven.readyState); 
        //200:OK  -  403:FORBIDDEN  -  404:PAGE NOT FOUND
        console.log('xhttpEleven STATUS: ' + xhttpEleven.status);
        if(xhttpEleven.readyState == 4){
        console.log(xhttpEleven.response);
        }
	}
	xhttpTwelve.onreadystatechange = function() {
        //0:REQUEST NOT INITIALIZED  -  1:SERVER CONNECTION ESTABLISHED  -  2:REQUEST RECEIVED  -  3:PROCESSING REQUEST  -  4:REQUEST FINISHED AND RESPONSE IS READY
        console.log('xhttpTwelve READY STATE: ' + xhttpTwelve.readyState); 
        //200:OK  -  403:FORBIDDEN  -  404:PAGE NOT FOUND
        console.log('xhttpTwelve STATUS: ' + xhttpTwelve.status);
        if(xhttpTwelve.readyState == 4){
        document.getElementById('droppedTableResponseHolder').innerHTML = xhttpTwelve.response;
        }
	}
	xhttpThirteen.onreadystatechange = function() {
        //0:REQUEST NOT INITIALIZED  -  1:SERVER CONNECTION ESTABLISHED  -  2:REQUEST RECEIVED  -  3:PROCESSING REQUEST  -  4:REQUEST FINISHED AND RESPONSE IS READY
        console.log('xhttpThirteen READY STATE: ' + xhttpThirteen.readyState); 
        //200:OK  -  403:FORBIDDEN  -  404:PAGE NOT FOUND
        console.log('xhttpThirteen STATUS: ' + xhttpThirteen.status);
        if(xhttpThirteen.readyState == 4){
        document.getElementById('pythonTestResponseHolder').innerHTML = xhttpThirteen.response;
        }
	}
	
    function initialize(){
        returnFilePaths();
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
        #content{
            padding:10px;
        }
        .spinnerAnimation {
        animation-name: spinner;
        animation-duration: 2s;
        animation-timing-function: linear;
        animation-iteration-count: infinite;
        }

        @keyframes spinner {
        from {transform: rotate(0deg);}
        to {transform: rotate(360deg);}
        }
        .downloadButton{
        width:100px;
        height:100px;
        background-color:#bbbbbb;
        border-radius:50px;
        }
        .downloadButtonContents{
        position:absolute;
        width:100px;
        height:100px;
        text-align:center;
        line-height:100px;
        font-size:30px;
        color:white;
        z-index:100;
        }
	</style>
</head>
<body onload="initialize()">
	<div class="header">
	API POC Michael Simpson January 7 2018
	</div>
    
    <div id="content">
    
    <br>
    <br>
    <h2>UPLOAD FILE<br>WRITE PATH TO CSV<br>RETRIEVE ALL PATHS<br>CREATE DOWNLOAD BUTTONS</h2>
    <br>
    <br>
	
    <input type="file" name="fileMaster" id="fileMaster" multiple>
	<div class="button noSelect" onclick="submitForm()">Submit</div>
	<div id="downloadButtonsHolder"></div>
    
    <br>
    <br>
	<hr>
    <br>
    <br>
    
    Which ZIP Code?
    <input id="zipInput" type="text" name="zipInput">
    <br>	
	<div class="button noSelect" onclick="getWeather()">Get Weather</div>
    <div id="getWeatherResponseHolder"></div>
	
    <br>
    <br>
	<hr>
    <br>
    <br>
    
	<form id="importantForm">
		GENDER
        <br>
		<input type="radio" name="gender" value="female"> Female
        <br>
		<input type="radio" name="gender" value="male"> Male
		<br>
        <br>
		DOG STATUS
        <br>
		<input type="radio" name="dogStatus" value="yes"> Yes
        <br>
		<input type="radio" name="dogStatus" value="no"> No
        <br>
		<br>
		I AM GREEN
		<input type="checkbox" name="green">
		<br>
        <br>
		I AM TOUGH
		<input type="checkbox" name="tough">
		<br>
        <br>
		WHAT IS YOUR FAVORITE SHOW?
		<input type="text" name="favoriteShow">
		<br>
	</form>	
	<div class="button noSelect" onclick="sendParsedFormDataObjectToPHP(parsedFormDataObject)">Send Form</div>
    <div id="payloadHolder"></div>
	<div id="formStudyResponseHolder"></div>
     
    <br>
    <br>   
    <hr> <!--Return Databases-->
    <br>
    <br>
    <h2>RETURN ALL DATABASES</h2>
    <br>
    <br>
    
    <div class="button noSelect" onclick="returnSchema()">Return Database</div>

    <div id="schemaList"></div>
    
    <br>
    <br>   
    <hr> <!--Return Tables-->
    <br>
    <br>
    <h2>RETURN ALL TABLES OF ONE DATABASE</h2>
    <br>
    <br>
    
    <form id="returnTablesForm">
        Which database?
		<input type="text" name="databaseSelect">
		<br>
	</form>
    <div class="button noSelect" onclick="returnAllTables()">Return Tables</div> 
    <div id="tableList"></div>
    
    <br>
    <br>  
    <hr> <!--Read and edit a table-->
    <br>
    <br>
    <h2>READ ONE TABLE AND ADD TO IT</h2>
    <br>
    <br>
    
    <form id="readDatabaseForm">
        Which database?
		<input type="text" name="databaseSelect">
		<br>
        Which table?
		<input type="text" name="tableSelect">
		<br>
	</form>
    <div class="button noSelect" onclick="readDatabaseReadTableCreateForm()">Read Table</div>  
    <div id="tableDataAndInsertForm"></div>  
    <div id="insertRowDatabaseResponseHolder"></div>
 
    <br>
    <br>
    <hr> <!--Create a table-->
    <br>
    <br>
    <h2>CREATE A NEW TABLE</h2>
    <br>
    <br>
    
    <form id="createTableForm">
        Which database?
		<input type="text" name="databaseName">
		<br>
        Which table?
		<input type="text" name="newTableName">
		<br>
    </form>
    <button onclick="addColumnToNewTable()">Add Field</button>
    <div class="button noSelect" onclick="createTable()">Create Table</div>   
    <div id="newTableResponseHolder"></div>

    <br>
    <br>
    <hr> <!--Drop a table-->
    <br>
    <br>
    <h2>DROP AN EXISTING TABLE</h2>
    <br>
    <br>
    
    <form id="dropTableForm">
        Which database?
		<input type="text" name="databaseName">
		<br>
        Which table?
		<input type="text" name="droppedTableName">
		<br>
    </form>
    <div class="button noSelect" onclick="dropTable()">Drop Table</div>   
    <div id="droppedTableResponseHolder"></div>
    
    <br>
    <br>
    <hr> <!--Send an eMail-->
    <br>
    <br>
    <h2>SEND AN EMAIL</h2>
    <br>
    <br>
	
    <form id="sendEmail">
        Recipient?
		<input type="text" name="destinationEmail">
		<br>
        Subject?
		<input type="text" name="subject">
		<br>
        Message?
        <textarea type="text" name="message" style="width:200px;height:300px;"></textarea>
		<br>
    </form>
    <div class="button noSelect" onclick="sendEmail()">Send Email</div>   
    <div id="sendEmailResponseHolder"></div>
    
    <br>
    <br>
    <hr> <!--custom progress-->
    <br>
    <br>
    <h2>CUSTOM DOWNLOAD PROGRESS</h2>
    <br>
    <br>
    
    <div class="downloadButton" onclick="download()">
    <div class="downloadButtonContents">
    <span id="downloadIcon"><i class="fas fa-download"></i></span>
    <span id="spinnerIcon" style="display:none;"><i class="fas fa-spinner spinnerAnimation"></i></span>
    </div>
    <svg id="bingo" viewBox="-1 -1 2 2" style="transform: rotate(-90deg);height:80px;width:80px;position:absolute;margin:10px;"></svg>
    </div>
    <script>
    const svgEl = document.getElementById('bingo');
    function drawCircle(x){
        const slices = [
        { percent: x, color: 'powderBlue' },
        ];
        let cumulativePercent = 0;
        let largArcFlag = 0;
        slices.forEach(slice => {
        const startX = Math.cos(2 * Math.PI * cumulativePercent); 
        const startY = Math.sin(2 * Math.PI * cumulativePercent);
        // each slice starts where the last slice ended, so keep a cumulative percent
        cumulativePercent += slice.percent;
        const endX = Math.cos(2 * Math.PI * cumulativePercent); 
        const endY = Math.sin(2 * Math.PI * cumulativePercent);
        // if the slice is more than 50%, take the large arc (the long way around)
        if(slice.percent > .5){
        largeArcFlag = 1;
        } else {
        largeArcFlag = 0;
        }
        //create an array and join it just for code readability
        //the large arc and small arc parameter is needed because a circle can intersect two points in multiple ways.
        const pathData = [
        'M ' + startX + ' ' + startY, // Move
        'A 1 1 0 ' + largeArcFlag + ' 1 ' + endX + ' ' + endY, // Arc {radius-x},{radius-y},{offset-rotation-deg},{larg-arc-small-arc},{clockwise-counterclockwise},{end-x},{end-y}
        'L 0 0', // Line to center
        ].join(' '); //we add one space between each array item
        const pathEl = document.createElementNS('http://www.w3.org/2000/svg', 'path');
        pathEl.setAttribute('d', pathData);
        pathEl.setAttribute('fill', slice.color);
        svgEl.appendChild(pathEl);
        });
    }
    </script>

    <br>
    <br>
    <hr> <!--Python TEST-->
    <br>
    <br>
    <h2>PYTHON TEST</h2>
    <br>
    <br>

    <div class="button noSelect" onclick="pythonTest()">Python Test</div>   
    <div id="pythonTestResponseHolder"></div>
    
    </div> <!--Close Content-->

        
    <div class="footer">
	API POC Michael Simpson January 7 2018
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