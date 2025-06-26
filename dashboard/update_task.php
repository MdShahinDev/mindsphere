<?php
include("../config/db.php");
session_start();

$data = json_decode(file_get_contents("php://input"), true);
$id = $data['id'];
$progress = $data['progress'];
$status = $data['status'];

$stmt = $conn->prepare("UPDATE tasks SET progress = ?, status = ? WHERE id = ? AND user_id = ?");
$stmt->bind_param("isii", $progress, $status, $id, $_SESSION['user_id']);
$stmt->execute();
echo "Updated";
?>
