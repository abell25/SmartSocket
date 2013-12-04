<?php
if (isset($_GET['page']) && ($_GET['page'] == 'accountManagement')) {
    include $_SERVER['DOCUMENT_ROOT'].'/SmartSocket/helpDOC/am_help.html.php';
} if (isset($_GET['page']) && ($_GET['page'] == 'scheduling')) {
    include $_SERVER['DOCUMENT_ROOT'].'/SmartSocket/helpDOC/sched_help.html.php';
} if (isset($_GET['page']) && ($_GET['page'] == 'starting')) {
    include $_SERVER['DOCUMENT_ROOT'].'/SmartSocket/helpDOC/gettingstarted_help.html.php';
} if (isset($_GET['page']) && ($_GET['page'] == 'hardware')) {
    include $_SERVER['DOCUMENT_ROOT'].'/SmartSocket/helpDOC/hardware_help.html.php';
} else {
	include $_SERVER['DOCUMENT_ROOT'].'/SmartSocket/helpDOC/default.html.php';
}
?>