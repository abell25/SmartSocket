<?php 
	include_once $_SERVER['DOCUMENT_ROOT'].'/SmartSocket/includes/helpers.inc.php';
	include 'template.php';
	$P = array('title' => "'". $title ."'", 
		   'css' => 'output.css');
	PrintHeader($P);
?>
		<p>
			<?php echo $error; ?>
		</p>
		<p>
			<?php echo $output; ?>
		</p>
		</div>
	</body>
</html>
