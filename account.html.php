<?php
	include 'template.php';
	$P = array('title' => 'Account', 
						'css' => 'account.css');
	PrintHeader($P);
?>
<div id="main">
	<div class="content-section shadow">
		<form id="account_form" method="POST" action="?account">
			<p id="error_text" class="feedback"><?php echo $error ?></p><br/>
			<p id="success_text" class="feedback"><?php echo $success ?></p><br/>
			<label for="username">Username:</label>
			<input id="username"  class="text-input" type="text" name="username" value="<?php echo $username ?>"/><br/><br/>
			
			<label for="email">Email:</label>
			<input id="email" type="email" name="email" value="<?php echo $email ?>"/><br/><br/>
			
			<label for="power_cost">Power Cost (kW/h):</label>
			<input id="power_cost" class="text-input" type="text" name="power_cost" value="<?php echo $power_cost ?>"/><br/><br/>
			
			<label for="password">Password:</label>
			<input id="password" class="text-input" type="password" name="password"/><br/><br/>
			<div id="submit_holder">
				<input type="submit" value="Update"/>
			</div>
		</form>
	</div>
</div>
<div id="sidebar" class="shadow">
	<h1>Devices</h1>
		<?php echo $devices ?>
<?php PrintFooter($P); ?>
	
	