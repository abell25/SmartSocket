<?php
    if('POST' == $_SERVER['REQUEST_METHOD']) {
        $username = mysqli_real_escape_string($connection, $_POST['username']);
		$password = mysqli_real_escape_string($connection, $_POST['password']);
		
		$output = 'Username: ' . $username . '<br/>Password: ' . $password;
		$error = '';
		
		$sql = sprintf("SELECT * FROM user WHERE username='%s' and password='%s'",$username, $password);

		$result = mysqli_query($connection, $sql);
		if (!$result){
			$error .= 'Error seeing if user exists in the DB.';
			include 'output.html.php';
			exit();
		}	
		

		$num = mysqli_num_rows($result);
		if($num > 0) {
			session_start();
			$user = mysqli_fetch_assoc($result);
			$_SESSION['user_id'] = $user['user_id'];
			$_SESSION['username'] = $user['username'];
			header('Location: getDevices.php?user_id=' . $_SESSION['user_id']);
		} else {
			$error .= 'Access Denied. username/password combination do not match.';
			include 'login.html.php';
			exit();
		}
		
		include 'output.html.php';
		exit();
    } else {
        include 'login.html.php';
		exit();
    }
?>