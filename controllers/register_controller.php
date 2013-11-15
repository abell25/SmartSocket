<?php
if('POST' == $_SERVER['REQUEST_METHOD']) {
        $username = mysqli_real_escape_string($connection, $_POST['username']);
		$email = mysqli_real_escape_string($connection, $_POST['email']);
		$password = mysqli_real_escape_string($connection, $_POST['password']);
		$password_repeat = mysqli_real_escape_string($connection, $_POST['password_repeat']);
		
		$output = '';
		$error = '';
		
		$sql = 'SELECT * FROM user WHERE username="'.$username.'"';
		$result = mysqli_query($connection, $sql);
		if (!$result){
			$error .= 'Error seeing if username already exists in the DB.';
			include 'output.html.php';
			exit();
		} else {
			$num = mysqli_num_rows($result);
			if($num > 0) {
				$error .= 'Username is already taken';
				include 'register.html.php';
				exit();
			} elseif($password != $password_repeat) {
				$error .= 'Passwords do not match.';
				include 'register.html.php';
				exit();
			}
		}
		
		$sql = 'INSERT INTO user (username,email,password) VALUES
				("'. $username .'","'. $email .'","'. $password .'")';
			
		if (!mysqli_query($connection, $sql))
		{
			$error = 'Error registering user: ' . mysqli_error($connection);
			include 'output.html.php';
			exit();
		}

		$output .= '<p id="success">Congratulations '. $username .' you have successfully
						been registered. Please visit the <a href="?login">login</a> page.</p>';
		$title = 'Successful Registration';
		include 'output.html.php';
		exit();
    } else {
		include 'register.html.php';
		exit();
    }
?>