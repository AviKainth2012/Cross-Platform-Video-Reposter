<?php
require __DIR__ . '/../config.php';
session_start();

$app_id = getenv('FACEBOOK_APP_ID');
$app_secret = getenv('FACEBOOK_APP_SECRET');
$redirect_uri = 'https://YOURDOMAIN.com/api/facebook_callback.php';

if(!isset($_GET['code'])) die("No code");

$code = $_GET['code'];

// Exchange code for long-lived token
$token_url = "https://graph.facebook.com/v17.0/oauth/access_token?client_id=$app_id&redirect_uri=$redirect_uri&client_secret=$app_secret&code=$code";

$response = file_get_contents($token_url);
$data = json_decode($response, true);

if(!isset($data['access_token'])) die("Error obtaining token");

$stmt = $conn->prepare("INSERT INTO connected_accounts (user_id, platform, access_token) VALUES (?, 'facebook', ?)");
$stmt->bind_param("is", $_SESSION['user_id'], $data['access_token']);
$stmt->execute();

echo "Facebook connected successfully!";
?>