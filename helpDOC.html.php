<?php
	include 'template.php';
	$P = array('title' => 'Help Documentation', 
				'css' => 'help.css');
	PrintHeader($P);
?>
<div id="main">
	<div class="content-section shadow">
		<?php echo $content ?>
	</div>
</div>
<div id="sidebar" class="shadow">
	<h2>Pages</h2>
	<div class="devices">
		<button type="button" onClick="window.location.href='index.php?helpDOC&page=starting'">Getting Started</button>
		<button type="button" onClick="window.location.href='index.php?helpDOC&page=accountManagement'">Account Management</button>
		<button type="button" onClick="window.location.href='index.php?helpDOC&page=scheduling'">Scheduling</button>
		<button type="button" onClick="window.location.href='index.php?helpDOC&page=hardware'">Hardware</button>
	</div>
</div>
<div id="footerPad">
</div>
<?php PrintFooter($P); ?>
	