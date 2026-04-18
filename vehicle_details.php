<?php
session_start();
include("includes/db.php");

if(!isset($_SESSION['user'])){
    header("Location: index.php");
    exit();
}


// GET ID
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// FETCH VEHICLE
$result = $conn->query("SELECT * FROM vehicles WHERE id = $id");

if($result->num_rows > 0){
    $vehicle = $result->fetch_assoc();
} else {
    echo "Vehicle not found";
    exit();
}
$kms = (int)$vehicle['kms'];
$last_service = new DateTime($vehicle['last_service']);
$ownership = new DateTime($vehicle['ownership_date']);
$today = new DateTime();
$kms_last_service = (int)$vehicle['kms_last_service'];

// ===== TIME =====
$days_since_service = $today->diff($last_service)->days;
$months_since_service = ($today->diff($last_service)->y * 12) + $today->diff($last_service)->m;

// ===== SERVICE RULE =====
$service_interval_km = 10000;
$next_service_km = $kms_last_service + 5000;

$next_service_date = clone $last_service;
$next_service_date->modify("+6 months");

// ===== REALISTIC USAGE =====

$kms_since_service = $kms - $kms_last_service;
$monthly_km = $months_since_service > 0 ? $kms / $months_since_service : 0;

$usage_percent = ($kms_since_service / $service_interval_km) * 100;

// ===== ENGINE OIL =====
if($usage_percent < 50) {
    $oil_status = "Good";
} elseif($usage_percent < 80) {
    $oil_status = "Degrading";
} else {
    $oil_status = "Poor";
}

// ===== BRAKES =====
$brake_usage = ($kms / 35000) * 100;

if($brake_usage < 50) $brake_status = "Good";
elseif($brake_usage < 80) $brake_status = "Moderate";
else $brake_status = "Worn";

// ===== TYRES =====
$tyre_years = $today->diff($ownership)->y;
$tyre_usage = ($kms / 40000) * 100;

if($tyre_years >= 3 || $tyre_usage > 70) {
    $tyre_status = "Replace Soon";
} else {
    $tyre_status = "Good";
}

// ===== BATTERY =====
if($tyre_years < 2) $battery = "Healthy";
elseif($tyre_years < 3) $battery = "Weak";
else $battery = "Risky";

// ===== SERVICE URGENCY =====
if($usage_percent > 100) $urgency = "Immediate";
elseif($usage_percent > 80) $urgency = "Plan Soon";
else $urgency = "Low";

// ===== ALERTS =====
$alerts = [];

if($usage_percent > 100) $alerts[] = "Service overdue";
if($battery == "Risky") $alerts[] = "Battery may fail soon";
if($tyre_status == "Replace Soon") $alerts[] = "Tyres need attention";

function getStatusClass($status){
    $status = strtolower($status);

    if(in_array($status, ["good", "healthy", "low"])){
        return "status-good";
    }
    elseif(in_array($status, ["moderate", "degrading", "weak", "plan soon"])){
        return "status-moderate";
    }
    else{
        return "status-bad";
    }
}
$usageClass = ($usage_percent < 50) ? "status-good" : (($usage_percent < 80) ? "status-moderate" : "status-bad");
$ownershipDate = new DateTime($vehicle['ownership_date']);

// RC (15 years)
$rc_expiry = (clone $ownershipDate)->modify("+15 years");

// Insurance (1 year)
$insurance_expiry = (clone $ownershipDate)->modify("+1 year");

// PUC (6 months)
$puc_expiry = (clone $ownershipDate)->modify("+6 months");

// Road Tax (15 years)
$tax_expiry = (clone $ownershipDate)->modify("+15 years");

// Driving License (20 years)
$dl_expiry = (clone $ownershipDate)->modify("+20 years");

// Permit (5 years)
$permit_expiry = (clone $ownershipDate)->modify("+5 years");

// Fastag balance (average Indian balance)
$fastag_balance = 1500;

// TODAY
$today = new DateTime();

// STATUS FUNCTION
function getDocStatus($expiry, $today){
    $diff = $today->diff($expiry)->days;
    if($expiry < $today){
        return "status-bad";
    } elseif($diff < 60){
        return "status-moderate";
    } else {
        return "status-good";
    }
}
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
    <div class="header-left" onclick="window.location.href='home.php'" style="cursor:pointer;">
        <img src="assets/images/logo.png" class="logo">
        <span class="divider">|</span>
        <h1>Auto<span>Care</span></h1>
    </div>
    <div class="header-right">
        <img src="assets/images/profile.png" class="profile-icon-new" id="profileBtn">

        <div class="dropdown-new" id="dropdown">
            <a href="logout.php">
                <img src="assets/images/logout.png"> Logout
            </a>
        </div>
    </div>
</div>

<!-- MAIN CONTAINER -->
<div class="details-container">

    <!-- LEFT PANEL -->
<div class="left-panel">

    <img src="assets/images/car1.png" class="car-img">

    <h2><?= $vehicle['company'] . " " . $vehicle['model'] ?></h2>
    <p><?= $vehicle['license_no'] ?></p>

    <!-- BACK BUTTON -->
    <div class="back-btn-container">
        <button onclick="window.location.href='vehicles.php'" class="back-btn">
            ← BACK TO VEHICLES
        </button>
    </div>

</div>
    <!-- RIGHT PANEL -->
    <div class="right-panel">

        <!-- TABS -->
        <div class="tabs">
            <button class="tab-btn active" onclick="openTab('details')">Vehicle Details</button>
            <button class="tab-btn" onclick="openTab('service')">Service Vehicle</button>
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
        <p><b>Variant:</b> <?= $vehicle['variant'] ?></p>
        <p><b>Year:</b> <?= $vehicle['year'] ?></p>
        <p><b>Colour:</b> White</p>
        <p><b>KMs Driven:</b> <?= $vehicle['kms'] ?></p>

        <p><b>Engine Capacity:</b> 1497 cc</p>
        <p><b>No. of Cylinders:</b> 4</p>
        <p><b>Turbo:</b> Yes</p>
        <p><b>Power:</b> 113 BHP</p>
        <p><b>Torque:</b> 144 Nm</p>

        <p><b>Fuel:</b> <?= $vehicle['fuel'] ?></p>
        <p><b>Mileage:</b> 17 km/l</p>
        <p><b>Fuel Tank Capacity:</b> 50 Litres</p>
        <p><b>Transmission:</b> Automatic</p>
        <p><b>Gearbox:</b> 6-Speed iVT</p>

    </div>

    <!-- RIGHT SIDE -->
    <div class="details-col">
        <p><b>Drive Type:</b> Front Wheel Drive</p>
        <p><b>Seating Capacity:</b> 5</p>

        <p><b>Chassis Number:</b> ABC123XYZ789</p>
        <p><b>Engine Number:</b> ENG456789</p>

        <p><b>Front Brake Type:</b> Disc</p>
        <p><b>Rear Brake Type:</b> Disc</p>
        <p><b>Front Suspension:</b> MacPherson Strut</p>
        <p><b>Rear Suspension:</b> Rear Twist Beam</p>
        <p><b>Steering Type:</b> Electric</p>

        <p><b>Alloy Wheel (Front):</b> 18 Inch</p>
        <p><b>Alloy Wheel (Rear):</b> 18 Inch</p>

        <p><b>Length:</b> 4330 mm</p>
        <p><b>Width:</b> 1790 mm</p>
        <p><b>Height:</b> 1635 mm</p>
        <p><b>Wheelbase:</b> 2610 mm</p>
        <p><b>Boot Space:</b> 433 Litres</p>
    </div>

</div>

</div>

     <div class="tab-content" id="service">

    <!-- ================= REAL DATA ================= -->
    <h3>Service Overview</h3>

    <div class="service-grid">

        <div class="service-col">
            <p><b>Last Service:</b> <?= $last_service->format("d-m-Y") ?></p>
            <p><b>KMs at Last Service:</b> <?= $kms_last_service ?> km</p>
            <p><b>Total KMs:</b> <?= $kms ?> km</p>
            <p><b>Time Since Service:</b> <?= $months_since_service ?> months</p>
            <p><b>Days Since Service:</b> <?= $days_since_service ?> days</p>
            <p><b>Brake Installed:</b> <?= $ownership->format("d-m-Y") ?></p>
            
            
        </div>

        <div class="service-col">
            <p><b>Next Service:</b> <?= $next_service_km ?> km OR <?= $next_service_date->format("d-m-Y") ?></p>
            <p><b>KMs Since Last Service:</b> <?= $kms_since_service ?> km</p>
            <p><b>KMs on Tyres:</b> <?= $kms ?> km</p>
            <p><b>Ownership Date:</b> <?= $ownership->format("d-m-Y") ?></p>
            <p><b>Engine Oil Changed:</b> <?= $last_service->format("d-m-Y") ?></p>
            <p><b>Tyres Installed:</b> <?= $ownership->format("d-m-Y") ?></p>
        </div>

    </div>

    <!-- ================= SMART INSIGHTS ================= -->
    <h3 style="margin-top:30px;">Smart Insights</h3>

    <div class="service-grid">

        <div class="service-col">
<p><b>Engine Oil:</b> 
<span class="<?= getStatusClass($oil_status) ?>">
    <?= $oil_status ?>
</span>
</p>
<p><b>Brake Condition:</b> 
<span class="<?= getStatusClass($brake_status) ?>">
    <?= $brake_status ?>
</span>
</p>

<p><b>Tyre Health:</b> 
<span class="<?= getStatusClass($tyre_status) ?>">
    <?= $tyre_status ?>
</span>
</p>

<p><b>Battery:</b> 
<span class="<?= getStatusClass($battery) ?>">
    <?= $battery ?>
</span>
</p>


        </div>

        <div class="service-col">
            <p><b>Driving Load:</b> <?= round($monthly_km) ?> km/month</p>
           <p><b>Usage %:</b> 
<span class="<?= $usageClass ?>">
    <?= round($usage_percent) ?>%
</span>
</p>
<p><b>Service Urgency:</b> 
<span class="<?= getStatusClass($urgency) ?>">
    <?= $urgency ?>
</span>
</p>
        </div>

    </div>

    <!-- ALERTS -->
    <div style="margin-top:20px;">
        <b>Alerts:</b>
        <ul>
            <?php
            if(empty($alerts)){
                echo "<li>No issues detected</li>";
            } else {
                foreach($alerts as $a){
                    echo "<li class='status-bad'>⚠ $a</li>";
                }
            }
            ?>
        </ul>
    </div>

    <!-- BUTTON -->
    <div style="text-align:center; margin-top:25px;">
        <button class="action-btn" onclick="window.location.href='book_service.php?id=<?= $id ?>'">
            Book Service
        </button>
    </div>

</div>

<div class="tab-content" id="renewal">

    <div class="renewal-grid">

        <!-- RC -->
        <div class="renewal-card">
            <div class="renewal-info">
                <h4>Registration Certificate</h4>

                <div class="renewal-row single-line">
                    <div class="detail-block">
                        <span>Issued</span>
                        <span><?= $ownershipDate->format("d-m-Y") ?></span>
                    </div>

                    <div class="detail-block">
                        <span>Expires</span>
                        <span class="<?= getDocStatus($rc_expiry, $today) ?>">
                            <?= $rc_expiry->format("d-m-Y") ?>
                        </span>
                    </div>
                </div>
            </div>
            <br>
            <button class="renew-btn">Renew</button>
        </div>

        <!-- Insurance -->
        <div class="renewal-card">
            <div class="renewal-info">
                <h4>Insurance</h4>

                <div class="renewal-row single-line">
                    <div class="detail-block">
                        <span>Issued</span>
                        <span><?= $ownershipDate->format("d-m-Y") ?></span>
                    </div>

                    <div class="detail-block">
                        <span>Expires</span>
                        <span class="<?= getDocStatus($insurance_expiry, $today) ?>">
                            <?= $insurance_expiry->format("d-m-Y") ?>
                        </span>
                    </div>
                </div>
            </div>
            <br>
            <button class="renew-btn">Renew</button>
        </div>

        <!-- PUC -->
        <div class="renewal-card">
            <div class="renewal-info">
                <h4>Pollution Certificate (PUC)</h4>

                <div class="renewal-row single-line">
                    <div class="detail-block">
                        <span>Issued</span>
                        <span><?= $ownershipDate->format("d-m-Y") ?></span>
                    </div>

                    <div class="detail-block">
                        <span>Expires</span>
                        <span class="<?= getDocStatus($puc_expiry, $today) ?>">
                            <?= $puc_expiry->format("d-m-Y") ?>
                        </span>
                    </div>
                </div>
            </div>
            <br>
            <button class="renew-btn">Renew</button>
        </div>

        <!-- Road Tax -->
        <div class="renewal-card">
            <div class="renewal-info">
                <h4>Road Tax</h4>

                <div class="renewal-row single-line">
                    <div class="detail-block">
                        <span>Issued</span>
                        <span><?= $ownershipDate->format("d-m-Y") ?></span>
                    </div>

                    <div class="detail-block">
                        <span>Expires</span>
                        <span class="<?= getDocStatus($tax_expiry, $today) ?>">
                            <?= $tax_expiry->format("d-m-Y") ?>
                        </span>
                    </div>
                </div>
            </div>
            <br>
            <button class="renew-btn">Renew</button>
        </div>

        <!-- Driving License -->
        <div class="renewal-card">
            <div class="renewal-info">
                <h4>Driving License</h4>

                <div class="renewal-row single-line">
                    <div class="detail-block">
                        <span>Issued</span>
                        <span><?= $ownershipDate->format("d-m-Y") ?></span>
                    </div>

                    <div class="detail-block">
                        <span>Expires</span>
                        <span class="<?= getDocStatus($dl_expiry, $today) ?>">
                            <?= $dl_expiry->format("d-m-Y") ?>
                        </span>
                    </div>
                </div>
            </div>
            <br>
            <button class="renew-btn">Renew</button>
        </div>

        <!-- Permit -->
        <div class="renewal-card">
            <div class="renewal-info">
                <h4>Vehicle Permit</h4>

                <div class="renewal-row single-line">
                    <div class="detail-block">
                        <span>Issued</span>
                        <span><?= $ownershipDate->format("d-m-Y") ?></span>
                    </div>

                    <div class="detail-block">
                        <span>Expires</span>
                        <span class="<?= getDocStatus($permit_expiry, $today) ?>">
                            <?= $permit_expiry->format("d-m-Y") ?>
                        </span>
                    </div>
                </div>
            </div>
            <br>
            <button class="renew-btn">Renew</button>
        </div>

        <!-- FASTag -->
        <div class="renewal-card">
            <div class="renewal-info">
                <h4>FASTag</h4>

                <div class="renewal-row single-line">
                    <div class="detail-block">
                        <span>Balance</span>
                        <span class="status-good">₹<?= $fastag_balance ?></span>
                    </div>

                    <div class="detail-block">
                        <span>Status</span>
                        <span class="status-good">Active</span>
                    </div>
                </div>
            </div>
            <br>
            <button class="renew-btn">Recharge</button>
        </div>
        <div class="renewal-card add-doc-card">
            <h3>+ Add Document</h3>
        </div>

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
        <div class="doc-row add-doc">
            <span>+ Add Another Document</span>
        </div>
    </div>

</div>

    </div>

</div>
<br><br><br>
<footer>
    © 2026 AutoCare | Designed by AutoCare Team
</footer>
<script>
function openTab(tabId){
    document.querySelectorAll(".tab-content").forEach(t => t.classList.remove("active"));
    document.querySelectorAll(".tab-btn").forEach(b => b.classList.remove("active"));

    document.getElementById(tabId).classList.add("active");
    event.target.classList.add("active");
}
const profileBtn = document.getElementById("profileBtn");
const dropdown = document.getElementById("dropdown");

// toggle on click
profileBtn.addEventListener("click", function (e) {
    e.stopPropagation(); // prevent closing immediately
    dropdown.style.display = (dropdown.style.display === "block") ? "none" : "block";
});

// close when clicking outside
document.addEventListener("click", function () {
    dropdown.style.display = "none";
});
</script>

</body>
</html>