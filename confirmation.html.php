<?php
	include 'template.php';
	$P = array('title' => 'Are you sure?', 
				'css' => 'account.css');
	PrintHeader($P);
?>
<div id="main">
	<div id="content-section-confirm" class="content-section shadow">
		<div id="confirmation_div">
			<h2>Are your sure you want to delete device: <?php echo $nickname ?>?</h2>
			<div id="submit_holder" class="cushion_up">
				<button id="confirm" type="button" onClick="window.location.href='index.php?deviceInfo&dev_id=<?php echo $dev_id ?>'">Cancel</button>
				<button id="delete_confirm" type="button" onClick="window.location.href='index.php?deviceInfo&dev_id=<?php echo $dev_id ?>&confirmation=false&delete=true'">Yes</button>
			</div>
		</div>
	</div>
</div>
<?php PrintFooter($P); ?>
	