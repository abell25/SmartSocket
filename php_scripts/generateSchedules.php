<?php
//$user_id = $_SESSION['user_id'];

function GenerateScheduleFiles($id)
{

$conn = mysql_connect('localhost','root','bitnami') or die(mysql_error());
mysql_select_db("SmartSocket") or die(mysql_error());

$sql = "SELECT id, start_date, end_date, text FROM events WHERE id = " . $id;

//echo "sql: " . $sql . "<br />";

$result = mysql_query($sql) or die(mysql_error());
$devices = array();

echo "File name: " . $id;
echo "<br>";

while ($row = mysql_fetch_assoc($result))
{
	echo $row['id'] . " " . $row['start_date'] . " " . $row['end_date'] . " " . $row['text'];
	echo "<br>";
}

}
//echo json_encode($devices);
?>