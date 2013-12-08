<?php
include('connector/scheduler_connector.php');
include '../php_scripts/generateSchedules.php';

session_start();
$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM events WHERE device_id IN (SELECT dev_id FROM device WHERE user_id = $user_id)";

$res=mysql_connect('localhost','root','bitnami');
mysql_select_db("smartsocket");

$con_sched = new SchedulerConnector($res);

function updateModified($data) {
        $dev_id = $data->get_value("device_id");
        mysql_query('UPDATE device SET schedule_last_modified = CURRENT_TIMESTAMP WHERE dev_id = '.$dev_id);
		GenerateScheduleFile($dev_id);
}

$con_sched->event->attach("beforeInsert", "updateModified");
$con_sched->event->attach("beforeUpdate", "updateModified");
$con_sched->event->attach("beforeDelete", "updateModified");

$con_sched->render_sql($sql,"id","start_date,end_date,text,device_id");
?>


