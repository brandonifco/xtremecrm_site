<?php
require_once __DIR__ . '/../includes/database.php';
require_once __DIR__ . '/../functions/MessageStore.php';
require_once __DIR__ . '/../functions/jsonResponse.php';

$pdo = getDatabaseConnection();

// ✅ Make sure this line comes BEFORE using $sessionId
$sessionId = $_POST['session_id'] ?? '';
$message   = trim($_POST['message'] ?? '');

if (!$sessionId || $message === '') {
    jsonError('Missing session ID or message');
}

$success = saveMessage($pdo, $sessionId, 'admin', $message);

if (!$success) {
    jsonError('Failed to save message', 500);
}

jsonSuccess();
