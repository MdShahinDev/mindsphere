<?php
header('Content-Type: application/json');
include("../config/db.php");

session_start();
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['reply' => 'Not authenticated.']);
    exit;
}

$user_id = $_SESSION['user_id'];
$data = json_decode(file_get_contents('php://input'), true);
$user_message = trim($data['message'] ?? '');

if (empty($user_message)) {
    echo json_encode(['reply' => 'Message cannot be empty.']);
    exit;
}

// OpenRouter API with DeepSeek model
// $api_key = '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';
// gpt-3.0-turbo-0613
// $api_key = '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';
// Gemini 2.5 Flash lite preview
$api_key = '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';
$api_url = 'https://openrouter.ai/api/v1/chat/completions';

// Test
$system_prompt = "You are a helpful AI assistant for our company. Always answer questions with a friendly tone. If asked about pricing, reply: 'Our plans start at $9.99/month.' If asked about registration, guide the user step-by-step.";

$payload = [
    // 'model' => 'deepseek/deepseek-r1-0528:free',
    // 'model' => 'openai/gpt-3.5-turbo',
    'model' => 'google/gemini-2.5-flash-lite-preview-06-17',

    'messages' => [
        ['role' => 'system', 'content' => $system_prompt],

        // Test
        ['role' => 'user', 'content' => 'How much does your service cost?'],
        ['role' => 'assistant', 'content' => 'Our plans start at $9.99/month.'],

        ['role' => 'user', 'content' => 'How do I register?'],
        ['role' => 'assistant', 'content' => 'To register, click the "Sign Up" button on the top right and follow the instructions.'],


        ['role' => 'user', 'content' => $user_message]
    ]
];

$ch = curl_init($api_url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'Authorization: Bearer ' . $api_key,
    // 'HTTP-Referer: http://localhost/mindsphere/',
    'Referer: http://localhost/mindsphere/', 

    'X-Title: Mindsphere Chat'
]);

$response = curl_exec($ch);
$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$curl_error = curl_error($ch);
curl_close($ch);

// Handle errors
if ($curl_error) {
    echo json_encode(['reply' => 'CURL error: ' . $curl_error]);
    exit;
}
if ($http_code !== 200) {
    echo json_encode(['reply' => "HTTP $http_code: $response"]);
    exit;
}

// Parse AI response
$result = json_decode($response, true);
$ai_reply = $result['choices'][0]['message']['content'] ?? 'AI could not respond.';

// Save to DB
$stmt = $conn->prepare("INSERT INTO ai_chat_history (user_id, message, response) VALUES (?, ?, ?)");
if ($stmt) {
    $stmt->bind_param("iss", $user_id, $user_message, $ai_reply);
    $stmt->execute();
    $stmt->close();
}

echo json_encode(['reply' => $ai_reply]);
