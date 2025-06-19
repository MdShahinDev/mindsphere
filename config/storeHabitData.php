<?php
header("Content-Type: application/json");
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'db.php';

$data = json_decode(file_get_contents("php://input"), true);

$user_id = $data['user_id'] ?? 1;
$date = $data['date'] ?? date("Y-m-d");
$habits = $data['habits'] ?? [];

foreach ($habits as $habit) {
    $habit_category = $habit['category'];
    $habit_name = $habit['name'];
    $habit_value_text = $habit['value_text'];
    $habit_value_score = $habit['value_score'];

    $stmt = $conn->prepare("INSERT INTO habit_log (user_id, date, habit_category, habit_name, habit_value_text, habit_value_score) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("issssi", $user_id, $date, $habit_category, $habit_name, $habit_value_text, $habit_value_score);
    $stmt->execute();
}

echo json_encode(["status" => "success", "message" => "Habits stored."]);
?>
