<?php
require __DIR__ . '/../config.php';
$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

$stmt = $conn->prepare("SELECT * FROM users WHERE email=?");
$stmt->bind_param("s",$email);
$stmt->execute();
$res = $stmt->get_result();
$user = $res->fetch_assoc();

if($user && password_verify($password, $user['password'])){
    $_SESSION['user_id']=$user['id'];
    echo "success";
}else{
    echo "invalid";
}
?>
