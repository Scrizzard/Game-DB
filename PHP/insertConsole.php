<?php 
/******************************************************************************
* Driver
******************************************************************************/

if (validConsole()) {
	insertConsole($conn);
}

?>

<?php
/******************************************************************************
* Insert a Console
******************************************************************************/

function insertConsole($conn){
	$name = $_POST["consoleName"];
	$firstParty = $_POST["firstParty"];
	$releaseYear = $_POST["consoleYear"];
	$isHandheld = boolToBitstring(isset($_POST["isHandheld"]));
	
	
	
	$insertQuery = "INSERT INTO Console (consoleName, consoleFirstParty, consoleReleaseYear, isHandheld) VALUES " . 
				   "('" . $name . "', '" . $firstParty . "', '" . $releaseYear . "', " . $isHandheld . ");";
				   
	doQuery($conn, $insertQuery);
}

/******************************************************************************
* Misc./Utiltiy
******************************************************************************/

function validConsole() {
	
	$hasConsoleName = isset($_POST["consoleName"]) && $_POST["consoleName"] != "";
	$hasFirstParty = isset($_POST["firstParty"]) && $_POST["firstParty"] != "";
	$hasConsoleYear = isset($_POST["consoleYear"]) && $_POST["consoleYear"] != "";
	
	return $hasConsoleName && $hasFirstParty && $hasConsoleYear;
	
}

function boolToBitstring($bool){
	if($bool){
		return "b'1'";
	}
	return "b'0'";
}

?>