<?php
include $_SERVER['DOCUMENT_ROOT'] . '/SmartSocket/includes/db_connection.php';

if(isset($_GET['login'])) {
	include '/SmartSocket/controllers/login_controller.php';
} elseif (isset($_GET['register'])) {
    include '/SmartSocket/controllers/register_controller.php';
} elseif (isset($_GET['account'])) {
	include '/SmartSocket/controllers/account_controller.php';
} elseif (isset($_GET['newDevice'])) {
	include '/SmartSocket/controllers/newDevice_controller.php';
} else {  
    include '404.html.php';  // No page found
}

?>
