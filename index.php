<?php
include $_SERVER['DOCUMENT_ROOT'] . '/SmartSocket/includes/db_connection.php';

//*********************Registration page code***************************/
if (isset($_GET['register']))
{
	include 'register.html.php';
	exit();
}

if (isset($_POST['action']) and $_POST['action'] == 'register_form') {
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

if (isset($_POST['action']) and $_POST['action'] == 'login_form' )
{
	$username = mysqli_real_escape_string($connection, $_POST['username']);
	$password = mysqli_real_escape_string($connection, $_POST['password']);
	
	$output = 'Username: ' . $username . ' Password: ' . $password;
	
	$sql = 'SELECT COUNT(*) FROM user WHERE username="'.$username.'" AND password="'.$password.'"';
	$result = mysqli_query($connection, $sql);
	if (!$result)
	{
		$error = 'Error seeing if user exists in the DB.';
		include 'output.html.php';
		exit();
	}	
	
	$num = mysqli_num_rows($result);
	if($num > 0) {
		$output .= '<br/>Access Granted!';
	} else {
		$output .= '<br/>Access Denied! Please register first...';
	}
	
	include 'output.html.php';
	exit();
}

?>
