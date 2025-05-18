<?php
session_start();

require_once __DIR__ . '/../includes/database.php';
require_once __DIR__ . '/../functions/jsonResponse.php';

if (!isset($_SESSION['chat_id'])) {
    jsonError('Missing session');
}

$pdo = getDatabaseConnection();
$sessionId = $_SESSION['chat_id'];

try {
    $stmt = $pdo->prepare("
        UPDATE chat_status
        SET typing = 0, typing_expires = NULL
        WHERE session_id = :session_id
    ");
    $stmt->execute([':session_id' => $sessionId]);

    jsonSuccess();
} catch (PDOException $e) {
    error_log('Stop typing error: ' . $e->getMessage());
    jsonError('Database error', 500);
}
