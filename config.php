<?php
session_start();

$host = "";           // usually 'localhost' on IONOS
$db   = "";  // EXACT name of your DB
$user = "";  // EXACT MySQL user
$pass = ""; // MySQL password

$conn = new mysqli($host, $user, $pass, $db);
if($conn->connect_error){
    die("DB connection failed: " . $conn->connect_error);
} else {
    echo "DB connected successfully"; // temporary
}
?>