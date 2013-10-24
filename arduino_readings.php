<?php
include $_SERVER['DOCUMENT_ROOT'] . '/SmartSocket/includes/db_connection.php';

if (isset($_GET['id']) and isset($_GET['I']) and isset($_GET['V']) and isset($_GET['time']) and isset($_GET['state']))
{
	$id = $_GET['id'];
	$I = $_GET['I'];
	$V = $_GET['V'];
	$time = $_GET['time'];
	$state = $_GET['state'];
	
	$output = 'ID: ' . $id . ' Current: ' . $I . ' Voltage: ' . $V . ' Time: ' . $time . ' State: ' . $state; //print to page
	
	$sql = 'INSERT INTO reading(dev_id, time_id, milliamps, millivolts, state) VALUES 
			('. $id .','. $time .','. $I .','. $V .','. $state .')';
			
	if (!mysqli_query($connection, $sql))
	{
		$error = 'Error adding information: ' . mysqli_error($connection);
	}

	include 'output.html.php';
	exit();
}
?>