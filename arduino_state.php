
<?php
include $_SERVER['DOCUMENT_ROOT'] . '/SmartSocket/includes/db_connection.php';

if (isset($_GET['id'])) {
	$id = $_GET['id'];
	$result = mysqli_query($connection,'SELECT user_set_state from device where dev_id = "'.$id.'"');
	
	if (!$result){
		$error = 'Error finding arduino state.';
		include 'output.html.php';
		exit();
	}
	
	$info = mysql_fetch_assoc($result);
	$output = 'User State: ' .$info['user_set_state'];
			 
	echo $output;
	include 'output.html.php';
	exit();
}
?>