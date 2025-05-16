<?php
require_once __DIR__ . '/../functions/loadEnv.php';
loadEnv();

// Basic HTTP auth
$ADMIN_USER = getenv('ADMIN_USER') ?: 'admin';
$ADMIN_PASS = getenv('ADMIN_PASS') ?: 's3cureP@ss';

if (
    !isset($_SERVER['PHP_AUTH_USER']) ||
    $_SERVER['PHP_AUTH_USER'] !== $ADMIN_USER ||
    $_SERVER['PHP_AUTH_PW']   !== $ADMIN_PASS
) {
    header('WWW-Authenticate: Basic realm="Admin Chat"');
    header('HTTP/1.0 401 Unauthorized');
    echo 'Unauthorized';
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>Admin Chat Console</title>
    <link rel="stylesheet" href="/assets/css/admin-chat.css" />
</head>

<body>
    <div class="session-list" id="sessionList">
        <strong>Sessions</strong>
    </div>

    <div class="chat-panel">
        <div class="messages" id="chatMessages"></div>
        <form class="chat-input" id="chatForm">
            <input type="text" id="chatInput" placeholder="Type a reply..." autocomplete="off" />
            <button type="submit">Send</button>
        </form>
    </div>

    <script type="module" src="/assets/js/admin/main.js"></script>
    </body>

</html>