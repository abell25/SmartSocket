<?php
	include $_SERVER['DOCUMENT_ROOT'] . '/SmartSocket/index.php';

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
?>