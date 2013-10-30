<?php include_once $_SERVER['DOCUMENT_ROOT'] .
		'/SmartSocket/includes/helpers.inc.php'; ?>
<!DOCTYPE html>
<html>
	<head>
		<title><?php htmlout($pagetitle); ?></title>
		<!--link type="text/css" rel="stylesheet" href="stylesheet.css"/-->
	</head>
	<body>	
		<div id="content">
			<?php echo $output; ?>
		</div>
	</body>
</html>
