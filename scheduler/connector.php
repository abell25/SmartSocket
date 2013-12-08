<?php
include('connector/scheduler_connector.php');
include '../php_scripts/generateSchedules.php';

session_start();
$user_id = $_SESSION['user_id'];
$sql = "SELECT e.id, e.start_date, e.end_date, d.nickname AS text, e.device_id
         FROM events e JOIN device d ON e.device_id = d.dev_id
         WHERE d.user_id = $user_id";

$res=mysql_connect('localhost','root','bitnami');
mysql_select_db("smartsocket");

$con_sched = new SchedulerConnector($res);

function updateModified($data) {
        $dev_id = $data->get_value("device_id");
        mysql_query('UPDATE device SET schedule_last_modified = CURRENT_TIMESTAMP WHERE dev_id = '.$dev_id);
		mysql_query('UPDATE events SET text = (SELECT nickname FROM device WHERE dev_id = '.$dev_id.')
					WHERE device_id = '.$dev_id);
}

function updateModifiedScheduleFile($data) {
        $dev_id = $data->get_value("device_id");
		GenerateScheduleFile($dev_id);
}

$con_sched->event->attach("beforeInsert", "updateModified");
$con_sched->event->attach("beforeUpdate", "updateModified");
$con_sched->event->attach("beforeDelete", "updateModified");

$con_sched->event->attach("afterInsert", "updateModifiedScheduleFile");
$con_sched->event->attach("afterUpdate", "updateModifiedScheduleFile");
$con_sched->event->attach("afterDelete", "updateModifiedScheduleFile");

if ($con_sched->is_select_mode())
        $con_sched->render_complex_sql($sql,"id","start_date,end_date,text,device_id");
else
        $con_sched->render_table("events","id","start_date,end_date,text,device_id");

?>


