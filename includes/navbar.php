<?php /* ---------------------------------------------
   navbar.php — responsive navigation component
   Dependencies: responsive.css (hamburger styles)
   JS: tiny vanilla toggle at bottom of this file
-------------------------------------------------*/ ?>

<nav class="navbar">
  <div class="nav-container">
    <!-- Hamburger button (mobile only) -->
    <button class="hamburger" aria-label="Toggle navigation">
      <span></span>
    </button>
    <!-- Full‑screen overlay menu -->
    <ul class="nav-links">
      <li><a href="/">Home</a></li>
      <li><a href="/products/xtremecrm.php">XtremeCRM</a></li>
      <li><a href="/schedule.php">Schedule an Appointment</a></li>
      <li><a href="/integrations.php">Integrations</a></li>
      <li><a href="/mobile-app.php">Mobile Application</a></li>
      <li><a href="/blog/">Blog</a></li>
      <li><a href="/about.php">About</a></li>
      <li><a href="/contact.php">Contact</a></li>
    </ul>
  </div>
</nav>

<!-- =================================================================
     Inline vanilla‑JS toggle (you can move this to /assets/js/nav.js)
     ================================================================= -->
<script>
  document.addEventListener('DOMContentLoaded', () => {
    const hamburger = document.querySelector('.hamburger');
    hamburger?.addEventListener('click', () => {
      hamburger.classList.toggle('active');
      document.body.classList.toggle('nav-open');
    });

    // Close menu when a nav link is clicked (optional UX)
    document.querySelectorAll('.nav-links a').forEach(link => {
      link.addEventListener('click', () => {
        if (document.body.classList.contains('nav-open')) {
          document.body.classList.remove('nav-open');
          hamburger.classList.remove('active');
        }
      });
    });
  });
</script>
