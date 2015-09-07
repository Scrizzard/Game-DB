<?php include('header.php');?>

<?php
$attrBase = $_POST['table'];
if (isset($attrBase)){
	$nameArray = fetchNameAttr($attrBase, $conn);	
	echo json_encode($nameArray);
}
?>