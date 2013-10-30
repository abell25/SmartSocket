<div>Submit Reading</div>
<form id="submitperson" method="put" action="insertrecord.php">
  device id <input type="text" name="dev_id" required /><br />
  time <input type="text" name="time_id" required /><br />
  amps <input type="text" name="amps" required /><br />
  volts <input type="text" name="volts" required /><br />
  state <input type="text" name="state" required /><br />
  <input type="submit" value="Add Reading!" />
</form>
<?php
echo "started..<br />";

$conn = mysql_connect('localhost','root','bitnami') or die(mysql_error()); //10.137.2.94 yoursmartsocket.com
mysql_select_db("SmartSocket") or die(mysql_error());
$sql = "INSERT INTO READING (dev_id, time_id, amps, volts, state) VALUES (" . 
  $_GET['dev_id'] . ", '" . $_GET['time_id'] . "', " . $_GET['amps'] . ", " . 
  $_GET['volts'] . ", " . $_GET['state'] . 
       ")";
echo "sql: " . $sql . "<br />";
mysql_query($sql) or die(mysql_error());
?>
