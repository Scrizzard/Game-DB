<?php

function doQuery($conn, $query){
	$result = mysqli_query($conn, $query);
	
	if (! $result){
		echo "query failed<br/>";
		echo mysqli_error($conn) . "<br/>";
		echo '<br/>' . $query . '<br/>';
	}
	
	return $result;
}

function makePopup($message){

	if(isset($_GET["submitted"])){
		$scriptString = '<script type="text/javascript">makePopup("' . $message . '");</script>';
		echo $scriptString;
	}
}

?>