<?php include_once $_SERVER['DOCUMENT_ROOT'] .
		'/SmartSocket/includes/helpers.inc.php'; ?>
<!DOCTYPE html>
<html>
	<head>
		<title>Registration</title>
		<!--link type="text/css" rel="stylesheet" href="stylesheet.css"/-->
	</head>
	<body>	
		<div id="content">
			<form id="registration_form" method="POST" action="?register">

				<label for="username-id">Username:</label>
				<input id="username-id" type="text" name="username" required="required" autofocus="autofocus" /><br/><br/>
				
				<label for="email-id">Email:</label>
				<input id="email-id" type="email" required="required" name="email" /><br/><br/>
				
				<label for="password1-id">Password:</label>
				<input id="password1-id" class="text-input" required="required" type="password" name="password" /><br/><br/>
				
				<label for="password2-id">Retype Password:</label>
				<input id="password2-id" class="text-input" required="required" type="password" name="password_repeat" /><br/><br/>
				
				<input type="submit" value="Register"/>
			</form>
		</div>
	</body>
</html>