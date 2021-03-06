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

$old_dev_id = 0;

function updateModified($data) {
        $id = $data->get_value("id");
        $dev_id = $data->get_value("device_id");
        $result = mysql_query('SELECT device_id FROM events WHERE id = '.$id);
		global $old_dev_id;
        $old_dev_id = (int)mysql_result($result, 0, 'device_id');
        if ($result && $old_device_id != $dev_id) {
                mysql_query('UPDATE device
                        SET schedule_last_modified = CURRENT_TIMESTAMP
                        WHERE dev_id = '.$old_dev_id);
        }
        mysql_query('UPDATE device SET schedule_last_modified = CURRENT_TIMESTAMP WHERE dev_id = '.$dev_id);
        mysql_query('UPDATE events SET text = (SELECT nickname FROM device WHERE dev_id = '.$dev_id.')
                                        WHERE device_id = '.$dev_id);
}

function updateModifiedScheduleFile($data) {
        $dev_id = $data->get_value("device_id");
		global $old_dev_id;
		GenerateScheduleFile($dev_id);
		GenerateScheduleFile($old_dev_id);
		//GenerateAllScheduleFiles();
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


