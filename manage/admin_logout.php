<?php
// admin_logout.php
require_once '../includes/config.php';

// Clear the session
$_SESSION = array();
session_destroy();

// Redirect to login page
header('Location: admin_login.php');
exit;
?>