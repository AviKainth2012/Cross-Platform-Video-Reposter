<?php
session_start();

$host = getenv('DB_HOST');
$db   = getenv('DB_NAME');
$user = getenv('DB_USER');
$pass = getenv('DB_PASS');

$conn = new mysqli($host, $user, $pass, $db);
if($conn->connect_error) die("DB connection failed: " . $conn->connect_error);

$yt_id = getenv('YOUTUBE_CLIENT_ID');
$yt_secret = getenv('YOUTUBE_CLIENT_SECRET');