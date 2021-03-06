<?php
	include 'template.php';
	$P = array('title' => 'Scheduler', 
		   'css' => 'schedule.css',
		   'js'  => 'dhtmlxscheduler.js');
	PrintHeader($P);
?>
	<div id="main">
		<div id="content-title">
			<div id="left-separator" class="separator"></div>
			<h1>Schedule</h1>
			<div id="right-separator" class="separator"></div>
		</div>
		<div class="content-section">
			<div id="scheduler_here" class="dhx_cal_container" style='width:100%; height:500px; padding:10px;'>
				<div class="dhx_cal_navline">
				<div class="dhx_cal_prev_button">&nbsp;</div>
				<div class="dhx_cal_next_button">&nbsp;</div>
				<div class="dhx_cal_today_button"></div>
				<div class="dhx_cal_date"></div>
				<!--
				<div class="dhx_cal_tab" name="day_tab" style="right:204px;"></div>
				<div class="dhx_cal_tab" name="week_tab" style="right:140px;"></div>
				-->
				<div class="dhx_cal_tab" name="month_tab" style="right:76px;"></div>
				</div>
				<div class="dhx_cal_header"></div>
				<div class="dhx_cal_data"></div>       
			</div>
		</div>			
	</div>

<?php PrintFooter($P); ?>

<script>
	<?php session_start(); ?>;
	<?php $_GET['user_id'] = $_SESSION['user_id']; ?>;
	var devices_json = <?php include 'php_scripts/getDevices.php'; ?>;
	var devices = [];
	
	for (var i=0; i < devices_json.length; i++) {
		devices[i] = {key:devices_json[i].dev_id, label:devices_json[i].nickname};
	}
	
	scheduler.config.xml_date="%Y-%m-%d %H:%i";
	scheduler.config.lightbox.sections=[
		{name:"device", height:40, map_to:"device_id", type:"select" , options:devices, focus:true},
		{name:"time", height:72, type:"time", map_to:"auto"}
	];
	scheduler.locale.labels.section_device="Device Name";
	
	scheduler.attachEvent("onEventAdded", function(id,e){
		e.text = getDeviceName(e.device_id);
    });
	
	scheduler.attachEvent("onEventChanged", function(id,e){
		e.text = getDeviceName(e.device_id);
	});
	
	scheduler.init('scheduler_here', new Date(),"month");
	scheduler.load("scheduler/connector.php");
	
	var dp = new dataProcessor("scheduler/connector.php");
	dp.init(scheduler);
	
	function getDeviceName(dev_id){
		for (var i = 0; i < devices.length; i++){
				if (devices[i].key == dev_id)
						return devices[i].label;
		}
	}
</script>
