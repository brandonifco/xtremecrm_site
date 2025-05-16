<?php
session_start();
header('Content-Type: application/json');

require_once __DIR__ . '/../functions/loadEnv.php';
require_once __DIR__ . '/../functions/saveMessage.php';

loadEnv();

// Create a unique session ID for each user if it doesn't exist
if (!isset($_SESSION['chat_id'])) {
    $_SESSION['chat_id'] = bin2hex(random_bytes(16));
}

$sessionId = $_SESSION['chat_id'];
$sender    = 'user'; // This endpoint is for user-side messages only
$message   = trim($_POST['message'] ?? '');

if (empty($message)) {
    echo json_encode(['success' => false, 'error' => 'Empty message.']);
    exit;
}

$success = saveMessage($sessionId, $sender, $message);

echo json_encode(['success' => $success]);
