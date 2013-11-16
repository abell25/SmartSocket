<?php
	if('POST' == $_SERVER['REQUEST_METHOD']) {
		session_start();
		$user_id = $_SESSION['user_id'];
		$devices = getDevices($user_id);
		$dev_id = mysqli_real_escape_string($connection, $_GET['dev_id']);
        $nickname = mysqli_real_escape_string($connection, $_POST['nickname']);
		$max_power_usage = mysqli_real_escape_string($connection, $_POST['max_power_usage']);
		$max_cost = mysqli_real_escape_string($connection, $_POST['max_cost']);

		$error = '';
		$success = '';
		
		if($nickname == '') {
			$error .= 'Nickname must be assigned.';
			include 'deviceInfo.html.php'; 
			exit();
		}
		
		$sql = 'UPDATE device SET nickname="'.$nickname.'"';
		
		if($max_power_usage !== '') {
			$sql .= ',max_power_usage='.$max_power_usage;
		} else {
			$sql .= ',max_power_usage=NULL';
		} 
		if($max_cost !== '') {
			$sql .= ',max_cost='.$max_cost;
		} else {
			$sql .= ',max_cost=NULL';
		}
		$sql .= " WHERE dev_id='".$dev_id."';";
		
		$result = mysqli_query($connection, $sql);
		if (!$result){
			$title = 'Device update Error';
			$output = 'Error updating device. Query: '. $sql;
			include 'output.html.php';
			exit();
		}	
		$success.= "Successfully updated ".$nickname."'s info.";
		include 'deviceInfo.html.php'; 
		exit();
    } else {
		if(empty($_GET['confirmation'])) {
			$error = '';
			$success = '';
			session_start();
			$user_id = $_SESSION['user_id'];
			$devices = getDevices($user_id);
			$dev_id = mysqli_real_escape_string($connection, $_GET['dev_id']);
			
			$info_query = sprintf("SELECT nickname,max_power_usage,max_cost FROM device WHERE dev_id='%s'",$dev_id);
			$info_result = mysqli_query($connection,$info_query);
			if (!$info_result){
				$title = 'Device Management Error';
				$output = 'Error finding devices info.';
				include 'output.html.php';
				exit();
			}
			$info = mysqli_fetch_assoc($info_result);
			$nickname = $info['nickname'];
			$max_power_usage = $info['max_power_usage'];
			$max_cost = $info['max_cost'];

			include 'deviceInfo.html.php';
			exit();
		} elseif(isset($_GET['confirmation']) && empty($_GET['delete'])) {
			$nickname = mysqli_real_escape_string($connection, $_GET['nickname']);
			$dev_id = mysqli_real_escape_string($connection, $_GET['dev_id']);
			include 'confirmation.html.php';
			exit();
		} elseif(isset($_GET['delete'])) {
			$dev_id = mysqli_real_escape_string($connection, $_GET['dev_id']);
			include $_SERVER['DOCUMENT_ROOT'] . '/SmartSocket/includes/db_connection.php';
			mysqli_query($connection,'DELETE FROM device WHERE dev_id='.$dev_id);
			header('Location: index.php?account');
			exit();
		}
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