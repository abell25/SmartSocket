<?php
include 'template.php';
$P = array('title' => 'Devices', 
	   'css' => 'getDevices.css',
	   'js'  => 'getDevices.js');
PrintHeader($P);
?>

<ul data-bind="foreach: devices">
<div class="content-section">
  <h2><a data-bind="attr: { 'href': 'DeviceDetails.php?dev_id=' + dev_id() }">Device <span data-bind="text: dev_id"></span></a> - <input type="text" data-bind="value: nickname" /></h2>
  <div class="onoffswitch" >
    <input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox" data-bind="attr: { 'id': 'dev_' + dev_id() }, checked: IsChecked">
    <label class="onoffswitch-label" data-bind="attr: { 'for': 'dev_' + dev_id() }">
      <div class="onoffswitch-inner"></div>
      <div class="onoffswitch-switch"></div>
    </label>
  </div>
  <div class="link-separator"></div>
  <h1>Max Cost: </h1>
  <input type="number" data-bind="value: max_cost" /></span>
  <span class="override">
    <label for="override">Use schedule</label><input type="checkbox" data-bind="checked: use_schedule"/>
  </span>
</div>
</ul>
<?php PrintFooter($P); ?>
<script>
user_id = <?php echo $_GET['user_id'] ?>;
the_data = <?php include 'php_scripts/getDevices.php'; ?>;
the_devices = the_data.map(function(el) { return new Device(el); });
</script>
