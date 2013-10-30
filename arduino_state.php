<?php
include $_SERVER['DOCUMENT_ROOT'] . '/SmartSocket/includes/db_connection.php';

if (isset($_GET['id']))
{
	$id = $_GET['id'];
	
	//$output = 'ID: ' . $id . ' Current: ' . $I . ' Voltage: ' . $V . ' Time: ' . $time . ' State: ' . $state; //print to page

	$data = mysqli_query($connection,'SELECT user_set_state from device(dev_id) VALUES ('. $id.')' )
	or die(mysql_error());
	
	$info = mysql_fetch_array($data);
	
	$output 'User State' .$info.
			


	include 'output.html.php';
	exit();
}
?>