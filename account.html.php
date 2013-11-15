<?php
	include 'template.php';
	$P = array('title' => 'Account', 
				'css' => 'account.css');
	PrintHeader($P);
?>
<div id="main">
	<div class="content-section shadow">
		<form id="account_form" method="POST" action="?account">
				<h2>Account Information</h2><br/><br/>
			<p id="error_text" class="feedback"><?php echo $error ?></p><br/>
			<p id="success_text" class="feedback"><?php echo $success ?></p><br/>
			<label for="username">Username:</label>
			<input id="username"  class="text-input" type="text" name="username" value="<?php echo $username ?>"/><br/><br/>
			
			<label for="email">Email:</label>
			<input id="email" type="email" name="email" value="<?php echo $email ?>"/><br/><br/>
			
			<label for="power_cost">Power Cost (kW/h):</label>
			<input id="power_cost" class="text-input" type="text" name="power_cost" value="<?php echo $power_cost ?>"/><br/><br/>
			
			<label for="old_password">Old password:</label>
			<input id="old_password" class="text-input" type="password" name="old_password"/><br/><br/>
			<label for="new_password">New password:</label>
			<input id="new_password" class="text-input" type="password" name="new_password"/><br/><br/>
			<label for="new_password_confirmation">Confirm new password:</label>
			<input id="new_password_confirmation" class="text-input" type="password" name="new_password_confirmation"/><br/><br/>
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
	