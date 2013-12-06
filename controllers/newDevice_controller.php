<?php
	if('POST' == $_SERVER['REQUEST_METHOD']) {
		session_start();
		$user_id = $_SESSION['user_id'];
		$devices = getDevices($user_id);
		$dev_id = mysqli_real_escape_string($connection, $_POST['dev_id']);
        $nickname = mysqli_real_escape_string($connection, $_POST['nickname']);
		$max_power_usage = mysqli_real_escape_string($connection, $_POST['max_power_usage']);
		$max_cost = mysqli_real_escape_string($connection, $_POST['max_cost']);

		$error = '';
		$success = '';
		
		if($nickname == '') {
			$error .= 'Nickname must be assigned.';
			include 'newDevice.html.php';
			exit();
		}
		if($dev_id == '') {
			$error .= 'Device ID must be assigned.';
			include 'newDevice.html.php';
			exit();
		}
		if($dev_id > 65535 ) {
			$error .= 'Device ID must be less then 65535 (smallint)';
			include 'newDevice.html.php';
			exit();
		}
		
		$sql = '';
		$front_sql = 'INSERT INTO device(dev_id,user_id,nickname';
		$back_sql = 'VALUES ('.$dev_id.','.$user_id.',"'.$nickname.'"';
		
		if($max_power_usage !== '') {
			$front_sql .= ',max_power_usage';
			$back_sql .= ','.$max_power_usage;
		}
		if($max_cost !== '') {
			$front_sql .= ',max_cost';
			$back_sql .= ','.$max_cost;
		}
		$front_sql .= ') ';
		$back_sql .= ');';
		
		$sql = $front_sql . $back_sql;
		$result = mysqli_query($connection, $sql);
		if (!$result){
			$title = 'Device addition Error';
			$output = 'Error adding new device. Query: '. $sql;
			include 'output.html.php';
			exit();
		}	
		$success.="Successfully added ".$nickname;
		header('Location: index.php?deviceInfo&dev_id=' . $dev_id);
		exit();
    } else {
		$error = '';
		$success = '';
		session_start();
		$user_id = $_SESSION['user_id'];
		
		$dev_id = '';
		$nickname = '';
		$max_power_usage = '';
		$max_cost = '';
		$devices = getDevices($user_id);

        include 'newDevice.html.php';
		exit();
    }
	
	function getDevices($user_id) {
		include $_SERVER['DOCUMENT_ROOT'] . '/SmartSocket/includes/db_connection.php';
		$devices_query = sprintf("SELECT dev_id,nickname FROM device WHERE user_id='%s'",$user_id);
		$devices_result = mysqli_query($connection,$devices_query);
		if (!$devices_result){
			$title = 'Finding Devices Error';
			$output = 'Error finding users device info.';
			include 'output.html.php';
			exit();
		}
		$result = '';
		while($row = mysqli_fetch_assoc($devices_result)) {
			$result .= '<div class="devices"><button type="button".
						name="'.$row["dev_id"].'".
						onClick="window.location.href=\'index.php?deviceInfo&dev_id='.$row["dev_id"].'\'">'.
						$row["nickname"].'</button></div>';	
		}
		return $result;
	}
?>