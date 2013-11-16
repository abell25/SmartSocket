<?php
	if('POST' == $_SERVER['REQUEST_METHOD']) {
		session_start();
		$user_id = $_SESSION['user_id'];
		$devices = getDevices($user_id);
        $username = mysqli_real_escape_string($connection, $_POST['username']);
		$email = mysqli_real_escape_string($connection, $_POST['email']);
		$power_cost = mysqli_real_escape_string($connection, $_POST['power_cost']);
		$old_pw = mysqli_real_escape_string($connection, $_POST['old_password']);
		$new_pw = mysqli_real_escape_string($connection, $_POST['new_password']);
		$new_pw_confirmation = mysqli_real_escape_string($connection, $_POST['new_password_confirmation']);
		
		$error = '';
		$success = '';
		
		if($old_pw !== '') {
			if($new_pw != $new_pw_confirmation) {
				$error .= 'New password does not match its confirmation value.';
				include 'account.html.php';
				exit();
			} 
			if($new_pw == '' || $new_pw_confirmation == '') {
				$error .= 'Must provide new password and confirmation of new password to change your password.';
				include 'account.html.php';
				exit();
			} 
			$sql = sprintf("SELECT username FROM user WHERE user_id='%s' and password='%s'",$user_id, $old_pw);
			$result = mysqli_query($connection, $sql);
			if (!$result){
				$title = 'Account Management Error';
				$output = 'Error validating old password.';
				include 'output.html.php';
				exit();
			}	
			$num = mysqli_num_rows($result);
			if($num <= 0) {
				$error .= 'Old password not recognized';
				include 'account.html.php';
				exit();
			}
		}
		if($username == '') {
			$error .= 'Must have a username.';
			include 'account.html.php';
			exit();
		}
		if($email == '') {
			$error .= 'Must have an email';
			include 'account.html.php';
			exit();
		}
		
		$sql = "UPDATE user SET"
					." username='".$username."'"
					." ,email='".$email."'"
					." ,power_cost='".$power_cost."'";
					if($new_pw !== '') {
						$sql .= " ,password='".$new_pw."'";
					}
		$sql .= " WHERE user_id='".$user_id."';";

		$result = mysqli_query($connection, $sql);
		if (!$result){
			$title = 'Account Managment Error';
			$output = 'Error assigning values to user.';
			include 'output.html.php';
			exit();
		}	
		$success.="Successfully updated account info";
		include 'account.html.php';
		exit();
    } else {
		$error = '';
		$success = '';
		session_start();
		$user_id = $_SESSION['user_id'];
		$devices = getDevices($user_id);
		
		$info_query = sprintf("SELECT username,email,power_cost FROM user WHERE user_id='%s'",$user_id);
		$info_result = mysqli_query($connection,$info_query);
		if (!$info_result){
			$title = 'Account Management Error';
			$error .= 'Error finding users info.';
			include 'output.html.php';
			exit();
		}
		$info = mysqli_fetch_assoc($info_result);
		$username = $info['username'];
		$email = $info['email'];
		$power_cost = $info['power_cost'];

        include 'account.html.php';
		exit();
    }
	
	function getDevices($user_id) {
		include $_SERVER['DOCUMENT_ROOT'] . '/SmartSocket/includes/db_connection.php';
		$devices_query = sprintf("SELECT dev_id,nickname FROM device WHERE user_id='%s'",$user_id);
		$devices_result = mysqli_query($connection,$devices_query);
		if (!$devices_result){
			$title = 'Finding Devices Error';
			$error = 'Error finding users device info.';
			exit();
		}
		
		//TODO: Add links to the divs to go to a specifc device page (specifc device page will be easier in that it will only have values that can be updated (not like password))
		$result = '';
		while($row = mysqli_fetch_assoc($devices_result)) {
			$result .= '<div class="devices"><button type="button" name="'.$row["dev_id"].'">'.$row["nickname"].'</button></div>';			
		}
		
		return $result;
	}
?>