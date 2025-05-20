<?php
if (session_status() === PHP_SESSION_NONE) {
    ini_set('session.gc_maxlifetime', 3600);
    ini_set('session.gc_probability', 1);
    ini_set('session.gc_divisor', 10);
    $useSecure = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || $_SERVER['SERVER_PORT'] == 443;

    session_set_cookie_params([
        'lifetime' => 0,
        'path' => '/',
        'secure' => $useSecure, // more reliable check
        'httponly' => true,
        'samesite' => 'Lax'
    ]);

    session_start();
    if (!isset($_SESSION['chat_id'])) {
        $_SESSION['chat_id'] = bin2hex(random_bytes(16));
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?php echo htmlspecialchars($pageTitle ?? 'XtremeCRM'); ?></title>
    <meta name="description" content="<?php echo htmlspecialchars($metaDescription ?? 'CRM insights, integration tips, and product updates from XtremeCRM.'); ?>" />

    <!-- Open Graph / Facebook -->
    <meta property="og:title" content="<?php echo htmlspecialchars($pageTitle ?? 'XtremeCRM'); ?>" />
    <meta property="og:description" content="<?php echo htmlspecialchars($metaDescription ?? 'CRM insights and updates from XtremeCRM.'); ?>" />
    <meta property="og:type" content="article" />
    <?php if (!empty($featuredImageUrl)): ?>
        <meta property="og:image" content="<?php echo htmlspecialchars($featuredImageUrl); ?>" />
    <?php endif; ?>

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:title" content="<?php echo htmlspecialchars($pageTitle ?? 'XtremeCRM'); ?>" />
    <meta name="twitter:description" content="<?php echo htmlspecialchars($metaDescription ?? 'Tips and updates from XtremeCRM.'); ?>" />
    <?php if (!empty($featuredImageUrl)): ?>
        <meta name="twitter:image" content="<?php echo htmlspecialchars($featuredImageUrl); ?>" />
    <?php endif; ?>

    <!-- Styles and other includes -->
    <link rel="stylesheet" href="/assets/css/main.css?v=3" />
    <link rel="canonical" href="<?php echo 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>" />

</head>

<body>
    <header class="site-header">
        <div class="container header-flex">
            <a href="/index.php" class="logo">
                <img src="/assets/images/xtremecrm_logo.png" alt="XtremeCRM Logo" class="logo-img" />
            </a>

            <a href="/admin/login.php" class="login-link">Login</a>
        </div>
    </header>