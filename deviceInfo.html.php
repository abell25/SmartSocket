<?php
	include 'template.php';
	$P = array('title' => 'Device Management', 
				'css' => 'account.css');
	PrintHeader($P);
?>
<div id="main">
	<div class="content-section shadow">
		<form id="dev_info_form" method="POST" action="?deviceInfo&dev_id=<?php echo $dev_id ?>">
			<h2>Device: <?php echo $nickname ?></h2>
			<button id="delete" type="button" onClick="window.location.href='index.php?deviceInfo&dev_id=<?php echo $dev_id ?>&nickname=<?php echo $nickname ?>&confirmation=true'">Delete</button><br/><br/>
			<p id="error_text" class="feedback"><?php echo $error ?></p><br/>
			<p id="success_text" class="feedback"><?php echo $success ?></p><br/>
			<label>Device ID:</label>
			<label><?php echo $dev_id ?></label><br/><br/>
			
			<label for="nickname">Nickname:</label>
			<input id="nickname"  class="text-input" type="text" name="nickname" value="<?php echo $nickname ?>"/><br/><br/>
			
			<label for="max_power_usage">Max usage (kW/h):</label>
			<input id="max_power_usage" class="text-input" type="text" name="max_power_usage" value="<?php echo $max_power_usage ?>"/><br/><br/>
			
			<label for="max_cost">Max cost:</label>
			<input id="max_cost" class="text-input" type="text" name="max_cost" value="<?php echo $max_cost ?>"/><br/><br/>
			
			<div id="submit_holder">
				<input type="submit" value="Update"/>
			</div>
		</form>
	</div>
</div>
<div id="sidebar" class="shadow">
	<h1>Devices</h1>
		<?php echo $devices ?>
		<?php echo '<div class="devices"><button id="newDevice" type="button" '.
					'onClick="window.location.href=\'index.php?newDevice\'">'.
					'Add New Device</button></div>' ?>
<?php PrintFooter($P); ?>
	