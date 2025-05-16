<?php
session_start();
header('Content-Type: application/json');

require_once __DIR__ . '/../functions/loadEnv.php';
loadEnv();

$host = getenv('DB_HOST');
$db   = getenv('DB_NAME');
$user = getenv('DB_USER');
$pass = getenv('DB_PASS');

if (!isset($_SESSION['chat_id'])) {
    $_SESSION['chat_id'] = bin2hex(random_bytes(16));
}

$sessionId = $_SESSION['chat_id'];

try {
    $pdo = new PDO("mysql:host=127.0.0.1;dbname=$db;charset=utf8mb4", $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    ]);

    $stmt = $pdo->prepare("
        INSERT INTO chat_status (session_id, typing, typing_expires)
        VALUES (:session_id, 1, DATE_ADD(NOW(), INTERVAL 5 SECOND))
        ON DUPLICATE KEY UPDATE
            typing = 1,
            typing_expires = DATE_ADD(NOW(), INTERVAL 5 SECOND)
    ");

    $stmt->execute([':session_id' => $sessionId]);

    echo json_encode(['typing' => true]);
} catch (PDOException $e) {
    error_log('Typing status error: ' . $e->getMessage());
    echo json_encode(['error' => true]);
}
