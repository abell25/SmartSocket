<?php 
include('connector/scheduler_connector.php');
 
$res=mysql_connect('localhost','root','bitnami');
mysql_select_db("smartsocket");
 
$calender = new SchedulerConnector($res);
 
$calender->render_table("events","id","start_date,end_date,text");
?>