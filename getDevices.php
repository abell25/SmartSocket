<?php
include 'template.php';
$P = array('title' => 'Devices', 
	   'css' => 'getDevices.css',
	   'js'  => 'getDevices.js');
PrintHeader($P);
?>


<div id=daterange>
    Start <input type="date" name="start_date" id="start_date" />
    End <input type="date" name="end_date" id="end_date" />
    <input type="submit" value="Update" onclick="GetAllPoints();"/>
</div>
<div id="usage" style="height:300px;width:400px;"></div>


<!-- ko if: devices().length > 0-->
<ul data-bind="foreach: devices">
<div class="content-section" >
  <h2><a data-bind="attr: { 'href': 'DeviceDetails.php?dev_id=' + dev_id() }">Device <span data-bind="text: dev_id"></span></a> - <input type="text" data-bind="value: nickname" /></h2>
  <div class="onoffswitch">
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
<!-- /ko -->
<?php PrintFooter($P); ?>
<script>
var start_date = (5).days().ago().toString('yyyy-MM-dd hh:mm:ss')
var end_date = Date.parse('today').toString('yyyy-MM-dd hh:mm:ss');
var params = "start_date=" + start_date + "&end_date=" + end_date;

user_id = <?php echo $_GET['user_id'] ?>;
the_data = <?php include 'php_scripts/getDevices.php'; ?>;
the_devices = the_data.map(function(el) { return new Device(el); });

graph_data = {};
the_points = [];
</script>
