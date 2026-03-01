<?php
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(E_ALL);

require 'config.php';

$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

if(empty($email) || empty($password)){
    echo "Email and password are required";
    exit;
}

$stmt = $conn->prepare("SELECT id FROM users WHERE email=?");
$stmt->bind_param("s",$email);
$stmt->execute();
$stmt->store_result();
if($stmt->num_rows > 0){
    echo "Email already registered";
    exit;
}

$hashed = password_hash($password, PASSWORD_DEFAULT);

$stmt = $conn->prepare("INSERT INTO users (email,password) VALUES (?,?)");
$stmt->bind_param("ss",$email,$hashed);
if($stmt->execute()){
    echo "success";
}else{
    echo "Error: " . $stmt->error;
}
?>