<?php
	include 'template.php';
	$P = array('title' => 'New Device', 
				'css' => 'account.css');
	PrintHeader($P);
?>
<div id="main">
	<div class="content-section shadow">
		<form id="account_form" method="POST" action="?newDevice">
				<h2>New Device</h2><br/><br/>
			<p id="error_text" class="feedback"><?php echo $error ?></p><br/>
			<p id="success_text" class="feedback"><?php echo $success ?></p><br/>
			<label for="dev_id">Device ID:</label>
			<input id="dev_id"  class="text-input" type="text" name="dev_id" value="<?php echo $dev_id ?>"/><br/><br/>
			
			<label for="nickname">Nickname:</label>
			<input id="nickname"  class="text-input" type="text" name="nickname" value="<?php echo $nickname ?>"/><br/><br/>
			
			<label for="max_power_usage">Max usage (kW/h):</label>
			<input id="max_power_usage" class="text-input" type="text" name="max_power_usage" value="<?php echo $max_power_usage ?>"/><br/><br/>
			
			<label for="max_cost">Max cost:</label>
			<input id="max_cost" class="text-input" type="text" name="max_cost" value="<?php echo $max_cost ?>"/><br/><br/>
			
			<div id="submit_holder">
				<input id="saveButton" type="submit" value="Save"/>
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
	