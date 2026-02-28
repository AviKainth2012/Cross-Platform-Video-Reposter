<?php
require '../config.php';
if(!isset($_SESSION['user_id'])){
    http_response_code(403);
    die("Please login first");
}

$caption = $_POST['caption'] ?? '';
$platforms = json_decode($_POST['platforms'], true) ?? [];
$media = $_FILES['media'] ?? null;

if(!$media) die("No file uploaded");

// Only allow video or image
$allowed_types = ['video/mp4','video/quicktime','image/jpeg','image/png','image/gif'];
if(!in_array($media['type'], $allowed_types)){
    die("Only videos or images are allowed");
}

// Move file
$targetDir = "../uploads/";
$newName = time() . "_" . basename($media["name"]);
if(!move_uploaded_file($media["tmp_name"], $targetDir.$newName)){
    die("Failed to save file");
}

// Insert into posts table
$stmt = $conn->prepare("INSERT INTO posts (user_id, caption, video_path) VALUES (?,?,?)");
$stmt->bind_param("iss", $_SESSION['user_id'], $caption, $newName);
$stmt->execute();
$post_id = $stmt->insert_id;

// Insert into post_targets table
foreach($platforms as $p){
    $stmt2 = $conn->prepare("INSERT INTO post_targets (post_id, platform) VALUES (?,?)");
    $stmt2->bind_param("is",$post_id,$p);
    $stmt2->execute();
}

echo "uploaded";
?>