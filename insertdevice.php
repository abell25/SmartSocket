<div>hey2</div>
<form id="submitdevice" method="post" action="insertdevice.php">
   device_id: <input type="text" name="device_id" required /><br />
   user_id: <input type="text" name="user_id" required /><br />
   nickname: <input type="text" name="nickname" required /><br />
  <input type="submit" value="Add Device!" />
</form>
<?php
echo "started..<br />";
if ($_POST['user_id']) echo "user: " . $_POST['user_id'] . "<br />";
if ($_POST['nickname']) echo "nickname: " . $_POST['nickname'] . "<br />";
if ($_POST['device_id']) echo "user: " . $_POST['device_id'] . "<br />";

$conn = mysql_connect('localhost','root','bitnami') or die(mysql_error()); 
mysql_select_db("SmartSocket") or die(mysql_error());
$sql = "INSERT INTO DEVICE (dev_id, user_id, nickname, schedule_last_modified, schedule, max_power_usage, max_cost) VALUES (" .
        "" . $_POST['device_id']  . ", " . 
        "" . $_POST['user_id']    . ", " .
        "'" . $_POST['nickname']    . "', " .
        "NOW(), 'MTF8a-9p', 12.22, 400.85" .
        ")";
echo "sql: " . $sql . "<br />";
mysql_query($sql) or die(mysql_error());
?>
