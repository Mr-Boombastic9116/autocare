<?php
session_start();
include("includes/db.php");

if(!isset($_SESSION['user'])){
    header("Location: index.php");
    exit();
}

$booking_id = $_GET['id'] ?? null;

if(!$booking_id){
    $user = $_SESSION['user'];

    $res = $conn->query("
        SELECT b.*, v.company, v.model, v.license_no
        FROM bookings b
        LEFT JOIN vehicles v ON b.vehicle_id = v.id
        WHERE b.user='$user'
        ORDER BY b.id DESC
        LIMIT 1
    ");

} else {

    $res = $conn->query("
        SELECT b.*, v.company, v.model, v.license_no
        FROM bookings b
        LEFT JOIN vehicles v ON b.vehicle_id = v.id
        WHERE b.id='$booking_id'
    ");
}

$data = $res->fetch_assoc();

// FIX: split services string into array
$services = [];
if(!empty($data['services'])){
    $services = explode(",", $data['services']);
}
?>
<style>

/* MAIN BOX */
.confirm-box {
    width: 500px;
    margin: 60px auto;
    background: white;
    padding: 30px;
    border-radius: 12px;
    box-shadow: 0px 4px 15px rgba(0,0,0,0.2);
    text-align: center;
}

/* SUCCESS ICON */
.success-icon {
    font-size: 50px;
    color: green;
}

/* TITLE */
.confirm-box h2 {
    margin-top: 10px;
}

/* BOOKING ID */
.booking-id {
    margin-top: 10px;
    font-weight: bold;
    color: #dda807;
}

/* DETAILS */
.details {
    text-align: left;
    margin-top: 20px;
    font-size: 14px;
}

.details p {
    margin: 6px 0;
}

/* SERVICES LIST */
.services-list {
    margin-top: 10px;
    padding-left: 15px;
}

/* TOTAL */
.total {
    margin-top: 15px;
    font-size: 18px;
    font-weight: bold;
}

/* BUTTON */
.home-btn {
    margin-top: 20px;
    padding: 12px;
    width: 100%;
    background-color: #FFC107;
    border: none;
    font-weight: bold;
    border-radius: 6px;
    cursor: pointer;
}

.home-btn:hover {
    background-color: #e0a800;
}

</style>
</head>
<link rel="stylesheet" href="assets/css/style.css">
<body>

<!-- HEADER -->
<div class="header-content header-flex">
    <div class="header-left" onclick="window.location.href='home.php'" style="cursor:pointer;">
        <img src="assets/images/logo.png" class="logo">
        <span class="divider">|</span>
        <h1>Auto<span>Care</span></h1>
    </div>
</div>

<div class="confirm-box">

    <div class="success-icon">✔</div>

    <h2>Booking Confirmed</h2>

    <div class="booking-id">
    Booking ID: #<?php echo $data['id']; ?>
</div>

    <div class="details">
        <p><strong>Vehicle:</strong> <?php echo $data['company']." ".$data['model']; ?></p>
        <p><strong>License:</strong> <?php echo $data['license_no']; ?></p>
        <p><strong>Date:</strong> 
<?php 
if(!empty($data['service_date'])){
    $date = new DateTime($data['service_date']);
    echo $date->format("d-m-Y");
} else {
    echo "N/A";
}
?>
</p>
<p><strong>Time Slot:</strong> 
<?php 
if(!empty($data['time_slot'])){

    $parts = explode("-", $data['time_slot']);

    $start = (int)$parts[0];
    $end   = (int)$parts[1];

    // Convert to 12-hour format
    $startFormatted = date("g:i A", strtotime($start . ":00"));
    $endFormatted   = date("g:i A", strtotime($end . ":00"));

    echo $startFormatted . " - " . $endFormatted;

} else {
    echo "N/A";
}
?>
</p>

        <p><strong>Services Selected:</strong></p>
<ul class="services-list">
<?php 
if(!empty($services)){
    foreach($services as $s){
        echo "<li>".trim($s)."</li>";
    }
} else {
    echo "<li>No extra services</li>";
}
?>
</ul>

        <?php if(!empty($data['special_request'])){ ?>
    <p><strong>Special Request:</strong> <?php echo $data['special_request']; ?></p>
<?php } ?>

        <div class="total">
    Total Estimated Cost: ₹<?php echo $data['total']; ?>
</div>

        <p><strong>Advance Paid:</strong> ₹<?php echo $data['advance']; ?></p>
        <p><strong>Status:</strong> <?php echo $data['status']; ?></p>
    </div>

    <button class="home-btn" onclick="window.location.href='vehicles.php'">
        Back to Dashboard
    </button>

</div>
<br><br><br>
<footer>
    © 2026 AutoCare | Designed by AutoCare Team
</footer>
</body>
</html>