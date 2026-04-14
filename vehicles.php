<?php
session_start();
include("includes/db.php");

if(!isset($_SESSION['user'])){
    header("Location: index.php");
    exit();
}

// FETCH VEHICLES
$v1 = $conn->query("SELECT * FROM vehicles WHERE id=3")->fetch_assoc();
$v2 = $conn->query("SELECT * FROM vehicles WHERE id=1")->fetch_assoc();
$v3 = $conn->query("SELECT * FROM vehicles WHERE id=2")->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
<title>Your Vehicles</title>
<link rel="stylesheet" href="assets/css/style.css">
</head>

<body>

<div class="header-content header-flex">

    <div class="header-left">
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

<div class="vehicle-container-new">

<!-- BUBBLE 1 (CLICKABLE) -->
<a href="vehicle_details.php?id=3" class="vehicle-card-new">
    <img src="assets/images/car1.png">
    <div>
        <h3><?= $v1['company'] . " " . $v1['model'] ?></h3>
        <p><?= $v1['license_no'] ?></p>
    </div>
</a>

<!-- BUBBLE 2 (DUMMY) -->
<div class="vehicle-card-new vehicle-card-dummy">
    <img src="assets/images/car2.png">
    <div>
        <h3><?= $v2['company'] . " " . $v2['model'] ?></h3>
        <p><?= $v2['license_no'] ?></p>
    </div>
</div>

<!-- BUBBLE 3 (DUMMY) -->
<div class="vehicle-card-new vehicle-card-dummy">
    <img src="assets/images/car3.png">
    <div>
        <h3><?= $v3['company'] . " " . $v3['model'] ?></h3>
        <p><?= $v3['license_no'] ?></p>
    </div>
</div>

</div>
<div class="add-vehicle-wrapper">
    <div class="vehicle-card-new add-vehicle-card">
        <div class="plus-icon">+</div>
        <h3>Add Another Vehicle</h3>
    </div>
</div>

<footer>
    © 2026 AutoCare | Designed by AutoCare Team
</footer>

<script>
// DROPDOWN
document.getElementById("profileBtn").onclick = function(){
    let d = document.getElementById("dropdown");
    d.style.display = d.style.display === "block" ? "none" : "block";
};
</script>

</body>
</html>