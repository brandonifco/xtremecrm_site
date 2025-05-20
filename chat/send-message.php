<?php
session_start();
header('Content-Type: application/json');

require_once __DIR__ . '/../includes/database.php';
require_once __DIR__ . '/../functions/MessageStore.php';
require_once __DIR__ . '/../functions/jsonResponse.php';

$pdo = getDatabaseConnection();

// 🔒 Validate input
$name    = trim($_POST['name'] ?? '');
$message = trim($_POST['message'] ?? '');

if ($name === '') {
    jsonError('Name is required.', 403);
}

if ($message === '') {
    jsonError('Empty message.');
}

// ✅ Generate session ID if not already set
if (!isset($_SESSION['chat_id'])) {
    $_SESSION['chat_id'] = bin2hex(random_bytes(16));
}
$sessionId = $_SESSION['chat_id'];
$sender = 'user';

// ✅ Save message to DB
$success = saveMessage($pdo, $sessionId, $sender, $message);

if (!$success) {
    jsonError('Failed to save message', 500);
}

// ✅ Update or insert session info (name + timestamp)
try {
    $stmt = $pdo->prepare("
        INSERT INTO sessions (session_id, name, last_time)
        VALUES (:session_id, :name, NOW())
        ON DUPLICATE KEY UPDATE
            name = VALUES(name),
            last_time = NOW()
    ");
    $stmt->execute([
        ':session_id' => $sessionId,
        ':name'       => $name
    ]);
} catch (PDOException $e) {
    error_log('Failed to update session info: ' . $e->getMessage());
    // Allow chat to continue even if session tracking fails
}

jsonSuccess(); // returns {"success": true}
