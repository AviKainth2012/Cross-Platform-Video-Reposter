<?php
session_start();

$host = "YOUR_DB_HOST";       // e.g., db12345.hosting.ionos.com
$db   = "YOUR_DB_NAME";       // e.g., db12345
$user = "YOUR_DB_USER";       // e.g., user12345
$pass = "YOUR_DB_PASSWORD";   // e.g., MyP@ssw0rd

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}
?>
