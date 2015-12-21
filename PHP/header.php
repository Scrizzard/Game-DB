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
function requestPopup($message){

	if(isset($_POST["submitted"])){
		$scriptString = '<script type="text/javascript">createPopup("' . $message . '");</script>';
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

/******************************************************************************
* Parse the "complete price" out of a videogames.pricecharting.com link.
* Note that this functionality depends on unchanging HTML and URL of an external site.
* So yeah, this will probably break in a few years. (Sept. 2015)
* 
* Also, use the API you stupid fuck.
* Here's an example. The two GET parameters are t, the access token, and id, the game ID. 
* https://ae.pricecharting.com/api/product?t=c0b53bce27c1bdab90b1605249e600dc43dfd1d5&id=5743
******************************************************************************/
function fetchGamePrice($url){
	if (empty($url)){
		return "N/A";
	}
	
	//TODO: check for error response
	$html = file_get_contents($url);
	$pattern = '/(?<=complete_price">\n {16}<span class="price">\n {16})\$[\d\.]+/';
	preg_match ($pattern, $html, $match);
	return $match[0]; 
}
?>