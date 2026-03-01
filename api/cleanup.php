<?php
require __DIR__ . '/../config.php';
$dir = "../uploads/";
$files = scandir($dir);
$now = time();

foreach($files as $file){
    if($file === '.' || $file === '..') continue;
    $filepath = $dir.$file;
    if(file_exists($filepath) && ($now - filemtime($filepath)) > 3600){
        unlink($filepath);
    }
}
?>