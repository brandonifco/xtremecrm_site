<?php
require_once __DIR__ . '/../includes/database.php';
require_once __DIR__ . '/../functions/MessageStore.php';
require_once __DIR__ . '/../functions/jsonResponse.php';

$pdo = getDatabaseConnection();

$sessionId = $_GET['session'] ?? '';
if (!$sessionId) {
    jsonError('Missing session ID');
}

$messages = fetchMessages($pdo, $sessionId);

// Add formatted time
foreach ($messages as &$msg) {
    if (isset($msg['timestamp'])) {
        $msg['time'] = date('g:i A', strtotime($msg['timestamp']));
    }
}

// Determine typing status
$typing = false;

try {
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
// ✅ Fetch session name
$stmt = $pdo->prepare('SELECT name FROM sessions WHERE session_id = ?');
$stmt->execute([$sessionId]);
$session = $stmt->fetch(PDO::FETCH_ASSOC);
$sessionName = $session['name'] ?? 'User';

// ✅ Inject name into each user message
foreach ($messages as &$msg) {
    if ($msg['sender'] === 'user') {
        $msg['name'] = $sessionName;
    }
}

jsonSuccess([
    'messages' => $messages,
    'typing'   => $typing
]);
