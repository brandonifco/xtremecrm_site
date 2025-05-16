<?php
require_once __DIR__ . '/../functions/loadEnv.php';
loadEnv();

$host = getenv('DB_HOST');
$db   = getenv('DB_NAME');
$user = getenv('DB_USER');
$pass = getenv('DB_PASS');

header('Content-Type: application/json');

try {
    $pdo = new PDO("mysql:host=127.0.0.1;dbname=$db;charset=utf8mb4", $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    ]);

    $stmt = $pdo->query("
        SELECT session_id, MAX(timestamp) as last_time, 
               SUBSTRING_INDEX(GROUP_CONCAT(message ORDER BY timestamp DESC), '\n', 1) as last_message
        FROM messages
        GROUP BY session_id
        ORDER BY last_time DESC
    ");

    $sessions = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Format timestamps
    foreach ($sessions as &$s) {
        $s['last_time'] = date('M j g:i A', strtotime($s['last_time']));
    }

    echo json_encode($sessions);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
