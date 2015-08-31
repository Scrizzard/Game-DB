<?php
//--------------------------------------------------------
//Database Connection Information/Setup
//--------------------------------------------------------

$servername = "localhost";
$username = "root";
//$password = "password";
$dbName = "Games";

// Create connection
$conn = new mysqli($servername, $username);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

//select a database to work with
$conn->select_db($dbName);

//--------------------------------------------------------
//Common Functions
//--------------------------------------------------------

//perform a SQL query, printing error message on failure
function doQuery($conn, $query){
	$result = mysqli_query($conn, $query);
	
	if (! $result){
		echo "query failed<br/>";
		echo mysqli_error($conn) . "<br/>";
		echo '<br/>' . $query . '<br/>';
	}
	return $result;
}

//display an all-purpose popup alert
function makePopup($message){

	if(isset($_GET["submitted"])){
		$scriptString = '<script type="text/javascript">makePopup("' . $message . '");</script>';
		echo $scriptString;
	}
}

//fetch a complete list of names in a paricular database (to aid autocompletion)
function fetchNameAttr($attrBase, $conn){
	$query = "SELECT ". $attrBase . "Name " .
	               "FROM " . $attrBase . ";";
	$result = doQuery($conn, $query);
	$attrArray = array();
	
	while($row = $result->fetch_assoc()) {
	    $attrArray[] = $row[$attrBase . "Name"];
	}
	return $attrArray;	
}
?>