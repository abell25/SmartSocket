<?php
#include $_SERVER['DOCUMENT_ROOT'] . '/SmartSocket/includes/db_connection.php';

$dev_id = $_GET['dev_id'];

$conn = mysql_connect('localhost','root','bitnami') or die(mysql_error());
mysql_select_db("SmartSocket") or die(mysql_error());
//echo "user_set_state = [".$_GET['user_set_state']."]\n";

$sql = 'UPDATE device set ';
$columns = array();
if (isset($_GET['nickname']) and !empty($_GET['nickname']))
  array_push($columns, "nickname = '" . $_GET['nickname'] . "'"); 
if (isset($_GET['schedule']) and !empty($_GET['schedule']))
  array_push($columns, "schedule = '" . $_GET['schedule'] . "'"); 
if (isset($_GET['max_power_usage']) and !empty($_GET['max_power_usage']))
  array_push($columns, "max_power_usage = " . $_GET['max_power_usage'] . ""); 
if (isset($_GET['max_cost']) and !empty($_GET['max_cost']))
  array_push($columns, "max_cost = " . $_GET['max_cost'] . ""); 
if (isset($_GET['user_set_state']))
  array_push($columns, "user_set_state = " . $_GET['user_set_state'] . ""); 

$sql = $sql . implode(", ", $columns) . " where dev_id = $dev_id";

echo "sql: " . $sql . "<br />";

mysql_query($sql) or die(mysql_error());

?>