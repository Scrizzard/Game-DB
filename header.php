<?php

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

?>