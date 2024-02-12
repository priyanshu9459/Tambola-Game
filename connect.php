<?php
// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "password";
$database = "tambola_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if (!$conn) {
    die("Sorry, we failed to connect: " . mysqli_connect_error());
} 

// Close connection
// $conn->close();
?>
