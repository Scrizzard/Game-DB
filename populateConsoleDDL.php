<?php

$fetchQuery = "SELECT consoleID, consoleName " .
			  "FROM Console " .
			  "ORDER BY consoleName;";
			  
$result = doQuery($conn, $fetchQuery);

while ($row = mysqli_fetch_assoc($result)) {
	echo "<option value='" . $row["consoleID"] . "'>" . $row["consoleName"] . "</option>";
}

?>