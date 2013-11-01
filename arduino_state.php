
<?php
include $_SERVER['DOCUMENT_ROOT'] . '/SmartSocket/includes/db_connection.php';

if (isset($_GET['id'])) {
	$id = $_GET['id'];
	$sql = "SELECT user_set_state from device where dev_id = '".$id."'";
	$result = mysqli_query($connection,$sql);
	
	if (!$result){
		$error = 'Error finding arduino state.';
		include 'output.html.php';
		exit();
	}
	
	$info = mysqli_fetch_assoc($result);
	$output = $info['user_set_state'];
	
	echo $output;
	exit();
}
?>