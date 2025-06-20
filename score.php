<?php
$user_id = 28;
$command = escapeshellcmd("python python/score_user.py $user_id");
$output = shell_exec($command);
$response = json_decode($output, true);

if (isset($response['score'])) {
    echo "Today's Efficiency Score: " . $response['score'];
} else {
    echo "Error: Could not calculate score.";
}
?>
