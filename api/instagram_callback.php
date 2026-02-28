<?php
require '../config.php';
session_start();

$client_id = getenv('INSTAGRAM_CLIENT_ID');
$client_secret = getenv('INSTAGRAM_CLIENT_SECRET');
$redirect_uri = 'https://YOURDOMAIN.com/api/instagram_callback.php';

if(!isset($_GET['code'])) die("No code");

$code = $_GET['code'];

// Exchange code for access token
$ch = curl_init('https://api.instagram.com/oauth/access_token');
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, [
    'client_id' => $client_id,
    'client_secret' => $client_secret,
    'grant_type' => 'authorization_code',
    'redirect_uri' => $redirect_uri,
    'code' => $code
]);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);

$data = json_decode($response, true);
if(!isset($data['access_token'])) die("Error obtaining token");

$stmt = $conn->prepare("INSERT INTO connected_accounts (user_id, platform, access_token) VALUES (?, 'instagram', ?)");
$stmt->bind_param("is", $_SESSION['user_id'], $data['access_token']);
$stmt->execute();

echo "Instagram connected successfully!";
?>