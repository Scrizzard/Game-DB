<?php

/******************************************************************************
* Driver
******************************************************************************/

if (validGame()) {
	$largestID = getLargestGameId($conn);
	insertGame($largestID, $conn);

	insertFields($conn, $largestID, 'genre');
	insertFields($conn, $largestID, 'publisher');
	insertFields($conn, $largestID, 'developer');
	insertEntryGamePair($conn, $_POST["gameConsole"], $largestID, 'console');
	
	makePopup("Transaction successful!");
}
else{
	//makePopup("Missing fields, transaction failed!");
}

?>

<?php

/******************************************************************************
* Iteratively Insert Generic Fields
******************************************************************************/

function insertFields($conn, $gameID, $nameBase){
	$fieldIndex = 1;
	$name = $nameBase . $fieldIndex;

	while(isset($_POST[$name]) && $_POST[$name] != ""){
		$entry = $_POST[$name];

		insertEntry($conn, $entry, $nameBase);
		$entryID = getEntryId($conn, $entry, $nameBase);
		insertEntryGamePair($conn, $entryID, $gameID, $nameBase);
		
		$fieldIndex += 1;
		$name = $nameBase . $fieldIndex;	
	}
}

/******************************************************************************
* Insert Single Fields
******************************************************************************/

function insertGame($largestID, $conn) {
	
	$title = '"' . $_POST["title"] . '"';
	$releaseYear = '"' . $_POST["releaseYear"] . '"';
	$rating = '"' . $_POST["rating"] . '"';
	$today = '"' . date("Y-m-d") . '"';
	$image = $_FILES["coverImage"];
	$blob = '"' . "" . '"';
	$mime = '"' . "" . '"';
	
	//handle empty rating field
	if(is_null($rating)){
		$rating = '?';
	}
	
	//check for valid image
	if(validImage($image)){
		$blob = '"' . imageToBlob($image) . '"';
		$mime = '"' . $image["type"] . '"';
		echo $mime;
	}
	else{
		echo "image is either too large (>16mb) or not actually a valid image";
	}
	
	$insertQuery = "INSERT INTO Game (gameID, title, releaseYear, rating, dateAdded, coverImage, imageType) " . 
			 "VALUES (" . $largestID . ", " . $title . ", " . $releaseYear . ", " . $rating . ", " . $today . ", " . $blob . ", " . $mime . ");";
	doQuery($conn, $insertQuery);
}

function insertEntry($conn, $entry, $nameBase){
	$fetchQuery = "SELECT * FROM " . $nameBase .
			      " WHERE " . $nameBase . "Name = '" . $entry . "';";
			 
	$fetchResult = doQuery($conn, $fetchQuery);
	
	if($fetchResult->num_rows == 0){
		$insertQuery = "INSERT INTO " . $nameBase . " (" . $nameBase . "Name) VALUES ('" . $entry . "');";
		doQuery($conn, $insertQuery);
	}
}

/******************************************************************************
* Insert Generic Foreign Key Pair
******************************************************************************/

function insertEntryGamePair($conn, $entryID, $gameID, $nameBase){
	$insertQuery = "INSERT INTO " . $nameBase . "Game (gameID, " . $nameBase . "ID) VALUES (" . $gameID . ", " . $entryID . ");";
	doQuery($conn, $insertQuery);
}


/******************************************************************************
* Fetch ID
******************************************************************************/

function getLargestGameID($conn) {
	
	$fetchQuery = "SELECT MAX(gameID) " .
			 "FROM Game;";

	$fetchResult = doQuery($conn, $fetchQuery);

	if (mysqli_num_rows($fetchResult) == 0) { //database is empty
		return 1;
	}
	
	else { //database is not empty
	    $row = $fetchResult->fetch_row();
	    return $row[0] + 1;
    }
}

function getEntryId($conn, $entry, $baseName){

	$fetchQuery = "SELECT " . $baseName . "ID FROM " . $baseName .
			      " WHERE " . $baseName . "Name = '" . $entry . "';";
	$fetchResult = doQuery($conn, $fetchQuery);

	$row = $fetchResult->fetch_row();
	
	return $row[0];
}

/******************************************************************************
* Misc./Utiltiy
******************************************************************************/

function validGame() {
	
	$hasTitle = isset($_POST["title"]) && $_POST["title"] != "";
	$hasReleaseYear = isset($_POST["releaseYear"]) && $_POST["releaseYear"] != "";
	$hasRegion = isset($_POST["region"]) && $_POST["region"] != "";
	$hasPublisher = isset($_POST["publisher1"]) && $_POST["publisher1"] != "";
	$hasDeveloper = isset($_POST["developer1"]) && $_POST["developer1"] != "";
	$hasGenre = isset($_POST["genre1"]) && $_POST["genre1"] != "";
	$hasPlatform = isset($_POST["platform1"]) && $_POST["platform1"] != "";
	
	return $hasTitle && $hasReleaseYear && $hasDeveloper && $hasGenre && $hasRegion;
	
}

function validImage($image){

    $isImage = getimagesize($image["tmp_name"]) !== FALSE;
	$tooLarge = $image["size"] > 16000000;
  	 
	return($isImage && !$tooLarge);
}

function imageToBlob($image){

	$tmpName = $image['tmp_name'];
	$fp = fopen($tmpName, 'r');
	$content = fread($fp, filesize($tmpName));
	$content = addslashes($content);
	fclose($fp);
	
	return $content;
}

?>