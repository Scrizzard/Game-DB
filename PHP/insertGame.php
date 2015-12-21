<?php

/******************************************************************************
* Driver (Insert all the game bits)
******************************************************************************/
if(isset($_POST["submitted"])){
    tryInsertGame($conn);
}

function tryInsertGame($conn){
    $validationErrors = getValidationErrors();
    
    if (count($validationErrors) == 0) {
    	$largestID = getLargestGameId($conn);
    	$success = insertGame($largestID, $conn);
    
    	insertFields($conn, $largestID, 'genre');
    	insertFields($conn, $largestID, 'publisher');
    	insertFields($conn, $largestID, 'developer');
    	insertEntryGamePair($conn, $_POST["gameConsole"], $largestID, 'console');
    	
    	requestPopup("Transaction successful!");
    }
    else{
    	requestPopup("You have some problems!\\n\\t" . join('\n\t', $validationErrors));
    }
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
	$priceURL = '"' . $_POST["price"] . '"';
	$today = '"' . date("Y-m-d") . '"';
	$image = $_FILES["coverImage"];
	$blob = '""';
	$mime = '""';
	
	//handle empty rating field
	if(is_null($rating)){
		$rating = '?';
	}

    if($image["error"] != UPLOAD_ERR_NO_FILE){
        $blob = '"' . imageToBlob($image) . '"';
        $mime = '"' . $image["type"] . '"';
    }
	
	$insertQuery = "INSERT INTO Game (gameID, title, releaseYear, ratingID, priceURL, dateAdded, coverImage, imageType) " . 
			 "VALUES (" . $largestID . ", " . $title . ", " . $releaseYear . ", " . $rating . ", " . $priceURL . ", " . $today . ", " . $blob . ", " . $mime . ");";
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

function getValidationErrors() {
    $problems = array();

	if(!isset($_POST["title"]) || $_POST["title"] == ""){
	   $problems[] = "Missing game title";
	}
	if(!isset($_POST["releaseYear"]) || $_POST["releaseYear"] == ""){
	    $problems[] = "Missing year of release";
	}
	if(!isset($_POST["region"]) || $_POST["region"] == ""){
	    $problems[] = "Missing release region";
	}
	if(!isset($_POST["publisher1"]) || $_POST["publisher1"] == ""){
        $problems[] = "Missing game publisher";	    
	}
	if(!isset($_POST["developer1"]) || $_POST["developer1"] == ""){
           $problems[] = "Missing game developer";
	}
	if(!isset($_POST["genre1"]) || $_POST["genre1"] == ""){
	    $problems[] = "Missing game genre";
	}
	if(!isset($_POST["gameConsole"]) || $_POST["gameConsole"] == ""){
	    $problems[] = "Missing game platform";
	}

    $image = $_FILES["coverImage"];
    if(!validImage($image) && $image["error"] != UPLOAD_ERR_NO_FILE){
        $problems[] = "Invalid image - size or type not supported";
    }
    
    return $problems;
}

function validImage($image){
	
    $isImage = $image["tmp_name"] && getimagesize($image["tmp_name"]) !== FALSE;
	$tooLarge = $image["size"] && $image["size"] > 16000000;
  	 
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