<?php
$host = "127.0.0.1:3308"; // Use "127.0.0.1" instead of "localhost" if needed
$username = "myadmin"; // Default username in XAMPP is "root"
$password = "myadminday2025"; // Leave empty if you haven't set a password
$database = "kbcon"; // Your database name

$conn = mysqli_connect($host, $username, $password, $database);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>