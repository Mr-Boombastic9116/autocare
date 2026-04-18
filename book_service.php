<?php
session_start();
if(!isset($_SESSION['user'])){
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Book Service - AutoCare</title>
<link rel="stylesheet" href="assets/css/style.css">

<style>

/* ===== LAYOUT ===== */
.service-container {
    display: flex;
    width: 90%;
    margin: 40px auto;
    gap: 20px;
    align-items: flex-start;
}

.left-panel, .middle-panel, .right-panel {
    background: white;
    padding: 20px;
    border-radius: 12px;
    box-shadow: 0px 4px 12px rgba(0,0,0,0.15);
}

.left-panel { width: 25%; }
.middle-panel { width: 50%; }
.right-panel { width: 25%; position: sticky; top: 100px; }

/* ===== TIME SLOTS ===== */
.time-slots { display:flex; flex-wrap:wrap; gap:10px; margin-top:10px; }

.slot {
    padding:10px 15px;
    border-radius:6px;
    cursor:pointer;
    font-size:13px;
}

.available { background:#d4edda; }
.booked { background:#f8d7da; pointer-events:none; }
.selected { background:#FFC107; }

/* LEGEND */
.slot-legend { margin-top:10px; font-size:13px; display:flex; gap:15px; }
.legend { width:12px; height:12px; display:inline-block; border-radius:3px; margin-right:5px; }
.legend.available { background:#d4edda; }
.legend.booked { background:#f8d7da; }
.legend.selected { background:#FFC107; }

/* ===== SERVICES ===== */
.services-list {
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:10px;
    margin-top:10px;
}

.services-list label {
    display:flex;
    justify-content:space-between;
    align-items:center;
    background:#f9f9f9;
    padding:8px 10px;
    border-radius:6px;
    cursor:pointer;
}

.services-list input { margin-right:8px; }

.service-name { font-size:14px; }
.service-price { font-size:12px; color:#666; }

/* ===== COST PANEL ===== */
.cost-details { font-size:13px; margin-bottom:10px; }
.row { display:flex; justify-content:space-between; margin-bottom:5px; }

/* ===== OVERLAY ===== */
#overlay {
    display:none;
    position:fixed;
    width:100%;
    height:100%;
    background:rgba(0,0,0,0.5);
    top:0; left:0;
    z-index:999;
}

.overlay-box {
    background:white;
    padding:30px;
    border-radius:10px;
    text-align:center;
    position:absolute;
    top:50%;
    left:50%;
    transform:translate(-50%, -50%);
}

.overlay-box img { width:60px; }

/* BUTTON */
.book-btn {
    width:100%;
    padding:12px;
    background:#FFC107;
    border:none;
    border-radius:6px;
    font-weight:bold;
    cursor:pointer;
}
.left-panel img {
    width: 100%;
    height: auto;
    max-width: 100%;
    display: block;
    border-radius: 8px;
}
/* SERVICE ITEM FIX */
.service-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.service-item .left {
    display: flex;
    align-items: center; /* THIS is the real fix */
    gap: 8px;
}

/* checkbox tweak */
.service-item input {
    width: 16px;
    height: 16px;
    margin: 0;
    transform: translateY(1px); /* tiny adjustment */
}

/* text */
.service-name {
    font-size: 14px;
    line-height: 1; /* prevents vertical shift */
}

/* price */
.service-price {
    font-size: 13px;
    font-weight: 600;
    color: #2e7d32;
}
/* LEFT PANEL TYPOGRAPHY */

.section-title {
    font-size: 16px;
    font-weight: 700;
    margin-bottom: 5px;
}

.center-name {
    font-size: 15px;
    font-weight: 600;
    color: #222;
}

.center-details {
    font-size: 13px;
    color: #555;
    line-height: 1.4;
}

.ratings-box strong {
    font-size: 14px;
}

.rating-row {
    font-size: 13px;
    color: #444;
}

.location-title {
    font-size: 14px;
    font-weight: 600;
}

.address {
    font-size: 13px;
    color: #444;
    line-height: 1.4;
}
.left-panel {
    text-align: left;
}

/* force everything inside left */
.left-panel * {
    text-align: left;
}

/* fix spacing consistency */
.left-panel p {
    margin: 4px 0;
}

.left-panel h1,
.left-panel h4 {
    margin-bottom: 6px;
}
.rating-row span:last-child {
    font-weight: 600;
}

.center-name {
    margin-top: 2px;
}
.section-title {
    font-size: 22px;  /* increase */
    font-weight: 700;
}

/* Slightly smaller total text */
.right-panel h2 {
    font-size: 18px;  /* reduce from default */
    font-weight: 600;
}
.middle-panel textarea {
    width: 100%;
    height: 100px;   /* increase height */
    resize: none;    /* optional: prevents manual resize */
    box-sizing: border-box;
}

/* optional: better spacing */
.middle-panel textarea {
    margin-top: 15px;
}
/* OVERLAY BACKGROUND */
#redirect-overlay {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0,0,0,0.5);
    z-index: 9999;
}

/* CENTER BOX */
.redirect-box {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background: white;
    padding: 30px 40px;
    border-radius: 12px;
    text-align: center;
    box-shadow: 0px 5px 20px rgba(0,0,0,0.3);
}

/* ICON */
.redirect-icon {
    width: 60px;
    margin-bottom: 10px;
}

/* TEXT */
.redirect-box p {
    font-size: 16px;
    font-weight: 600;
    color: #1f2223;
}

/* OPTIONAL LOADING ANIMATION */
.redirect-icon {
    animation: spin 1s linear infinite;
}

@keyframes spin {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}

/* 2 COLUMN GRID */
.rating-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 10px;
    margin-top: 10px;
}

/* EACH BOX */
.rating-box {
    background: #f9f9f9;
    padding: 10px;
    border-radius: 8px;
}

/* TITLE */
.rating-title {
    font-size: 13px;
    color: #444;
}

/* VALUE */
.rating-value {
    font-size: 15px;
    font-weight: 700;
    margin-top: 4px;
}

.ratings-box p strong {
    font-size: 18px;   /* bigger */
    font-weight: 700;  /* bold */
    display: block;
    margin-bottom: 10px;
}

/* INDIVIDUAL TITLES (HEADINGS) */
.rating-title {
    font-size: 13px;
    font-weight: 600;  /* bold */
    color: #333;
    text-align: center;
}

/* RATING VALUES (LIGHTER) */
.rating-value {
    font-size: 14px;
    font-weight: 400;  /* lighter */
    color: #555;
    margin-top: 3px;
    text-align: center;
}

.contact-info {
    margin-top: 12px;
    padding: 12px;
    background: #f7f9fc;
    border-radius: 10px;
    border-left: 4px solid #FFC107;
}

.contact-info h4 {
    margin-bottom: 8px;
}

.contact-row {
    display: flex;
    justify-content: space-between;
    font-size: 13px;
    color: #444;
    padding: 3px 0;
}

.contact-row span:first-child {
    font-weight: 600;
    color: #222;
}

</style>
</head>

<body>

<!-- HEADER -->
<div class="header-content header-flex">
    <div class="header-left" onclick="window.location.href='home.php'" style="cursor:pointer;">
        <img src="assets/images/logo.png" class="logo">
        <span class="divider">|</span>
        <h1>Auto<span>Care</span></h1>
    </div>
    <div class="header-right">
        <img src="assets/images/profile.png" class="profile-icon-new" id="profileBtn">
        <div class="dropdown-new" id="dropdown">
            <a href="logout.php"><img src="assets/images/logout.png"> Logout</a>
        </div>
    </div>
</div>

<div class="service-container">

<!-- LEFT -->
<div class="left-panel">

    <h1 class="section-title">Nearest Service Center</h1>
    <br>
    <h4 class="center-name">Alcon Hyundai - Margao</h4>

    <img src="assets/images/service_center.png" class="service-img">

    <!-- DETAILS -->
    <div class="center-details">
        <p>Authorized Hyundai service center with certified technicians and modern equipment.</p>
    </div>

    <div class="contact-info">

    <h4 class="location-title">Contact Information</h4>

    <div class="contact-row">
        <span>📞 Phone:</span>
        <span>+91 98765 43210</span>
    </div>

    <div class="contact-row">
        <span>📞 Landline:</span>
        <span>0832 276 8890</span>
    </div>

    <div class="contact-row">
        <span>✉ Email:</span>
        <span>service@alconhyundai.com</span>
    </div>

</div>
<br>
    <!-- RATINGS -->
    <div class="ratings-box">
        <div style="text-align:center; margin-bottom:10px;">
    <p style="font-size:16px; font-weight:700; color:#1e3c72;">
        ⭐ Overall Rating: <span style="color:black;">4.5 / 5</span>
    </p>
</div>

        <div class="rating-grid">

    <div class="rating-box">
        <div class="rating-title">⭐ Service Quality</div>
        <div class="rating-value">4.6 / 5</div>
    </div>

    <div class="rating-box">
        <div class="rating-title">⭐ Staff Behavior</div>
        <div class="rating-value">4.4 / 5</div>
    </div>

    <div class="rating-box">
        <div class="rating-title">⭐ Timeliness</div>
        <div class="rating-value">4.3 / 5</div>
    </div>

    <div class="rating-box">
        <div class="rating-title">⭐ Value for Money</div>
        <div class="rating-value">4.5 / 5</div>
    </div>

</div>
    </div>
    <br>
    <!-- DIVIDER -->
    <hr class="divider-line">

    <!-- LOCATION -->
    <h4 class="location-title">Location</h4>

    <img src="assets/images/map.png" class="map-img">

    <p class="address">
        Alcon Hyundai Service Hub,<br>
        Margao, Goa - 403720
    </p>

</div>

<!-- MIDDLE -->
<div class="middle-panel">

<h3>Select Date</h3>
<input type="date" id="service-date">

<div id="time-section" style="display:none;">
    <h3>Select Time Slot</h3>
    <div class="time-slots" id="time-slots"></div>

    <!-- LEGEND -->
    <div class="slot-legend">
        <span class="legend available"></span>Available
        <span class="legend booked"></span>Unavailable
        <span class="legend selected"></span>Selected
    </div>
</div>

<div id="service-section" style="display:none;">
    <h3>Service Options</h3>

    <div class="services-list">

<label class="service-item">
    <div class="left">
        <input type="checkbox" value="2500">
        <span class="service-name">Engine oil change</span>
    </div>
    <span class="service-price">+₹2500</span>
</label>

<label class="service-item">
    <div class="left">
        <input type="checkbox" value="500">
        <span class="service-name">Oil filter replacement</span>
    </div>
    <span class="service-price">+₹500</span>
</label>

<label class="service-item">
    <div class="left">
        <input type="checkbox" value="800">
        <span class="service-name">Air filter replacement</span>
    </div>
    <span class="service-price">+₹800</span>
</label>

<label class="service-item">
    <div class="left">
        <input type="checkbox" value="1000">
        <span class="service-name">Cabin filter replacement</span>
    </div>
    <span class="service-price">+₹1000</span>
</label>

<label class="service-item">
    <div class="left">
        <input type="checkbox" value="1800">
        <span class="service-name">Fuel filter replacement</span>
    </div>
    <span class="service-price">+₹1800</span>
</label>

<label class="service-item">
    <div class="left">
        <input type="checkbox" value="3000">
        <span class="service-name">Brake pad (front)</span>
    </div>
    <span class="service-price">+₹3000</span>
</label>

<label class="service-item">
    <div class="left">
        <input type="checkbox" value="2800">
        <span class="service-name">Brake pad (rear)</span>
    </div>
    <span class="service-price">+₹2800</span>
</label>

<label class="service-item">
    <div class="left">
        <input type="checkbox" value="4000">
        <span class="service-name">Brake disc</span>
    </div>
    <span class="service-price">+₹4000</span>
</label>

<label class="service-item">
    <div class="left">
        <input type="checkbox" value="500">
        <span class="service-name">Wheel alignment</span>
    </div>
    <span class="service-price">+₹500</span>
</label>

<label class="service-item">
    <div class="left">
        <input type="checkbox" value="400">
        <span class="service-name">Wheel balancing</span>
    </div>
    <span class="service-price">+₹400</span>
</label>

<label class="service-item">
    <div class="left">
        <input type="checkbox" value="500">
        <span class="service-name">Tyre rotation</span>
    </div>
    <span class="service-price">+₹500</span>
</label>

<label class="service-item">
    <div class="left">
        <input type="checkbox" value="7000">
        <span class="service-name">Tyre replacement</span>
    </div>
    <span class="service-price">+₹7000</span>
</label>

<label class="service-item">
    <div class="left">
        <input type="checkbox" value="6000">
        <span class="service-name">Battery replacement</span>
    </div>
    <span class="service-price">+₹6000</span>
</label>

<label class="service-item">
    <div class="left">
        <input type="checkbox" value="1500">
        <span class="service-name">Spark plug replacement</span>
    </div>
    <span class="service-price">+₹1500</span>
</label>

<label class="service-item">
    <div class="left">
        <input type="checkbox" value="1200">
        <span class="service-name">Coolant replacement</span>
    </div>
    <span class="service-price">+₹1200</span>
</label>

<label class="service-item">
    <div class="left">
        <input type="checkbox" value="1200">
        <span class="service-name">Brake fluid replacement</span>
    </div>
    <span class="service-price">+₹1200</span>
</label>

<label class="service-item">
    <div class="left">
        <input type="checkbox" value="3500">
        <span class="service-name">Transmission fluid</span>
    </div>
    <span class="service-price">+₹3500</span>
</label>

<label class="service-item">
    <div class="left">
        <input type="checkbox" value="9000">
        <span class="service-name">Clutch replacement</span>
    </div>
    <span class="service-price">+₹9000</span>
</label>

<label class="service-item">
    <div class="left">
        <input type="checkbox" value="7000">
        <span class="service-name">Suspension repair</span>
    </div>
    <span class="service-price">+₹7000</span>
</label>

<label class="service-item">
    <div class="left">
        <input type="checkbox" value="2500">
        <span class="service-name">AC gas refill</span>
    </div>
    <span class="service-price">+₹2500</span>
</label>

<label class="service-item">
    <div class="left">
        <input type="checkbox" value="2000">
        <span class="service-name">AC servicing</span>
    </div>
    <span class="service-price">+₹2000</span>
</label>

<label class="service-item">
    <div class="left">
        <input type="checkbox" value="2500">
        <span class="service-name">Engine tuning</span>
    </div>
    <span class="service-price">+₹2500</span>
</label>

<label class="service-item">
    <div class="left">
        <input type="checkbox" value="1500">
        <span class="service-name">Throttle cleaning</span>
    </div>
    <span class="service-price">+₹1500</span>
</label>

<label class="service-item">
    <div class="left">
        <input type="checkbox" value="2500">
        <span class="service-name">Injector cleaning</span>
    </div>
    <span class="service-price">+₹2500</span>
</label>

<label class="service-item">
    <div class="left">
        <input type="checkbox" value="2000">
        <span class="service-name">Radiator flushing</span>
    </div>
    <span class="service-price">+₹2000</span>
</label>

<label class="service-item">
    <div class="left">
        <input type="checkbox" value="7000">
        <span class="service-name">Timing belt replacement</span>
    </div>
    <span class="service-price">+₹7000</span>
</label>

<label class="service-item">
    <div class="left">
        <input type="checkbox" value="5000">
        <span class="service-name">Alternator repair</span>
    </div>
    <span class="service-price">+₹5000</span>
</label>

<label class="service-item">
    <div class="left">
        <input type="checkbox" value="3000">
        <span class="service-name">Starter motor repair</span>
    </div>
    <span class="service-price">+₹3000</span>
</label>

<label class="service-item">
    <div class="left">
        <input type="checkbox" value="500">
        <span class="service-name">Headlight bulb replacement</span>
    </div>
    <span class="service-price">+₹500</span>
</label>
</div>

    <textarea id="specialBox" placeholder="Special Requests"></textarea>
</div>

</div>

<!-- RIGHT -->
<div class="right-panel">

<h3>Booking Summary</h3>

<div id="costDetails" class="cost-details">
    <div class="row"><span>Car Wash</span><span>FREE</span></div>
    <div class="row"><span>Service Charge</span><span>₹1500</span></div>
</div>

<h2>Estimated Total: ₹<span id="total">1500</span></h2>

<p>Advance: ₹500 *</p>


<button class="book-btn" id="bookBtn">Book Service</button>
<br><br>
<small>* adjusted in final bill</small>
</div>

</div>

<!-- OVERLAY -->
<div id="redirect-overlay">
    <div class="redirect-box">
        <img src="assets/images/redirect.png" class="redirect-icon">
        <p>Redirecting to Payment Gateway...</p>
    </div>
</div>
<br><br><br>
<footer>
    © 2026 AutoCare | Designed by AutoCare Team
</footer>
<script>

// DATE
document.getElementById("service-date").onchange = () => {
    document.getElementById("time-section").style.display="block";
};

// TIME SLOTS
let times=["9-10","10-11","11-12","12-1","1-2","2-3"];
let unavailable=[2,4];

times.forEach((t,i)=>{
    let d=document.createElement("div");
    d.className=unavailable.includes(i)?"slot booked":"slot available";
    d.innerText=t;

    d.onclick=()=>{
        if(d.classList.contains("booked")) return;

        document.querySelectorAll(".slot").forEach(s=>s.classList.remove("selected"));
        d.classList.add("selected");

        document.getElementById("service-section").style.display="block";
    };

    document.getElementById("time-slots").appendChild(d);
});

// COST LOGIC
let total=1500;
let totalEl=document.getElementById("total");
let costDetails=document.getElementById("costDetails");
let checkboxes=document.querySelectorAll(".services-list input");

checkboxes.forEach(cb=>{
    cb.onchange=()=>{

        total=1500;
        costDetails.innerHTML=`
        <div class="row"><span>Car Wash</span><span>FREE</span></div>
        <div class="row"><span>Service Charge</span><span>₹1500</span></div>
        `;

        checkboxes.forEach(c=>{
            if(c.checked){
                total+=parseInt(c.value);

                costDetails.innerHTML+=`
                <div class="row">
                    <span>${c.parentElement.innerText}</span>
                    <span>₹${c.value}</span>
                </div>`;
            }
        });

        totalEl.innerText=total;
    };
});

// SPECIAL REQUEST
document.getElementById("specialBox").oninput=function(){
    let exist=document.getElementById("specialRow");

    if(this.value && !exist){
        costDetails.innerHTML+=`
        <div class="row" id="specialRow">
            <span>Special Requests</span>
            <span>Extra charges</span>
        </div>`;
    }

    if(!this.value && exist){
        exist.remove();
    }
};

// BOOK
document.getElementById("bookBtn").onclick = function(){

    let selectedSlot = document.querySelector(".slot.selected");
    let date = document.getElementById("service-date").value;
    let notes = document.getElementById("specialBox").value;

    if(!date){
        alert("Please select a date");
        return;
    }

    if(!selectedSlot){
        alert("Please select a time slot");
        return;
    }

    let slot = selectedSlot.innerText;

    // GET SELECTED SERVICES
    let selectedServices = [];
    document.querySelectorAll(".services-list input:checked").forEach(cb => {
        let name = cb.closest(".service-item").querySelector(".service-name").innerText;
        selectedServices.push(name);
    });

    let services = selectedServices.join(", ");

    // SHOW OVERLAY
    let overlay = document.getElementById("redirect-overlay");
    overlay.style.display = "block";

    sessionStorage.setItem("redirected", "true");

    // SEND DATA TO PHP
    fetch("ajax/save_booking.php", {
    method: "POST",
    headers: { "Content-Type": "application/x-www-form-urlencoded" },
    body: `date=${encodeURIComponent(date)}
          &time=${encodeURIComponent(slot)}
          &services=${encodeURIComponent(services)}
          &total=${encodeURIComponent(total)}
          &notes=${encodeURIComponent(notes)}`
})
.then(res => res.json())
.then(data => {

    if(data.status === "success"){

        // store booking id
        sessionStorage.setItem("booking_id", data.booking_id);

        setTimeout(() => {
            window.location.href = "confirmation.php";
        }, 3000);

    } else {
        alert("Booking failed");
    }

});
};

// PROFILE DROPDOWN
document.getElementById("profileBtn").onclick=function(){
    let d=document.getElementById("dropdown");
    d.style.display=d.style.display==="block"?"none":"block";
};

window.onload = function(){
    if(sessionStorage.getItem("redirected")){
        document.getElementById("redirect-overlay").style.display = "none";
        sessionStorage.removeItem("redirected");
    }
};
</script>

</body>
</html>