<?php
require '../config.php';

$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

if(!$email || !$password) die("Missing fields");

$hashed = password_hash($password, PASSWORD_DEFAULT);

$stmt = $conn->prepare("INSERT INTO users (email, password) VALUES (?, ?)");
$stmt->bind_param("ss", $email, $hashed);

echo $stmt->execute() ? "success" : "error";
?>
