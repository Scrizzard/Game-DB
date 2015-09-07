<?php include('header.php') ?>

<?php
/******************************************************************************
* Driver
******************************************************************************/

echo '<div class="gameViewWrapper"></div>';
echo '<div class="gameView">';

$gameID = $_POST["gameID"];

echo 	'<table>';
echo 		'<tr>';
echo 			'<td class="gameFieldCell">';

displayBasic($conn, $gameID);
displayConsole($conn, $gameID);

displayIterableGameAttributes($conn, $gameID, "Developer");
displayIterableGameAttributes($conn, $gameID, "Publisher");
displayIterableGameAttributes($conn, $gameID, "Genre");

echo 			'</td>';

echo 			'<td class="imageCell">';
displayImage($conn, $gameID);
echo 			'</td>';
echo 		'</tr>';
echo 	'</table>';
echo '</div>';

?>

<?php

/******************************************************************************
* Fetch and print basic information related to a game
******************************************************************************/

function displayBasic($conn, $gameID){
	$fetchQuery = "SELECT * FROM Game " .
				   "JOIN Rating ON Game.ratingID = Rating.ratingID " .
				   "WHERE gameID = " . $gameID . ";";
	$result = doQuery($conn, $fetchQuery);
	
	$row = $result->fetch_assoc();
	$title = $row["title"];
	$releaseYear = $row["releaseYear"];
	$rating = $row["ratingName"];
	$region = $row["region"];
	$priceURL = $row["priceURL"];
	$price = fetchGamePrice($priceURL);
	
	echo '<p class="gameHeader">' . $title . ' (' . $releaseYear .  ')</p>';

	echo '<div class="gameFieldWrapper">';
	echo 	'<span class="bold">Complete Price: </span> <span class="gameField">' . $price . '</span>';
	echo '</div>';
	echo '<br/>';

	echo '<div class="gameFieldWrapper">';
	echo 	'<span class="bold">Rating: </span> <span class="gameField">' . $rating . '</span>';
	echo '</div>';
	echo '<br/>';
	
	echo '<div class="gameFieldWrapper">';
	echo 	'<span class="bold">Region: </span> <span class="gameField">' . $region . '</span>';
	echo '</div>';	
	echo '<br/>';
}

/******************************************************************************
* Fetch and print a game's corresponding console
******************************************************************************/

function displayConsole($conn, $gameID){
	$fetchQuery = "SELECT consoleName FROM Game " . 
	"JOIN ConsoleGame ON Game.gameID = ConsoleGame.gameID " .
	"JOIN Console ON Console.consoleID = ConsoleGame.consoleID " .
	"WHERE Game.gameID = " . $gameID . ";";
	
	$result = doQuery($conn, $fetchQuery);
	
	$row = $result->fetch_assoc();
	$console = $row["consoleName"];
	
	
	echo '<div class="gameFieldWrapper">';
	echo '<span class="bold">Platform: </span> <span class="gameField">' . $console . '</span>';
	echo '</div>';
	echo '<br/>';
}

/******************************************************************************
* Fetch and print one game's iterable attribute (genres, developers, producers)
******************************************************************************/

function displayIterableGameAttributes($conn, $gameID, $attrBase){
	$fetchQuery = "SELECT " . $attrBase . "Name FROM Game " . 
	"JOIN " . $attrBase . "Game ON Game.gameID = " . $attrBase . "Game.gameID " .
	"JOIN " . $attrBase . " ON " . $attrBase . "." . $attrBase . "ID = " . $attrBase . "Game." . $attrBase . "ID " .
	"WHERE Game.gameID = " . $gameID . ";";
	
	$result = doQuery($conn, $fetchQuery);
	
	echo '<div class="gameFieldWrapper">';
	echo 	'<p class="bold">'. $attrBase . ':</p>';
	echo '</div>';
	echo '<br/>';
	
	while ($row = $result->fetch_assoc()) {
		$attr = $row[$attrBase . "Name"];
		echo '<div class="gameFieldWrapper indented">';
		echo 	'<p class="noMargin">' . $attr . '</p>';
		echo '</div>';
		echo '<br/>';
	}
	
}

/******************************************************************************
* Fetch and display a game's cover image (if it exists)
******************************************************************************/

function displayImage($conn, $gameID){
	$fetchQuery = "SELECT imageType, coverImage FROM Game WHERE gameID = " . $gameID . ";";
	$result = doQuery($conn, $fetchQuery);
	$row = $result->fetch_assoc();
	
	$image = $row["coverImage"];
	$type = $row["imageType"];

	echo '<div class="gameImageWrapper">';
	echo createImgTag($image, $type);
	echo '</div>';
}

/******************************************************************************
* Convert raw image data to a HTML img tag
******************************************************************************/

function createImgTag($rawImage, $type){
  if(empty($rawImage)){
  	return "<p>image not found</p>";
  }
  
  else{ //$rawImage is not NULL
    $base64 = base64_encode($rawImage); 
  	$html = '<img class="gameImage" src="' . $source . '"/>';
  	return $html;
  }
}

?>