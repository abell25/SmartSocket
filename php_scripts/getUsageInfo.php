<?php
$dev_id = $_GET['dev_id'];

$conn = mysql_connect('localhost','root','bitnami') or die(mysql_error());
mysql_select_db("SmartSocket") or die(mysql_error());

$sql = "select D.max_power_usage, D.max_cost, U.power_cost, D.nickname, D.user_set_state  from device D join user U on U.user_id = D.user_id where D.dev_id = $dev_id";

$result = mysql_query($sql) or die(mysql_error());
$data = mysql_fetch_assoc($result);
echo json_encode($data);
?>