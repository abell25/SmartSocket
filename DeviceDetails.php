<?php
//echo "getting sockets for user..<br />";
include 'template.php';
$P = array('title' => 'Devices', 
	   'css' => 'DeviceDetails.css',
	   'js'  => 'DeviceDetails.js');
PrintHeader($P);
?>
<h2 id="device_name"></h2>
<form>
<input type="button" value="Print page" onClick="window.print()" style="float:right;">
<div style="float:right;"><a id="download_data">Download excel data</a></div>
</form>
<div id="daterange" style="margin-bottom:20px;">
    Start <input type="date" name="start_date" id="start_date" />
    End <input type="date" name="end_date" id="end_date" />
    <input type="submit" value="Update" onclick="GetPoints();"/>
</div>
<div id="the_graphs">
  <div id="usage" style="height:300px;width:400px;float:left;"></div>
  <div id="cost" style="height:300px;width:400px;float:left;margin-left:100px;"></div>
</div>
<!--
<table>
<thead>
  <tr><td>Time</td><td>Amps</td><td>Volts</td><td>state</td></tr>
</thead>
<tbody data-bind="foreach: readings">
  <tr>
  <td data-bind="text: time_id"></td>
  <td data-bind="text: amps"></td>
  <td data-bind="text: volts"></td>
  <td data-bind="text: state"></td>
  </tr>
</tbody>
</table>
-->
<?php PrintFooter($P); ?>

<script>
dev_id = <?php echo $_GET['dev_id']; ?>;
the_data = <?php include 'php_scripts/getReadings.php'; ?>;
the_readings = the_data.map(function(el) { return new Reading(el); });
the_points = the_data.map(function(el) { return [el.time_id, el.amps]; });
usageInfo = <?php include 'php_scripts/getUsageInfo.php'; ?>;
max_cost = parseFloat(usageInfo['max_power_usage']);
max_power_usage = parseFloat(usageInfo['max_power_usage']);
power_cost = parseFloat(usageInfo['power_cost']);
user_set_state = usageInfo['user_set_state'];
nickname = usageInfo['nickname'];
</script>
