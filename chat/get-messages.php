<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

require_once __DIR__ . '/../includes/database.php';
require_once __DIR__ . '/../functions/MessageStore.php';
require_once __DIR__ . '/../functions/jsonResponse.php';

$pdo = getDatabaseConnection();

// Ensure session exists
if (!isset($_SESSION['chat_id'])) {
    jsonError('Missing chat session');
}

$sessionId = $_SESSION['chat_id'];
$messages  = fetchMessages($pdo, $sessionId);

// Add formatted time
foreach ($messages as &$msg) {
    if (isset($msg['timestamp'])) {
        $msg['time'] = date('g:i A', strtotime($msg['timestamp']));
    }
}

// Check local session typing flag
$typing = false;
if (!empty($_SESSION['typing_expires']) && $_SESSION['typing_expires'] > time()) {
    $typing = true;
} else {
    $_SESSION['typing'] = false;
    unset($_SESSION['typing_expires']);
}

jsonSuccess([
    'messages' => $messages,
    'typing'   => $typing
]);
