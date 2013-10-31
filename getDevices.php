<?php
//echo "getting sockets for user..<br />";
include 'template.php';
$user_id = $_GET['user_id'];

$conn = mysql_connect('localhost','root','bitnami') or die(mysql_error());
mysql_select_db("SmartSocket") or die(mysql_error());

$sql = "SELECT dev_id, nickname, schedule, max_power_usage, max_cost, user_set_state from device where user_id=$user_id";

//echo "sql: " . $sql . "<br />";

$result = mysql_query($sql) or die(mysql_error());
$P = array('title' => 'Devices', 
	   'css' => 'getDevices.css',
	   'js'  => 'getDevices.js');
PrintHeader($P);
echo '<ul id="sockets_list">';
while($row = mysql_fetch_assoc($result)) {
  $dev_id =  $row['dev_id'];
  $nickname = $row['nickname'];
  $state = $row['user_set_state'];
  $max_cost = $row['max_cost']; 
?>
<div class="content-section">
  <h2>Device <?php echo $dev_id;  ?></h2>
  <div class="onoffswitch" id="dev_id_div<?php echo $dev_id; ?>">
    <input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox" id="dev_id_<?php echo $dev_id; ?>" <?php echo ($state)? "checked": ""; ?>>
    <label class="onoffswitch-label" for="dev_id_<?php echo $dev_id; ?>">
      <div class="onoffswitch-inner"></div>
      <div class="onoffswitch-switch"></div>
    </label>
  </div>
  <div class="link-separator"></div>
  <h1>Max Cost: </h1>
  <p><?php echo $max_cost; ?></p>
</div>
<?php
}
echo '</ul>';
PrintFooter();
?>
