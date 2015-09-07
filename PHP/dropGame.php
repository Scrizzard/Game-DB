<?php include('header.php') ?>

<?php
$gameID = $_POST["gameID"];
$deletionQuery = "DELETE FROM Game " .
				 "WHERE Game.gameID = " . $gameID . ";";
doQuery($conn, $deletionQuery);
echo $deletionQuery;

?>
