<div>hey</div>
<form id="submitperson" method="post" action="testdb.php">
  username<input type="text" name="username" required /><br />
  email <input type="email" name="email" required /><br />
  password <input type="password" name="password" required /><br />
  <input type="submit" value="Add User!" />
</form>
<?php
echo "started..<br />";
if ($_POST['username']) echo "user: " . $_POST['username'] . "<br />";
if ($_POST['email']) echo "email: " . $_POST['email'] . "<br />";
if ($_POST['password']) echo "password: " . $_POST['password'] . "<br />";
//if (!$_POST['username'] || !$_POST['email'] || !_POST['username']){
  //return;
  //}
$conn = mysql_connect('localhost','root','bitnami') or die(mysql_error()); //10.137.2.94 yoursmartsocket.com
mysql_select_db("SmartSocket") or die(mysql_error());
$sql = "INSERT INTO USER (username, email, password) VALUES (" . 
        "'" . $_POST['username'] . "', " .
        "'" . $_POST['email']    . "', " .
        "'" . $_POST['password'] . "'"   .
        ")";
echo "sql: " . $sql . "<br />";
mysql_query($sql) or die(mysql_error());

?>
