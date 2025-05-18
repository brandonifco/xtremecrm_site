<?php
require_once __DIR__ . '/../functions/loadEnv.php';
loadEnv();

/**
 * Returns a PDO connection using environment variables.
 *
 * @return PDO
 * @throws PDOException
 */
function getDatabaseConnection(): PDO {
    $host = getenv('DB_HOST');
    $db   = getenv('DB_NAME');
    $user = getenv('DB_USER');
    $pass = getenv('DB_PASS');

    $dsn = "mysql:host=$host;dbname=$db;charset=utf8mb4";

    return new PDO($dsn, $user, $pass, [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
}
