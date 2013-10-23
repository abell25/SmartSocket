<?php
$link = mysqli_connect('localhost','root','bitnami');

if(mysqli_connect_errno($link)) {
	$output = "Failed to connect to MySQL:" . mysqli_connect_error();
	include 'output.html.php';
	exit();
}

if (!$link)
{
	$output = 'Unable to connect to the database server.';
	include 'output.html.php';
	exit();
}

if (!mysqli_set_charset($link, 'utf8'))
{
	$output = 'Unable to set database connection encoding.';
	include 'output.html.php';
	exit();
}

if (!mysqli_select_db($link, 'smartsocket'))
{
	$output = 'Unable to locate the smartsocket database.';
	include 'output.html.php';
	exit();
}

if (isset($_GET['id']) and isset($_GET['I']) and isset($_GET['V']) and isset($_GET['time']) and isset($_GET['state']))
{
	$id = $_GET['id'];
	$I = $_GET['I'];
	$V = $_GET['V'];
	$time = $_GET['time'];
	$state = $_GET['state'];
	
	$output = $id . ' ' . $I . ' ' . $V . ' ' . $time . ' ' . $state; //print to page
	
	$sql = 'INSERT INTO reading(dev_id, time_id, milliamps, millivolts, state) VALUES 
			('. $id .','. $time .','. $I .','. $V .','. $state .')';
			
	if (!mysqli_query($link, $sql))
	{
		$error = 'Error adding information: ' . mysqli_error($link);
	}

	include 'output.html.php';
	exit();
}

$output = 'Database connection established.';
include 'output.html.php';
?>
