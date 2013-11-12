<?php
function PrintHeader($P) { 
 if(!isset($_SESSION)){
    session_start();
 }
 if(empty($_SESSION['user_id']) && empty($_SESSION['username'])) {
	header('Location: /Practice/SmartSocket/?login');
 }
?>
<!DOCTYPE html>
<html>
  <head>
    <link href='http://fonts.googleapis.com/css?family=Raleway:400,800' rel='stylesheet' type='text/css'>
    <link href="http://www.yoursmartsocket.com/SmartSocket/styles/style.css" rel="stylesheet" type="text/css" />
    <link href="http://www.yoursmartsocket.com/SmartSocket/styles/devices.css" rel="stylesheet"type="text/css" />
    <link href="http://www.yoursmartsocket.com/SmartSocket/styles/jquery.jqplot.min.css" rel="stylesheet"type="text/css" />
    <link rel="shortcut icon" href="http://www.yoursmartsocket.com/SmartSocket/images/favicon.ico" /> 
		<?php
		if (array_key_exists('css', $P)) {
		  echo '<link href="http://www.yoursmartsocket.com/SmartSocket/styles/'. $P['css'] .'" rel="stylesheet" type="text/css" />';
		}
		if (array_key_exists('js', $P)) {
		  echo '<script type="text/javascript" src="http://www.yoursmartsocket.com/SmartSocket/scripts/' . $P['js'] .'"></script>';
		}
		?>
    <title><?php attr($P, 'title');  ?></title>
  </head>

  <body>
    <div id="wrapper">
      <div id="header">
	  	  	<div id="welcome">
			<p>Welcome, 
				<?php 
				  session_start(); 
				  echo $_SESSION['username']; 
				?>
			</p>
			<a href="logout.php" title="Logout">[Logout]</a>
		</div>
	<div id="navbar">
	  <div id="logo"></div>
	  <a href="index.html" title="Home" id="home"></a>
	  <div id="navigation">
	    <ul>
	      <li><a href="devices.html" title="Devices">Devices</a></li>
	      <li><a href="schedule.html" title="Schedule">Schedule</a></li>
	      <li><a href="index.php?account<?php echo "&id=".$_SESSION['user_id'];  ?>" title="Account">Account</a></li>
	    </ul>
	  </div>
	</div>
      </div>
      <div id="content">
<?php } ?> 
<?php function PrintFooter($P) { ?>
      </div><!-- content -->
      <div id="footer">
	<div class="section-separator"></div>
	<div class="link-section">
	  <h1>Title</h1>
	  <div class="link-separator"></div>
	  <ul>
	    <li><a href="link1" title="Link 1">Link 1</a></li>
	    <li><a href="link2" title="Link 2">Link 2</a></li>
	    <li><a href="link2" title="Link 3">Link 3</a></li>
	    <li><a href="link2" title="Link 4">Link 4</a></li>
	  </ul>
	</div>
	<div class="link-section">
	  <h1>Title</h1>
	  <div class="link-separator"></div>
	  <ul>
	    <li><a href="link1" title="Link 1">Link 1</a></li>
	    <li><a href="link2" title="Link 2">Link 2</a></li>
	    <li><a href="link2" title="Link 3">Link 3</a></li>
	    <li><a href="link2" title="Link 4">Link 4</a></li>
	  </ul>
	</div>
	<div class="link-section">
	  <h1>Title</h1>
	  <div class="link-separator"></div>
	  <ul>
	    <li><a href="link1" title="Link 1">Link 1</a></li>
	    <li><a href="link2" title="Link 2">Link 2</a></li>
	    <li><a href="link2" title="Link 3">Link 3</a></li>
	    <li><a href="link2" title="Link 4">Link 4</a></li>
	  </ul>
	</div>
      </div>
    </div>
  </body>
</html>

    <script type="text/javascript" src="http://www.yoursmartsocket.com/SmartSocket/js/jquery-1.10.2.min.js"></script>
    <script type="text/javascript" src="http://www.yoursmartsocket.com/SmartSocket/js/knockout-3.0.0.js"></script>
    <script type="text/javascript" src="http://www.yoursmartsocket.com/SmartSocket/js/jquery.jqplot.min.js"></script>
    <script type="text/javascript" src="http://www.yoursmartsocket.com/SmartSocket/js/jqplot.dateAxisRenderer.min.js"></script>
    <script type="text/javascript" src="http://www.yoursmartsocket.com/SmartSocket/js/date.js"></script>
    <?php
    if (array_key_exists('js', $P)) {
      echo '<script type="text/javascript" src="http://www.yoursmartsocket.com/SmartSocket/js/' . $P['js'] .'"></script>';
    }
    ?>
<?php } ?>


<?php 
function attr($P, $property) {
  if (array_key_exists($property, $P)) { 
    echo $P[$property]; 
  } else {
    echo "property $property doesn't exist!";
  }
}
?>

<?php
function PrintSimpleHeader($P) { ?>
<!DOCTYPE html>
<html>
	<head>
		<link href='http://fonts.googleapis.com/css?family=Raleway:400,800' rel='stylesheet' type='text/css'>
		<link href="http://www.yoursmartsocket.com/SmartSocket/styles/style.css" rel="stylesheet" type="text/css" />
		<link href="http://www.yoursmartsocket.com/SmartSocket/styles/devices.css" rel="stylesheet"type="text/css" />
		<?php
			if (array_key_exists('css', $P)) {
			  echo '<link href="http://www.yoursmartsocket.com/SmartSocket/styles/'. $P['css'] .'" rel="stylesheet" type="text/css" />';
			}
		?>
		<link rel="shortcut icon" href="/images/favicon.ico" />
		<script type="text/javascript" src="http://www.yoursmartsocket.com/SmartSocket/js/jquery-1.10.2.min.js"></script>
		<script type="text/javascript" src="http://www.yoursmartsocket.com/SmartSocket/js/knockout-3.0.0.js"></script>
		<?php
			if (array_key_exists('js', $P)) {
			  echo '<script type="http://www.yoursmartsocket.com/SmartSocket/scripts/' . $P['js'] .'"></script>';
			}
		?>
		<title><?php attr($P, 'title');  ?></title>
	</head>

  <body>
	<div id="wrapper">
		<div id="header">
			<img src="images/logo-nonav.png" alt="Alternate logo" style="width:1080px; height:180px; display:inline-block;">
		</div>
	
<?php } ?>