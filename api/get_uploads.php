<?php
require '../config.php';
if(!isset($_SESSION['user_id'])){
    http_response_code(403);
    die("Login required");
}

$user_id = $_SESSION['user_id'];

$stmt = $conn->prepare("
    SELECT pt.*, p.video_path, p.caption 
    FROM post_targets pt 
    JOIN posts p ON pt.post_id = p.id 
    WHERE p.user_id=?
    ORDER BY p.created_at DESC
");
$stmt->bind_param("i",$user_id);
$stmt->execute();
$res = $stmt->get_result();
$data = [];
while($row = $res->fetch_assoc()) $data[] = $row;

header('Content-Type: application/json');
echo json_encode($data);
?>