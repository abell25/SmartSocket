<?php
include $_SERVER['DOCUMENT_ROOT'] . '/SmartSocket/includes/db_connection.php';

if(isset($_GET['login'])) {
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
} elseif (isset($_GET['register'])) {
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
} elseif (isset($_GET['account'])) {
	if('POST' == $_SERVER['REQUEST_METHOD']) {
		session_start();
		$user_id = $_SESSION['user_id'];
        $username = mysqli_real_escape_string($connection, $_POST['username']);
		$email = mysqli_real_escape_string($connection, $_POST['email']);
		//$password = mysqli_real_escape_string($connection, $_POST['password']);
		//$password_repeat = mysqli_real_escape_string($connection, $_POST['password_repeat']);
		$power_cost = mysqli_real_escape_string($connection, $_POST['power_cost']);
		
		$error = '';
		$success = '';
		$sql = sprintf("UPDATE user SET username='%s',email='%s',power_cost='%s' WHERE user_id='%s';",$username,$email,$power_cost,$user_id);

		$result = mysqli_query($connection, $sql);
		if (!$result){
			$error .= 'Error assigning values to user.';
			include 'account.html.php';
			exit();
		}	
		$success.="Successfully updated account info";
		include 'account.html.php';
		exit();
    } else {
		$error = '';
		$success = '';
		session_start();
		$sql = sprintf("SELECT username,email,power_cost FROM user WHERE user_id='%s'",$_SESSION['user_id']);
		$result = mysqli_query($connection,$sql);
		
		if (!$result){
			$error = 'Error finding users info.';
			include 'account.html.php';
			exit();
		}
	
		$info = mysqli_fetch_assoc($result);
		
		$username = $info['username'];
		$email = $info['email'];
		$power_cost = $info['power_cost'];
		
        include 'account.html.php';
		exit();
    }
} else {  
    include '404.html.php';  // No page found
}

?>
