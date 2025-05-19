<?php
require_once __DIR__ . '/../includes/database.php';
require_once __DIR__ . '/../functions/jsonResponse.php';

try {
    $pdo = getDatabaseConnection();

    $stmt = $pdo->prepare("
        SELECT session_id, name, last_time
        FROM sessions
        WHERE last_time >= NOW() - INTERVAL 1 HOUR
        ORDER BY last_time DESC
    ");
    $stmt->execute();

    $sessions = $stmt->fetchAll(PDO::FETCH_ASSOC);

    jsonSuccess(['sessions' => $sessions]);
} catch (PDOException $e) {
    error_log('Get sessions DB error: ' . $e->getMessage());
    jsonError('Database error', 500);
}
