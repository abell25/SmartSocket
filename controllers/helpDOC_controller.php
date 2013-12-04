<?php
if (isset($_GET['page']) && ($_GET['page'] == 'accountManagement')) {
    include $_SERVER['DOCUMENT_ROOT'].'/SmartSocket/helpDOC/am_help.html.php';
} else {
	include $_SERVER['DOCUMENT_ROOT'].'/SmartSocket/helpDOC/default.html.php';
}
?>