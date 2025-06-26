<?php
include("../config/db.php");
session_start();

if (!isset($_GET['id'])) exit;

$id = intval($_GET['id']);
$stmt = $conn->prepare("SELECT * FROM tasks WHERE id = ? AND user_id = ?");
$stmt->bind_param("ii", $id, $_SESSION['user_id']);
$stmt->execute();
$res = $stmt->get_result();

if ($row = $res->fetch_assoc()) {
    echo json_encode($row);
}
?>
