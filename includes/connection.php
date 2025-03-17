<?php


// Check if running on localhost or live server
if ($_SERVER['HTTP_HOST'] === 'localhost') {
    // Localhost configuration
    $servername = "localhost"; // Change if necessary
    $username = "root"; // Your database username
    $password = ""; // Your database password
    $dbname = "portfolio"; // Change this
} else {
    // Server configuration
$servername = "localhost"; 
$username = "u159162192_saravportfolio";
$password = "Dzyte@4263"; 
$dbname = "u159162192_saravportfolio"; 
}

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
