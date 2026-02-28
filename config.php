<?php
if(function_exists('apache_getenv')){
    putenv("DB_HOST=".apache_getenv('DB_HOST'));
    putenv("DB_NAME=".apache_getenv('DB_NAME'));
    putenv("DB_USER=".apache_getenv('DB_USER'));
    putenv("DB_PASS=".apache_getenv('DB_PASS'));
}

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) die("DB connection failed: " . $conn->connect_error);
?>
