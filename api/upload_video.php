<?php
require '../config.php';
if(!isset($_SESSION['user_id'])) die("Not logged in");

$caption = $_POST['caption'] ?? '';
$platforms = json_decode($_POST['platforms'], true) ?? [];

$targetDir = "../uploads/";
$newName = time() . "_" . basename($_FILES["video"]["name"]);

if(move_uploaded_file($_FILES["video"]["tmp_name"], $targetDir.$newName)){
    $stmt = $conn->prepare("INSERT INTO posts (user_id, caption, video_path) VALUES (?,?,?)");
    $stmt->bind_param("iss", $_SESSION['user_id'], $caption, $newName);
    $stmt->execute();
    $post_id = $stmt->insert_id;
    foreach($platforms as $p){
        $stmt2 = $conn->prepare("INSERT INTO post_targets (post_id, platform) VALUES (?,?)");
        $stmt2->bind_param("is",$post_id,$p);
        $stmt2->execute();
    }
    echo "uploaded";
}else echo "error";
?>
