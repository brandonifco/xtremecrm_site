<?php

/**
 * Send a JSON success response.
 *
 * @param array $data
 * @return void
 */
function jsonSuccess(array $data = []): void {
    header('Content-Type: application/json');
    echo json_encode(['success' => true] + $data);
    exit;
}

/**
 * Send a JSON error response.
 *
 * @param string $message
 * @param int $statusCode
 * @return void
 */
function jsonError(string $message, int $statusCode = 400): void {
    http_response_code($statusCode);
    header('Content-Type: application/json');
    echo json_encode([
        'success' => false,
        'error'   => $message
    ]);
    exit;
}
