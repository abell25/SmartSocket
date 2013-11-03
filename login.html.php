<?php
	include_once $_SERVER['DOCUMENT_ROOT'].'/SmartSocket/includes/helpers.inc.php';
	include 'template.php';
	$P = array('title' => 'Login', 
		   'css' => 'login_registeration.css');
	PrintHeader($P);
?>
	<form id="login_form" method="POST" action="?login">
		<p id="error_text"><?php echo $error ?></p><br/>
		<label for="username-id">Username:</label>
		<input id="username-id" type="text" name="username" autofocus="autofocus" required="required"/><br/><br/>
		
		<label for="password1-id">Password:</label>
		<input id="password1-id" class="text-input" type="password" name="password" required="required"/><br/><br/>
		
		<input type="submit" value="Login"/><p>Don't have an account?<a href="?register"> Register</a><p>
	</form>
  </body>
</html>