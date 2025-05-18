<?php
// /chat/set-name.php
session_start();

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');

    if (strlen($name) < 1) {
        http_response_code(400);
        echo json_encode(['error' => 'Name is required']);
        exit;
    }

    $_SESSION['chat_name'] = $name;
    echo json_encode(['success' => true]);
    exit;
}

http_response_code(405);
echo json_encode(['error' => 'Invalid request method']);
