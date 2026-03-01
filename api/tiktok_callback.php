<?php
require __DIR__ . '/../config.php';
session_start();

$client_key = getenv('TIKTOK_CLIENT_KEY');
$client_secret = getenv('TIKTOK_CLIENT_SECRET');
$redirect_uri = 'https://YOURDOMAIN.com/api/tiktok_callback.php';

if(!isset($_GET['code'])) die("No code");

$code = $_GET['code'];

// Exchange code for access token
$ch = curl_init('https://open.tiktokapis.com/v1/oauth/token');
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
    'client_key' => $client_key,
    'client_secret' => $client_secret,
    'code' => $code,
    'grant_type' => 'authorization_code',
    'redirect_uri' => $redirect_uri
]));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);

$data = json_decode($response, true);
if(!isset($data['data']['access_token'])) die("Error getting token");

$stmt = $conn->prepare("INSERT INTO connected_accounts (user_id, platform, access_token) VALUES (?, 'tiktok', ?)");
$stmt->bind_param("is", $_SESSION['user_id'], $data['data']['access_token']);
$stmt->execute();

echo "TikTok connected successfully!";
?>