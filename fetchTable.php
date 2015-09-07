<?php

$fetchQuery = "SELECT * FROM Game " .
			  "JOIN ConsoleGame ON Game.gameID = ConsoleGame.gameID " .
			  "JOIN Console ON ConsoleGame.consoleID = Console.consoleID " .
			  "JOIN ESRB ON ESRB.ratingID = Game.ratingID;";
			  #"JOIN DeveloperGame ON Game.gameID = DeveloperGame.gameID " .
			  #"JOIN Developer ON DeveloperGame.developerID = Developer.developerID " .
			  #"JOIN PublisherGame ON Game.gameID = PublisherGame.gameID " . 
			  #"JOIN Publisher ON PublisherGame.publisherID = Publisher.publisherID;";
			  
$fetchResult = doQuery($conn, $fetchQuery); 

while ($row = $fetchResult->fetch_assoc()) {
		$gameID = $row["gameID"];
		$title = $row["title"];
		$releaseYear = $row["releaseYear"];
		$rating = $row["ratingName"];
		$console = $row["consoleName"];
		$dateAdded = $row["dateAdded"];

        echo "<tr>";

        echo "<td>" . $title . "<p class='gameID'>" . $gameID . "</p></td>";
        echo "<td>" . $console . "</td>";
        echo "<td>" . $releaseYear . "</td>";
        echo "<td>" . $rating . "</td>";
		echo "<td>" . $dateAdded . "</td>";
		echo "<td><p class='xButton noMargin'>X<p></td>";
		

		echo "</tr>";
    }
?>