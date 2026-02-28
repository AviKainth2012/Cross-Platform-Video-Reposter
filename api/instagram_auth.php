<?php
session_start();
$client_id = getenv('INSTAGRAM_CLIENT_ID');
$redirect_uri = 'https://YOURDOMAIN.com/api/instagram_callback.php';
$scope = 'user_media_publish,instagram_basic';
$auth_url = "https://api.instagram.com/oauth/authorize?client_id=$client_id&redirect_uri=$redirect_uri&scope=$scope&response_type=code";
header("Location: $auth_url");
exit;
?>