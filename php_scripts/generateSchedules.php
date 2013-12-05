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

//$file = fopen("ScheduleFiles/test.txt", "w+") or die("failed to open file");

if (!@fopen("ScheduleFiles/test.txt", "w+"))
{
	echo "Error: ";
    print_r(error_get_last());
	echo "<br>";
}

echo "File successful: " . $file;
echo "<br>";

//$file = fopen(/*"ScheduleFiles/" . */$deviceID . ".txt", "w+");
echo "File name: " . $deviceID;
echo "<br>";

while ($row = mysql_fetch_assoc($result))
{
	echo strtotime($row['start_date']);
	echo ";";
	echo strtotime($row['end_date']);
	echo "<br>";
}

fclose($file);

}
//echo json_encode($devices);
?>