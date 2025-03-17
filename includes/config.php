<?php


// Check if running on localhost or live server
if ($_SERVER['HTTP_HOST'] === 'localhost') {
    // Localhost configuration
    define('DB_HOST', 'localhost');
    define('DB_USER', 'root');
    define('DB_PASS', '');
    define('DB_NAME', 'portfolio');
} else {
    // Server configuration
    define('DB_HOST', 'localhost');
    define('DB_USER', 'u159162192_saravportfolio');
    define('DB_PASS', 'Dzyte@4263');
    define('DB_NAME', 'u159162192_saravportfolio');
}
// Create database connection
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Start session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>