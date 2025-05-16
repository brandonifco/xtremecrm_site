<?php
require_once __DIR__ . '/../functions/loadEnv.php';
require_once __DIR__ . '/../functions/fetchMessages.php';

loadEnv();
$host = getenv('DB_HOST');
$db   = getenv('DB_NAME');
$user = getenv('DB_USER');
$pass = getenv('DB_PASS');

header('Content-Type: application/json');

$sessionId = $_GET['session'] ?? '';
if (!$sessionId) {
    echo json_encode([]);
    exit;
}

$messages = fetchMessages($sessionId);

// Add formatted time
foreach ($messages as &$msg) {
    $msg['time'] = date('g:i A', strtotime($msg['timestamp']));
}

// Determine typing status from the database
$typing = false;

try {
    $pdo = new PDO("mysql:host=127.0.0.1;dbname=$db;charset=utf8mb4", $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    ]);

    $stmt = $pdo->prepare("
        SELECT typing_expires
        FROM chat_status
        WHERE session_id = :session_id
          AND typing = 1
          AND typing_expires > NOW()
        LIMIT 1
    ");

    $stmt->execute([':session_id' => $sessionId]);

    if ($stmt->fetch()) {
        $typing = true;
    }

} catch (PDOException $e) {
    error_log('Typing check error: ' . $e->getMessage());
}

echo json_encode([
    'messages' => $messages,
    'typing'   => $typing
]);
