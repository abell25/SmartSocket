<?php
include 'template.php';
$P = array('title' => 'Login');

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

<form id="submitperson" method="post" action="login.php">
  username<input type="text" name="username" required /><br />
  password <input type="password" name="password" required /><br />
  <input type="submit" value="Login!" />
</form>
<?php echo $error; ?>


<?php PrintFooter($P); ?>