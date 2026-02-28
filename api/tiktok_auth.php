<?php
session_start();
$client_key = getenv('TIKTOK_CLIENT_KEY');
$redirect_uri = 'https://YOURDOMAIN.com/api/tiktok_callback.php';
$scope = 'video.upload';
$auth_url = "https://www.tiktok.com/oauth/authorize?client_key=$client_key&response_type=code&scope=$scope&redirect_uri=$redirect_uri";
header("Location: $auth_url");
exit;
?>