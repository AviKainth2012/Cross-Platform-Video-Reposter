<?php
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(E_ALL);

require __DIR__ . '/../config.php';
session_start();

$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

if(empty($email) || empty($password)){
    echo "Email and password are required";
    exit;
}

// Find user by email
$stmt = $conn->prepare("SELECT id, password FROM users WHERE email=?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if($row = $result->fetch_assoc()){
    if(password_verify($password, $row['password'])){
        $_SESSION['user_id'] = $row['id'];
        echo "success";
    } else {
        echo "Invalid email/password";
    }
} else {
    echo "Invalid email/password";
}
?>