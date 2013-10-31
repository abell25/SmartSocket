<?php
//echo "getting sockets for user..<br />";
include 'template.php';
$P = array('title' => 'Devices', 
	   'css' => 'getDevices.css',
	   'js'  => 'getDevices.js');
PrintHeader($P);
?>
<script>
user_id = <?php echo $_GET['user_id'] ?>;
the_data = <?php include 'php_scripts/getDevices.php'; ?>;
</script>
<ul data-bind="foreach: devices">
<div class="content-section">
  <h2>Device <span data-bind="text: dev_id"></span></h2>
  <div class="onoffswitch" data-bind="attr: { 'id': dev_id }">
    <input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox">
    <label class="onoffswitch-label" data-bind="attr: { 'for': dev_id }">
      <div class="onoffswitch-inner"></div>
      <div class="onoffswitch-switch"></div>
    </label>
  </div>
  <div class="link-separator"></div>
  <h1>Max Cost: </h1>
  <p data-bind="text: max_cost"></p>
</div>
</ul>
<?php
PrintFooter();
?>
