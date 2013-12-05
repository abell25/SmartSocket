<?php
//$user_id = $_SESSION['user_id'];

function GenerateScheduleFile($deviceID)
{

$conn = mysql_connect('localhost','root','bitnami') or die(mysql_error());
mysql_select_db("SmartSocket") or die(mysql_error());

$sql = "SELECT id, start_date, end_date, text FROM events WHERE id = " . $deviceID;

//echo "sql: " . $sql . "<br />";

$result = mysql_query($sql) or die(mysql_error());
$devices = array();

echo "File name: " . $deviceID;
echo "<br>";

while ($row = mysql_fetch_assoc($result))
{
	echo date_format($row['start_date'], 'U');
	echo ";";
	echo date_format($row['end_date'], 'U');
	echo "<br>";
}

}
//echo json_encode($devices);
?>