<?php

$fetchQuery = "SELECT * " .
			  "FROM Game JOIN ConsoleGame ON Game.gameID = ConsoleGame.gameID " .
			  "JOIN Console ON ConsoleGame.consoleID = Console.consoleID;";
			  #"JOIN DeveloperGame ON Game.gameID = DeveloperGame.gameID " .
			  #"JOIN Developer ON DeveloperGame.developerID = Developer.developerID " .
			  #"JOIN PublisherGame ON Game.gameID = PublisherGame.gameID " . 
			  #"JOIN Publisher ON PublisherGame.publisherID = Publisher.publisherID;";
			  
$fetchResult = doQuery($conn, $fetchQuery); 

while ($row = $fetchResult->fetch_assoc()) {
		$title = $row["title"];
		$releaseYear = $row["releaseYear"];
		$rating = $row["rating"];
		$console = $row["consoleName"];
		$dateAdded = $row["dateAdded"];

        echo "<tr>";

        echo "<td>" . $title . "</td>";
        echo "<td>" . $console . "</td>";
        echo "<td>" . $releaseYear . "</td>";
        echo "<td>" . $rating . "</td>";
		echo "<td>" . $dateAdded . "</td>";
		

		echo "</tr>";
    }

?>