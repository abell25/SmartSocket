<?php
function GenerateScheduleFile($deviceID)
{

$conn = mysql_connect('localhost','root','bitnami') or die(mysql_error());
mysql_select_db("SmartSocket") or die(mysql_error());

$sql = 'SELECT id, start_date, end_date, text FROM events WHERE device_id = ' . $deviceID;

$result = mysql_query($sql) or die(mysql_error());
$devices = array();

$file = fopen("../ScheduleFiles/" . $deviceID . ".txt", "w+");


while ($row = mysql_fetch_assoc($result))
{
	fwrite($file, strtotime($row['start_date']) . ";" . strtotime($row['end_date']) . "\n");
}

fclose($file);

}
?>