<?php
session_start();
$app_id = getenv('FACEBOOK_APP_ID');
$redirect_uri = 'https://YOURDOMAIN.com/api/facebook_callback.php';
$scope = 'pages_manage_posts,pages_read_engagement,pages_show_list';
$auth_url = "https://www.facebook.com/v17.0/dialog/oauth?client_id=$app_id&redirect_uri=$redirect_uri&scope=$scope&response_type=code";
header("Location: $auth_url");
exit;
?>