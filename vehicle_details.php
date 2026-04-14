<?php
session_start();
include("includes/db.php");

if(!isset($_SESSION['user'])){
    header("Location: index.php");
    exit();
}

$id = $_GET['id'];

$vehicle = $conn->query("SELECT * FROM vehicles WHERE id=$id")->fetch_assoc();
?>
<!DOCTYPE html>
<html>
<head>
<title>Vehicle Details</title>
<link rel="stylesheet" href="assets/css/style.css">
</head>

<body>

<!-- HEADER -->
<div class="header-content header-flex">
    <div class="header-left">
        <img src="assets/images/logo.png" class="logo">
        <span class="divider"></span>
        <h1>Auto<span>Care</span></h1>
    </div>
</div>

<!-- MAIN CONTAINER -->
<div class="details-container">

    <!-- LEFT PANEL -->
    <div class="left-panel">
    <img src="assets/images/car1.png" class="car-img">

    <h2><?= $vehicle['company'] . " " . $vehicle['model'] ?></h2>
    <p><?= $vehicle['license_no'] ?></p>
</div>

    <!-- RIGHT PANEL -->
    <div class="right-panel">

        <!-- TABS -->
        <div class="tabs">
            <button class="tab-btn active" onclick="openTab('details')">Details</button>
            <button class="tab-btn" onclick="openTab('service')">Service</button>
            <button class="tab-btn" onclick="openTab('renewal')">Document Renewal</button>
            <button class="tab-btn" onclick="openTab('docs')">Document Holder</button>
        </div>

        <!-- TAB CONTENT -->

        <!-- DETAILS -->
<div class="tab-content active" id="details">

    <div class="details-grid">

        <!-- LEFT SIDE -->
        <div class="details-col">
            <p><b>Company:</b> <?= $vehicle['company'] ?></p>
            <p><b>Model:</b> <?= $vehicle['model'] ?></p>
            <p><b>Year:</b> <?= $vehicle['year'] ?></p>
            <p><b>Fuel:</b> <?= $vehicle['fuel'] ?></p>
            <p><b>Variant:</b> <?= $vehicle['variant'] ?></p>
            <p><b>KMs Driven:</b> <?= $vehicle['kms'] ?></p>
        </div>

        <!-- RIGHT SIDE -->
        <div class="details-col">
            <p><b>Chassis Number:</b> ABC123XYZ789</p>
            <p><b>Engine Number:</b> ENG456789</p>
            <p><b>Colour:</b> White</p>
            <p><b>Transmission:</b> Automatic</p>
            <p><b>Power:</b> 113 BHP</p>
            <p><b>Torque:</b> 144 Nm</p>
            <p><b>Mileage:</b> 17 km/l</p>
        </div>

    </div>

</div>

        <!-- SERVICE -->
        <div class="tab-content" id="service">

    <p><b>Last Service:</b> <?= $vehicle['last_service'] ?></p>
    <p><b>KMs Driven:</b> <?= $vehicle['kms'] ?></p>

    <p><b>Next Service:</b> <?= $vehicle['kms'] + 5000 ?> km</p>
    <p><b>Tyre Age:</b> 2 Years</p>

    <button class="action-btn">Book Service</button>

</div>

        <!-- DOCUMENT RENEWAL -->
        <div class="tab-content" id="renewal">
            <div class="doc-row">
                <span>RC</span>
                <span>Valid till: 2035</span>
                <button>Renew</button>
            </div>

            <div class="doc-row">
                <span>Insurance</span>
                <span>Expires: 2026</span>
                <button>Renew</button>
            </div>

            <div class="doc-row">
                <span>PUC</span>
                <span>Expires: 2025</span>
                <button>Renew</button>
            </div>

            <div class="doc-row">
                <span>FASTag</span>
                <span>Balance: ₹1200</span>
                <button>Recharge</button>
            </div>
        </div>

        <!-- DOCUMENT HOLDER -->
<div class="tab-content" id="docs">

    <div class="doc-grid">

        <div class="doc-row">
            <span>Driving Licence</span>
            <div class="doc-actions">
                <button class="view-btn">View</button>
                <button class="download-btn">📄 Download as PDF</button>
            </div>
        </div>

        <div class="doc-row">
            <span>Registration Certificate (RC)</span>
            <div class="doc-actions">
                <button class="view-btn">View</button>
                <button class="download-btn">📄 Download as PDF</button>
            </div>
        </div>

        <div class="doc-row">
            <span>Car Insurance Certificate</span>
            <div class="doc-actions">
                <button class="view-btn">View</button>
                <button class="download-btn">📄 Download as PDF</button>
            </div>
        </div>

        <div class="doc-row">
            <span>Pollution Under Control (PUC) Certificate</span>
            <div class="doc-actions">
                <button class="view-btn">View</button>
                <button class="download-btn">📄 Download as PDF</button>
            </div>
        </div>

        <div class="doc-row">
            <span>Vehicle Invoice Copy</span>
            <div class="doc-actions">
                <button class="view-btn">View</button>
                <button class="download-btn">📄 Download as PDF</button>
            </div>
        </div>

        <div class="doc-row">
            <span>Loan / Hypothecation Papers</span>
            <div class="doc-actions">
                <button class="view-btn">View</button>
                <button class="download-btn">📄 Download as PDF</button>
            </div>
        </div>

        <div class="doc-row">
            <span>Service Records Copy</span>
            <div class="doc-actions">
                <button class="view-btn">View</button>
                <button class="download-btn">📄 Download as PDF</button>
            </div>
        </div>

    </div>

</div>

    </div>

</div>

<script>
function openTab(tabId){
    document.querySelectorAll(".tab-content").forEach(t => t.classList.remove("active"));
    document.querySelectorAll(".tab-btn").forEach(b => b.classList.remove("active"));

    document.getElementById(tabId).classList.add("active");
    event.target.classList.add("active");
}
</script>

</body>
</html>