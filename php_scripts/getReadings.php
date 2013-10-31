<?php
$dev_id = $_GET['dev_id'];

$conn = mysql_connect('localhost','root','bitnami') or die(mysql_error());
mysql_select_db("SmartSocket") or die(mysql_error());

$sql = "select dev_id, time_id, amps, volts, state from reading where dev_id = $dev_id";

//echo "sql: " . $sql . "<br />";

$result = mysql_query($sql) or die(mysql_error());
$readings = array();
while ($row = mysql_fetch_assoc($result)) { array_push($readings, $row); }
echo json_encode($readings);
?>