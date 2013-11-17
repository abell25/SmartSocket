<?php 
require_once("scheduler_connector.php");
 
$res=mysql_connect("localhost","root","bitnami");
mysql_select_db("SmartSocket");
 
$conn = new SchedulerConnector($res);
 
$conn->render_table("events","id","start_date,end_date,text");
?>