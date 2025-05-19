<?php
session_start();
header('Content-Type: application/json');

// Reject if no name is set
if (empty($_SESSION['chat_name'])) {
    http_response_code(403);
    echo json_encode(['error' => 'Name not set.']);
    exit;
}
require_once __DIR__ . '/../includes/database.php';
require_once __DIR__ . '/../functions/MessageStore.php';
require_once __DIR__ . '/../functions/jsonResponse.php';

$pdo = getDatabaseConnection();

if (!isset($_SESSION['chat_id'])) {
    $_SESSION['chat_id'] = bin2hex(random_bytes(16));
}

$sessionId = $_SESSION['chat_id'];
$sender    = 'user';
$message   = trim($_POST['message'] ?? '');

if ($message === '') {
    jsonError('Empty message.');
}

$success = saveMessage($pdo, $sessionId, $sender, $message);

if (!$success) {
    jsonError('Failed to save message', 500);
}

// ✅ Update or insert session tracking
try {
    $stmt = $pdo->prepare("
        INSERT INTO sessions (session_id, name, last_time)
        VALUES (:session_id, :name, NOW())
        ON DUPLICATE KEY UPDATE last_time = NOW()
    ");
    $stmt->execute([
        ':session_id' => $sessionId,
        ':name'       => $_SESSION['chat_name']
    ]);
} catch (PDOException $e) {
    error_log('Failed to update sessions table: ' . $e->getMessage());
    // We still return success to avoid blocking chat if this fails
}

jsonSuccess(); // returns {"success": true}
