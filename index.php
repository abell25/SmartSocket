<?php
include $_SERVER['DOCUMENT_ROOT'] . '/SmartSocket/includes/db_connection.php';

if(isset($_GET['login'])) {
    if('POST' == $_SERVER['REQUEST_METHOD']) {
        $username = mysqli_real_escape_string($connection, $_POST['username']);
		$password = mysqli_real_escape_string($connection, $_POST['password']);
		
		$output = 'Username: ' . $username . '<br/>Password: ' . $password;
		
		$sql = 'SELECT * FROM user WHERE username="'.$username.'" AND password="'.$password.'"';
		$result = mysqli_query($connection, $sql);
		if (!$result){
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
    } else {
        include 'login.html.php';
		exit();
    }
} elseif (isset($_GET['register'])) {
    if('POST' == $_SERVER['REQUEST_METHOD']) {
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
    } else {
		include 'register.html.php';
		exit();
    }
} else {  
    include '404.html.php';  // No page found
}

?>
