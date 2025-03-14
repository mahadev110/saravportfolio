<?php
// logout.php
require_once 'includes/config.php';

// Clear the passcode verification
unset($_SESSION['passcode_verified']);

// Redirect to the login page
header('Location: index.php');
exit;
?>