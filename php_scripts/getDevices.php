<?php
$user_id = $_SESSION['user_id'];

$conn = mysql_connect('localhost','root','bitnami') or die(mysql_error());
mysql_select_db("SmartSocket") or die(mysql_error());

$sql = "SELECT dev_id, nickname, schedule, max_power_usage, max_cost, user_set_state from device where user_id=$user_id";

//echo "sql: " . $sql . "<br />";

$result = mysql_query($sql) or die(mysql_error());
$devices = array();
while ($row = mysql_fetch_assoc($result)) { array_push($devices, $row); }
echo json_encode($devices);
?>