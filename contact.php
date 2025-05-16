<?php
$pageTitle = "Contact Us";
include 'includes/header.php';
include 'includes/navbar.php';
?>

<main class="contact-page">

    <section class="hero">
        <h1>Get In Touch</h1>
        <p>If you have questions about XtremeCRM, need support, or want to discuss custom integration solutions, please reach out. We typically respond within 1 business day.</p>
    </section>
    <section class="contact-section">
        <div class="contact-container">
            <!-- Left: Form -->
            <div class="contact-form">
                <form method="post" action="scripts/contact-handler.php">
                    <label for="name">Your Name</label>
                    <input type="text" id="name" name="name" required>

                    <label for="email">Your Email</label>
                    <input type="email" id="email" name="email" required>

                    <label for="subject">Subject</label>
                    <input type="text" id="subject" name="subject" required>

                    <label for="message">Message</label>
                    <textarea id="message" name="message" rows="6" required></textarea>

                    <button type="submit">Send Message</button>
                </form>
            </div>

            <!-- Right: Contact Info -->
            <aside class="contact-info">
                <h3>Contact Info</h3><br>
                <p><strong>Contact Person:</strong><br><br><strong>Cari Valentine</strong><br>Business Support<br> Data Access Inc</p>
                <p><strong>Email:</strong><svg xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 24 24"
                        fill="var(--color-primary)"
                        style="width: 1em; vertical-align: middle; margin-right: 0.5em;">
                        <path d="M2 4a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v1.5l-10 6.25L2 5.5V4zm0 3.5v12a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-12l-10 6.25L2 7.5z" />
                    </svg><a href="mailto:cari@dataaccessinc.com">cari@dataaccessinc.com</a></p>
                <p><strong>Location:</strong> USA (Eastern Time)</p>
                <p><strong>Response Time:</strong> Typically within 1 business day</p>
            </aside>
        </div>
    </section>
</main>

<?php include 'includes/footer.php'; ?>