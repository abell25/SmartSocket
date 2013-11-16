<?php
include $_SERVER['DOCUMENT_ROOT'] . '/SmartSocket/includes/db_connection.php';

if(isset($_GET['login'])) {
	include $_SERVER['DOCUMENT_ROOT'].'/SmartSocket/controllers/login_controller.php';
} elseif (isset($_GET['register'])) {
    include $_SERVER['DOCUMENT_ROOT'].'/SmartSocket/controllers/register_controller.php';
} elseif (isset($_GET['account'])) {
	include $_SERVER['DOCUMENT_ROOT'].'/SmartSocket/controllers/account_controller.php';
} elseif (isset($_GET['newDevice'])) {
	include $_SERVER['DOCUMENT_ROOT'].'/SmartSocket/controllers/newDevice_controller.php';
} elseif (isset($_GET['deviceInfo'])) {
	include $_SERVER['DOCUMENT_ROOT'].'/SmartSocket/controllers/deviceInfo_controller.php';
} else {  
    include '404.html.php';  // No page found
}

?>
