<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
<title>AutoCare | Home</title>
<link rel="stylesheet" href="assets/css/style.css">
</head>

<body class="home-page">

<!-- HEADER -->
<div class="header-content header-flex" style="position:relative; z-index:2;">
    <div class="header-left" onclick="window.location.href='home.php'" style="cursor:pointer;">
        <img src="assets/images/logo.png" class="logo">
        <span class="divider">|</span>
        <h1>Auto<span>Care</span></h1>
    </div>

    <div class="header-right profile-menu">
    <img src="assets/images/profile.png" class="profile-icon-new">

    <div class="dropdown">
        <a href="index.php">Login</a>
        <a href="signup.php">Signup</a>
    </div>
</div>
</div>

<!-- HERO SLIDER -->
<div class="hero-slider">

    <div class="slide active">
        <div class="slide-content">
            <h1>🚗 Smart Vehicle Management</h1>
            <p>Track services, usage, and vehicle health with precision.</p>
            <button class="primary-btn">
                Go to Dashboard →
            </button>
        </div>
    </div>

    <div class="slide">
        <div class="slide-content">
            <h1>📊 Intelligent Insights</h1>
            <p>Data-driven decisions instead of guesswork.</p>
            <button  class="primary-btn">
                View Insights →
            </button>
        </div>
    </div>

    <div class="slide">
        <div class="slide-content">
            <h1>📄 Document Tracking</h1>
            <p>Never miss renewals again with smart alerts.</p>
            <button class="primary-btn">
                Manage Docs →
            </button>
        </div>
    </div>

    <div class="slide">
        <div class="slide-content">
            <h1>⚙ Vehicle Health</h1>
            <p>Understand your car like never before.</p>
            <button class="primary-btn">
                Check Health →
            </button>
        </div>
    </div>

    <div class="dots">
        <span class="dot active" onclick="goToSlide(0)"></span>
        <span class="dot" onclick="goToSlide(1)"></span>
        <span class="dot" onclick="goToSlide(2)"></span>
        <span class="dot" onclick="goToSlide(3)"></span>
    </div>

</div>

<!-- WHY AUTOCare -->
<section class="home-section why">
    <h2>Why AutoCare?</h2>

    <div class="why-row">
        <div class="why-item">
            <span>📡</span>
            <h3>Live Tracking</h3>
            <p>Monitor your vehicle activity and service in real time.</p>
        </div>

        <div class="why-item">
            <span>🧠</span>
            <h3>Smart Decisions</h3>
            <p>Insights based on actual usage, not assumptions.</p>
        </div>

        <div class="why-item">
            <span>⏱</span>
            <h3>Save Time</h3>
            <p>No manual reminders or forgotten services.</p>
        </div>

        <div class="why-item">
            <span>🔒</span>
            <h3>Secure Data</h3>
            <p>Your vehicle records are always safe and accessible.</p>
        </div>
    </div>
</section>

<!-- FEATURE STRIP -->
<section class="feature-strip">
    <div class="feature-strip-item">
        <span>🚗</span>
        <h4>Smart Service</h4>
        <p>Usage-based maintenance tracking</p>
    </div>

    <div class="feature-strip-item">
        <span>📄</span>
        <h4>Documents</h4>
        <p>Centralized expiry management</p>
    </div>

    <div class="feature-strip-item">
        <span>⚠</span>
        <h4>Alerts</h4>
        <p>Instant reminders and warnings</p>
    </div>

    <div class="feature-strip-item">
        <span>📊</span>
        <h4>Insights</h4>
        <p>Understand vehicle performance</p>
    </div>
</section>

<!-- HOW IT WORKS -->
<section class="home-section steps">
    <h2>How It Works</h2>

    <div class="steps-flow">
        <div class="step">1️⃣ Add Vehicle</div>
        <div class="line"></div>
        <div class="step">2️⃣ Track Usage</div>
        <div class="line"></div>
        <div class="step">3️⃣ Monitor Health</div>
        <div class="line"></div>
        <div class="step">4️⃣ Stay Updated</div>
    </div>
</section>

<!-- STATS SECTION -->
<section class="stats">
    <div>
        <h2>500+</h2>
        <p>Vehicles Managed</p>
    </div>
    <div>
        <h2>1000+</h2>
        <p>Services Tracked</p>
    </div>
    <div>
        <h2>99%</h2>
        <p>User Satisfaction</p>
    </div>
</section>

<!-- CTA -->
<section class="home-cta">
    <h2>Your vehicle deserves better care</h2>
    <button class="primary-btn">
        Get Started →
    </button>
    <br><br><br>
</section>

<footer>
    © 2026 AutoCare | Designed by AutoCare Team
</footer>

<script>
let currentSlide = 0;
const slides = document.querySelectorAll(".slide");
const dots = document.querySelectorAll(".dot");

function showSlide(newIndex){
    if(newIndex === currentSlide) return;

    const current = slides[currentSlide];
    const next = slides[newIndex];

    // prepare next (right side)
    next.classList.add("enter");

    // force reflow (important)
    next.offsetHeight;

    // animate
    current.classList.add("exit");
    next.classList.add("active");

    // cleanup
    setTimeout(() => {
        current.classList.remove("active", "exit");
        next.classList.remove("enter");
    }, 800);

    dots.forEach(d => d.classList.remove("active"));
    dots[newIndex].classList.add("active");

    currentSlide = newIndex;
}

function nextSlide(){
    let next = (currentSlide + 1) % slides.length;
    showSlide(next);
}

function goToSlide(index){
    showSlide(index);
}

// SINGLE interval (fixed)
let interval = setInterval(nextSlide, 2500);

// pause on hover
document.querySelector(".hero-slider").addEventListener("mouseover", () => {
    clearInterval(interval);
});

document.querySelector(".hero-slider").addEventListener("mouseout", () => {
    interval = setInterval(nextSlide, 4000);
});
</script>

</body>
</html>