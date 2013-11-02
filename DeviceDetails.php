<?php
//echo "getting sockets for user..<br />";
include 'template.php';
$P = array('title' => 'Devices', 
	   'css' => 'DeviceDetails.css',
	   'js'  => 'DeviceDetails.js');
PrintHeader($P);
?>
<h2>Device Details</h2>
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
<?php PrintFooter($P); ?>
<script>
dev_id = <?php echo $_GET['dev_id']; ?>;
the_data = <?php include 'php_scripts/getReadings.php'; ?>;
the_readings = the_data.map(function(el) { return new Reading(el); });
</script>
