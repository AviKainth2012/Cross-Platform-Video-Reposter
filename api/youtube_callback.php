<?php
require '../config.php';
session_start();

// Make sure user is logged in
if (!isset($_SESSION['user_id'])) {
    die("Not logged in");
}

// Environment variables for credentials
$client_id = getenv('YOUTUBE_CLIENT_ID');
$client_secret = getenv('YOUTUBE_CLIENT_SECRET');
$redirect_uri = 'https://YOURDOMAIN.com/api/youtube_callback.php';

if (!isset($_GET['code'])) {
    die("No code provided");
}

$code = $_GET['code'];

// Exchange authorization code for access token
$post_fields = [
    'code' => $code,
    'client_id' => $client_id,
    'client_secret' => $client_secret,
    'redirect_uri' => $redirect_uri,
    'grant_type' => 'authorization_code'
];

$ch = curl_init('https://oauth2.googleapis.com/token');
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post_fields));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);

$data = json_decode($response, true);

if (!isset($data['access_token'])) {
    die("Error obtaining access token");
}

$user_id = $_SESSION['user_id'];
$access_token = $data['access_token'];
$refresh_token = $data['refresh_token'] ?? '';
$expires_at = date('Y-m-d H:i:s', time() + $data['expires_in']);

// Save tokens in database
$stmt = $conn->prepare("INSERT INTO connected_accounts (user_id, platform, access_token, refresh_token, expires_at) VALUES (?, 'youtube', ?, ?, ?)");
$stmt->bind_param("isss", $user_id, $access_token, $refresh_token, $expires_at);
$stmt->execute();

echo "YouTube connected successfully! You can now upload videos.";
?>