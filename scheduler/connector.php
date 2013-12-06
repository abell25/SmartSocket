<?php 
include('connector/scheduler_connector.php');

session_start();
$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM events WHERE text IN (SELECT nickname FROM device WHERE user_id = $user_id)";
  
$res=mysql_connect('localhost','root','bitnami');
mysql_select_db("smartsocket");
 
$calender = new SchedulerConnector($res);
 
$calender->render_sql($sql,"id","start_date,end_date,text");
?>
