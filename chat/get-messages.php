<?php
session_start();
header('Content-Type: application/json');

require_once __DIR__ . '/../functions/loadEnv.php';
require_once __DIR__ . '/../functions/fetchMessages.php';

loadEnv();

if (!isset($_SESSION['chat_id'])) {
    echo json_encode([]);
    exit;
}

$sessionId = $_SESSION['chat_id'];
$messages = fetchMessages($sessionId);

// Add formatted time
foreach ($messages as &$msg) {
    $msg['time'] = date('g:i A', strtotime($msg['timestamp']));
}
$typing = false;
if (!empty($_SESSION['typing_expires']) && $_SESSION['typing_expires'] > time()) {
    $typing = true;
} else {
    $_SESSION['typing'] = false;
    unset($_SESSION['typing_expires']);
}

echo json_encode([
    'messages' => $messages,
    'typing'   => $typing
]);
