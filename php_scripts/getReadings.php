<?php
$dev_id = $_GET['dev_id'];

if (!isset($_GET['start_time'])) {
  $start_time = date("Y-m-d h:i:s", strtotime( '-1 days' ) );
} else {
  $start_time = $_GET['start_time'];
}

if (!isset($_GET['end_time'])) {
  $end_time = date("Y-m-d h:i:s", strtotime( '-0 days' ) );
} else {
  $end_time = $_GET['end_time'];
}
if (!isset($_GET['num_points'])) {
  $num_points = 50;
} else {
  $num_points = $_GET['num_points'];
}

$conn = mysql_connect('localhost','root','bitnami') or die(mysql_error());
mysql_select_db("SmartSocket") or die(mysql_error());

$sql = "select dev_id, time_id, amps, volts, state from reading where dev_id = $dev_id and time_id > date '$start_time' and time_id < date '$end_time' ";


//echo "sql: " . $sql . "<br />";

$result = mysql_query($sql) or die(mysql_error());

$total_count = mysql_num_rows($result);
$delta = floor($total_count/$num_points);
//echo 'delta is ' . $delta . '<br/>total is ' . $total_count . '<br/>';
$i = 0;
$readings = array();
while ($row = mysql_fetch_assoc($result)) { 
  $i++;
  if ( ($i % $delta) == 0 ) {
    array_push($readings, $row); 
  }
}

echo json_encode($readings);
?>