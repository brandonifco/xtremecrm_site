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
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="robots" content="noindex, nofollow" />
    <link rel="stylesheet" href="/assets/css/admin-chat.css" />
    <link rel="icon" href="/favicon.ico" type="image/x-icon" />
</head>

<body>
    <main class="admin-chat-container">
        <div class="chat-header">
            <img class="chat-avatar" src="/assets/images/cari_288.png" alt="World-class support with Cari">
            <div class="chat-agent-info">
                <strong>Cari – Admin Console</strong>
                <span class="chat-status">Monitoring live sessions</span>
            </div>
        </div>

        <div class="chat-body">
            <div class="session-list" id="sessionList"></div>

            <div class="chat-panel">
                <div id="newMessageAlert" class="new-message-alert hidden">
                    --- Scroll Down for New Message(s) ---
                </div>
                <div class="messages" id="chatMessages"></div>
                <form class="chat-input" id="chatForm">
                    <input type="text" id="chatInput" placeholder="Type a reply..." autocomplete="off" />
                    <button type="submit">Send</button>
                </form>
            </div>
        </div>
    </main>

    <script type="module" src="/assets/js/admin/main.js"></script>
</body>

</html>