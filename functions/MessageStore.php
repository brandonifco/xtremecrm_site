<?php

/**
 * Save a message to the database.
 *
 * @param PDO $pdo
 * @param string $sessionId
 * @param string $sender
 * @param string $message
 * @return bool
 */
function saveMessage(PDO $pdo, string $sessionId, string $sender, string $message): bool
{
    try {
        $stmt = $pdo->prepare("
            INSERT INTO messages (session_id, sender, message)
            VALUES (:session_id, :sender, :message)
        ");
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

/**
 * Fetch messages for a specific chat session.
 *
 * @param PDO $pdo
 * @param string $sessionId
 * @return array
 */
function fetchMessages(PDO $pdo, string $sessionId): array
{
    try {
        $stmt = $pdo->prepare("
            SELECT sender, message, timestamp
            FROM messages
            WHERE session_id = :session_id
            ORDER BY timestamp ASC
        ");
        $stmt->execute([':session_id' => $sessionId]);
        return $stmt->fetchAll();
    } catch (PDOException $e) {
        error_log('Chat DB error: ' . $e->getMessage());
        return [];
    }
}
