<?php
session_start();
$client_id = getenv('YOUTUBE_CLIENT_ID');
$redirect_uri = 'https://YOURDOMAIN.com/api/youtube_callback.php';
$scope = urlencode('https://www.googleapis.com/auth/youtube.upload');

$auth_url = "https://accounts.google.com/o/oauth2/auth?response_type=code&client_id=$client_id&redirect_uri=$redirect_uri&scope=$scope&access_type=offline&prompt=consent";
header("Location: $auth_url");
exit;
?>