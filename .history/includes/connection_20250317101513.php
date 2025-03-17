<?php

// local connection
$servername = "localhost"; // Change if necessary
$username = "root"; // Your database username
$password = ""; // Your database password
$dbname = "saravportfolio"; // Change this


// server connection
$servername = "localhost"; // Change if necessary
$username = "u159162192_saravportfolio"; // Your database username
$password = "Dzyte@4263"; // Your database password
$dbname = "u159162192_saravportfolio"; // Change this

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
