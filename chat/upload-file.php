<?php
header('Content-Type: application/json');

// Only accept POST with file + chat_name
if (
    $_SERVER['REQUEST_METHOD'] !== 'POST' ||
    !isset($_FILES['file']) ||
    !isset($_POST['chat_name'])
) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'Invalid request']);
    exit;
}

// Sanitize chat name for filesystem safety
$chatNameRaw = $_POST['chat_name'];
$chatName = preg_replace('/[^a-zA-Z0-9_-]/', '_', $chatNameRaw);

// Build upload directory: /uploads/<chatName>_YYYY-MM-DD/
$date = date('Y-m-d');
$baseDir = realpath(__DIR__ . '/../uploads');
$targetDir = $baseDir . DIRECTORY_SEPARATOR . $chatName . '_' . $date . '/';

// Create directory if it doesn't exist
if (!is_dir($targetDir) && !mkdir($targetDir, 0755, true)) {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => 'Failed to create directory']);
    exit;
}

// Move uploaded file
$uploadedName = basename($_FILES['file']['name']);
$targetPath     = $targetDir . $uploadedName;

if (!move_uploaded_file($_FILES['file']['tmp_name'], $targetPath)) {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => 'Failed to move uploaded file']);
    exit;
}

// Success
echo json_encode(['success' => true]);
