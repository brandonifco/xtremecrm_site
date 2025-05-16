<?php
require_once __DIR__ . '/loadEnv.php';
loadEnv();

function fetchMessages(string $sessionId): array
{
    $host = getenv('DB_HOST');
    $db   = getenv('DB_NAME');
    $user = getenv('DB_USER');
    $pass = getenv('DB_PASS');

    try {
        $pdo = new PDO("mysql:host=127.0.0.1;dbname=$db;charset=utf8mb4", $user, $pass, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        ]);

        $stmt = $pdo->prepare("
            SELECT sender, message, timestamp
            FROM messages
            WHERE session_id = :session_id
            ORDER BY timestamp ASC
        ");
        $stmt->execute([':session_id' => $sessionId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log('Chat DB error: ' . $e->getMessage());
        return [];
    }
}

