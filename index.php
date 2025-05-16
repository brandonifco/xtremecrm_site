<?php
$pageTitle = "Welcome to XtremeCRM";
include 'includes/header.php';
include 'includes/navbar.php';

require_once __DIR__ . '/functions/loadEnv.php';
loadEnv(); // Load environment variables

$dbHost = getenv('DB_HOST');
$dbName = getenv('DB_NAME');

?>

<body>
    <section class="hero">
        <div class="container">
            <h1>Your Business. Your CRM. Tailored to You.</h1>
            <p>Streamline operations, boost productivity, and grow confidently with XtremeCRM.</p>
            <div class="hero-buttons">
                <a href="/contact.php" class="btn-primary">Request a Demo</a>
                <a href="/products/xtremecrm.php" class="btn-secondary">Learn More</a>
            </div>
        </div>
    </section>
    <section class="features">
        <div class="container">
            <h2 class="text-center mb-2">Powerful Features. Seamless Experience.</h2>
            <div class="features-grid">
                <div class="feature-box">
                    <?php include 'assets/icons/settings.svg'; ?>
                    <h3>Fully Customizable</h3>
                    <p>Adapt workflows, fields, and views to match your unique business processes.</p>
                </div>
                <div class="feature-box">
                    <?php include 'assets/icons/cloud.svg'; ?>
                    <h3>Cloud-Based Access</h3>
                    <p>Securely access your CRM from anywhere with no local install required.</p>
                </div>
                <div class="feature-box">
                    <?php include 'assets/icons/mobile.svg'; ?>
                    <h3>Mobile Ready</h3>
                    <p>Your team can use XtremeCRM on the go with a responsive UI and mobile app.</p>
                </div>
                <div class="feature-box">
                    <?php include 'assets/icons/chat.svg'; ?>
                    <h3>Integrated Communication</h3>
                    <p>Track emails, calls, and messages in one place for better follow-through.</p>
                </div>
                <div class="feature-box">
                    <?php include 'assets/icons/analytics.svg'; ?>
                    <h3>Analytics & Reports</h3>
                    <p>Built-in reporting tools give you clear insight into your performance and goals.</p>
                </div>
                <div class="feature-box">
                    <?php include 'assets/icons/lock.svg'; ?>
                    <h3>Secure & Scalable</h3>
                    <p>Enterprise-level security and room to grow with your business needs.</p>
                </div>
            </div>
        </div>
    </section>
 
</body>
<!-- Page content here -->

<?php include 'includes/footer.php'; ?>