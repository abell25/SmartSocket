<?php
$connection = mysqli_connect('localhost','root','bitnami');

if(mysqli_connect_errno($connection)) {
	$output = "Failed to connect to MySQL:" . mysqli_connect_error();
	include 'output.html.php';
	exit();
}

if (!$connection)
{
	$output = 'Unable to connect to the database server.';
	include 'output.html.php';
	exit();
}

if (!mysqli_set_charset($connection, 'utf8'))
{
	$output = 'Unable to set database connection encoding.';
	include 'output.html.php';
	exit();
}

if (!mysqli_select_db($connection, 'smartsocket'))
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

/*********************Registration page code***************************/
if (isset($_GET['register']))
{
	include 'register.html.php';
	exit();
}

if (isset($_POST['action']) and $_POST['action'] == 'register')
{
	$username = mysqli_real_escape_string($connection, $_POST['username']);
	$email = mysqli_real_escape_string($connection, $_POST['email']);
	$password = mysqli_real_escape_string($connection, $_POST['password']);
	
	$output = 'Username: ' . $username . ' Email: ' . $email . ' Password: ' . $password;
	
	$sql = 'INSERT INTO user (username,email,password) VALUES
			("'. $username .'","'. $email .'","'. $password .'")';
			
	if (!mysqli_query($connection, $sql))
	{
		$error = 'Error registering user: ' . mysqli_error($connection);
		include 'output.html.php';
		exit();
	}

	include 'output.html.php';
	exit();
}
/*************************************************************************/

if (isset($_GET['login']))
{
	include 'login.html.php';
	exit();
}

if (isset($_POST['action']) and $_POST['action'] == 'login' )
{
	$username = mysqli_real_escape_string($connection, $_POST['username']);
	$password = mysqli_real_escape_string($connection, $_POST['password']);
	
	$output = 'Username: ' . $username . ' Password: ' . $password;
	
	$sql = 'SELECT COUNT(*) FROM user WHERE username="'.$username.'" AND password="'.$password.'"';
	$result = mysqli_query($link, $sql);
	if (!$result)
	{
		$error = 'Error seeing if user exists in the DB.';
		include 'output.html.php';
		exit();
	}	
	
	if($result > 0) {
		$output .= '\nAccess Granted!';
	} else {
		$output .= '\nAccess Denied! Please register first...';
	}
	
	include 'output.html.php';
	exit();
}

$output = 'Database connection established.';
include 'output.html.php';
?>
