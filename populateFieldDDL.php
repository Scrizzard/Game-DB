<?php

//$field=$_GET["field"];

$fetchQuery = "SELECT " . $field . "ID, " . $field . "Name " .
			  "FROM " . $field . " " .
			  "ORDER BY " . $field . "ID;";
			  			  
$result = doQuery($conn, $fetchQuery);

while ($row = mysqli_fetch_assoc($result)) {
	echo "<option value='" . $row[$field . "ID"] . "'>" . $row[$field . "Name"] . "</option>";
}

?>