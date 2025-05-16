<?php
$pageTitle = "Schedule with Cari";
include 'includes/header.php';
include 'includes/navbar.php'; ?>

<main class="schedule-page">
    <section class="hero">
        <h1>Schedule with Cari</h1>
        <p>Use the calendar below to schedule a one-on-one session with Cari.</p>
    </section>

    <section class="schedule-iframe-container">
        <iframe
            src="https://outlook.office365.com/owa/calendar/YOURCALENDARNAME@yourdomain.com/bookings/"
            width="100%"
            height="800"
            frameborder="0"
            scrolling="no"
            allowfullscreen
            style="border:0;">
        </iframe>
    </section>
</main>

<?php include 'includes/footer.php'; ?>