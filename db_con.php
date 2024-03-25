<?php
$host = 'localhost'; // MySQL host (usually localhost)
$username = 'root'; // MySQL username (default is root)
$password = ''; // MySQL password (leave empty if none)
$database = 'metro_events'; // Name of your database

// Create connection
$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
    // echo "connection successful";
}
?>
