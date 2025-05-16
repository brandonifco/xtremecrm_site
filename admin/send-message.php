<?php
require_once __DIR__ . '/../functions/loadEnv.php';
require_once __DIR__ . '/../functions/saveMessage.php';

loadEnv();
header('Content-Type: application/json');

$sessionId = $_POST['session_id'] ?? '';
$message = trim($_POST['message'] ?? '');

if (!$sessionId || $message === '') {
    echo json_encode(['success' => false, 'error' => 'Missing data']);
    exit;
}

$success = saveMessage($sessionId, 'admin', $message);

echo json_encode(['success' => $success]);
