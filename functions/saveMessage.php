<?php
require_once __DIR__ . '/loadEnv.php';
loadEnv();

function saveMessage(string $sessionId, string $sender, string $message): bool
{
    $host = getenv('DB_HOST');
    $db   = getenv('DB_NAME');
    $user = getenv('DB_USER');
    $pass = getenv('DB_PASS');

    try {
        $pdo = new PDO("mysql:host=127.0.0.1;dbname=$db;charset=utf8mb4", $user, $pass, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        ]);

        $stmt = $pdo->prepare("INSERT INTO messages (session_id, sender, message) VALUES (:session_id, :sender, :message)");
        return $stmt->execute([
            ':session_id' => $sessionId,
            ':sender'     => $sender,
            ':message'    => $message
        ]);
    } catch (PDOException $e) {
        error_log('Chat DB error: ' . $e->getMessage());
        return false;
    }
}
