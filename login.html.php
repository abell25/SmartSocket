<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/SmartSocket/includes/helpers.inc.php';
include 'template.php';
$P = array('title' => 'Login', 
	   'css' => 'login_registeration.css');

$username = $_POST['username'];
$password = $_POST['password'];
$error = ' ';
if (isset($_POST['username']) and isset($_POST['password'])){
  $conn = mysql_connect('localhost','root','bitnami') or die(mysql_error());
  mysql_select_db("SmartSocket") or die(mysql_error());
  $sql = sprintf("SELECT * FROM user WHERE username='%s' and password='%s'", 
		 mysql_real_escape_string($username), mysql_real_escape_string($password));
  $result = mysql_query($sql) or die(mysql_error());

  if(mysql_num_rows($result)==0) { 
    $error = 'incorrect username/password!'; 
  } else {
    $user = mysql_fetch_assoc($result);
    header('Location: http://www.yoursmartsocket.com/SmartSocket/getDevices.php?user_id=' . $user['user_id']);
  }  
}
?>
<?php PrintHeader($P); ?>

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

<?php PrintFooter($P); ?>