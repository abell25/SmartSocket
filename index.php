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
			$user = mysql_fetch_assoc($result);
			header('Location: http://www.yoursmartsocket.com/SmartSocket/getDevices.php?user_id=' . $user['user_id']);
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
		
		$output = 'Username: ' . $username . ' Email: ' . $email . ' Password: ' . $password;
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

		include 'output.html.php';
		exit();
    } else {
		include 'register.html.php';
		exit();
    }
} elseif (isset($_GET['specific']) and isset($_GET['id'])) {
	$id = $_GET['id'];
	$pagetitle = "Device page for ". $id;

	$sql = "SELECT nickname,schedule_last_modified,
				max_power_usage,max_cost,user_set_state
				,user.username AS owner FROM device,user
				WHERE device.user_id = user.user_id AND dev_id ='". $id."'";
	$result = mysqli_query($connection, $sql);
	if (!$result) {
			$error = 'Error finding info for device with id='.$id.': ' . mysqli_error($connection);
			include 'output.html.php';
			exit();
	}
	$row = mysqli_fetch_array($result);
	
	$output ='<ul>';
		$output .='<li>Device ID: '.$id.'</li>';
		$output .='<li>Device Nickname: '.$row['nickname'].'</li>';

		if(is_null($row['schedule_last_modified'])) {
			$output .='<li>Schedule was last modified: Schedule NOT set</li>';
		} else {
			$output .='<li>Schedule was last modified: '.$row['schedule_last_modified'].'</li>';
		}
		if(is_null($row['max_power_usage'])) {
			$output .='<li>Devices Set MAX power usage: NOT set</li>';
		} else {
			$output .='<li>Devices Set MAX power usage: '.$row['max_power_usage'].'W</li>';
		}
		if(is_null($row['max_cost'])) {
			$output .='<li>Devices Set MAX cost: NOT set</li>';
		} else {
			$output .='<li>Devices Set MAX cost: $'.$row['max_cost'].'</li>';
		}
		if(is_null($row['user_set_state'])) {
			$output .='<li>The user selected state for this device: NOT set</li>';
		} else {
			$output .='<li>The user selected state for this device: '.$row['user_set_state'].'</li>';
		}
		$output .='<li>Owner: '.$row['owner'].'</li>';
	$output .='</ul>';
	
	include 'specific_device_page.html.php';
	exit();
} else {  
    include '404.html.php';  // No page found
}

?>
