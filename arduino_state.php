
<?php
include $_SERVER['DOCUMENT_ROOT'] . '/SmartSocket/includes/db_connection.php';

if (isset($_GET['id'])) {
	$id = $_GET['id'];
	// Should use user id to get user_set_state from device table

	$sql = mysqli_query($connection,'SELECT user_set_state from device where dev_id = "'.$id.'"' );
	
	$result = mysqli_query($connection, $sql);
	if (!$result){
		$error = 'Error finding arduino state.';
		include 'output.html.php';
		exit();
	}
	
	$info = mysql_fetch_assoc($data);
	
	$output 'User State: ' .$info['user_set_state'];
			 
	echo $output;
	include 'output.html.php';
	exit();
}
?>