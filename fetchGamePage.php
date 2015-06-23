<?php include('header.php') ?>
<?php include('tools.php') ?>

<?php
//what do I want to do?
//display image
//display genres, name, producers, developers, year, etc
//allow editing and deletion

echo '<div class="gameView">';
$gameID = $_POST["gameID"];

displayBasic($gameID);
displayImage($gameID);
displayGenres($gameID);
displayDevelopers($gameID);
displayProducers($gameID);

echo '</div>';
?>

<?php

function displayBasic($gameID){
	$fetchQuery = "SELECT * FROM Game WHERE gameID = " . $gameID . ";";
	$result = doQuery($conn, $fetchQuery);
	
	$row = $fetchResult->fetch_assoc();
	$title = $row["title"];
	$releaseYear = $row["releaseYear"];
	$rating = $row["rating"];
	$console = $row["consoleName"];
	$region = $row["releaseYear"];
	
	
	echo '<p>' . $title . '</p>';
	echo '<p>' . $releaseYear . '</p>';
	echo '<p>' . $rating . '</p>';
	echo '<p>' . $console . '</p>';
	echo '<p>' . $region . '</p>';
	
}

?>

<?php 

function displayImage($gameID){
	$fetchQuery = "SELECT imageType, coverImage FROM Game WHERE gameID = " . $gameID . ";";
	$result = doQuery($conn, $fetchQuery);
	$row = $fetchResult->fetch_assoc();
	
	$image = $row["coverImage"];
	$type = $row["imageType"];

	echo createImgTag($image, $type);
}

?>

<?php

function createImgTag($image, $type){

  $base64   = base64_encode($contents); 
  $source = 'data:' . $mime . ';base64,' . $base64;
  $html = '<img src="' . $source . '"/>';
  return $html;
}

?>