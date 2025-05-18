<?php
session_start();

require_once __DIR__ . '/../functions/jsonResponse.php';
require_once __DIR__ . '/../includes/database.php';

if (!isset($_SESSION['chat_id'])) {
    jsonError('Missing session');
}

$pdo = getDatabaseConnection();
$sessionId = $_SESSION['chat_id'];
$typingExpires = (new DateTime('+6 seconds'))->format('Y-m-d H:i:s');

try {
    $stmt = $pdo->prepare("
        INSERT INTO chat_status (session_id, typing, typing_expires)
        VALUES (:session_id, 1, :typing_expires)
        ON DUPLICATE KEY UPDATE typing = 1, typing_expires = :typing_expires
    ");
    $stmt->execute([
        ':session_id'     => $sessionId,
        ':typing_expires' => $typingExpires
    ]);

    jsonSuccess(); // returns {"success": true}
} catch (PDOException $e) {
    error_log('Typing status error: ' . $e->getMessage());
    jsonError('Database error', 500);
}
