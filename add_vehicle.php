<?php
session_start();
include("includes/db.php");

if(!isset($_SESSION['user'])){
    header("Location: index.php");
    exit();
}

if($_SERVER["REQUEST_METHOD"]=="POST"){

    $user = $_SESSION['user'];

    $company = isset($_POST['company']) ? $_POST['company'] : '';
    $model = isset($_POST['model']) ? $_POST['model'] : '';
    $year = isset($_POST['year']) ? $_POST['year'] : '';
    $fuel = isset($_POST['fuel']) ? $_POST['fuel'] : '';
    $variant = isset($_POST['variant']) ? $_POST['variant'] : '';
    $license = $_POST['license'];
    $kms = $_POST['kms'];
    $ownership_date = $_POST['ownership_date'];
    $last_service = $_POST['last_service'];
    $kms_last_service = $_POST['kms_last_service'];

    // CHECK IF ID 3 EXISTS
    $check = $conn->query("SELECT id FROM vehicles WHERE id = 3");

    if($check->num_rows > 0){
        // UPDATE
        $conn->query("UPDATE vehicles SET
            user='$user',
            company='$company',
            model='$model',
            year='$year',
            fuel='$fuel',
            variant='$variant',
            license_no='$license',
            kms='$kms',
            kms_last_service='$kms_last_service',
            last_service='$last_service',
            ownership_date='$ownership_date'
            WHERE id=3
        ");
    } else {
        // INSERT WITH ID 3
        $conn->query("INSERT INTO vehicles 
        (id, user, company, model, year, fuel, variant, license_no, kms, last_service, ownership_date, kms_last_service)
        VALUES (3,'$user','$company','$model','$year','$fuel','$variant','$license','$kms','$last_service','$ownership_date','$kms_last_service')
        ");
    }

    // SUCCESS ALERT + REDIRECT
    echo "<script>
        alert('Vehicle Added Successfully');
        window.location.href='vehicles.php';
    </script>";
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Add Vehicle</title>
<link rel="stylesheet" href="assets/css/style.css">
</head>

<body>

<header class="main-header">
    <div class="header-content">
        <img src="assets/images/logo.png" alt="Logo" class="logo">
        <span class="divider">|</span>
        <h1>Auto<span>Care</span></h1>
    </div>
</header>

<div class="login-box">
<h2>Add Vehicle</h2>

<form method="POST">

<div class="form-group">
    <label>Car Company</label>
    <select id="company" name="company" required>
        <option value="">Select Company</option>
        <?php
        $res = $conn->query("SELECT * FROM companies");
        while($row = $res->fetch_assoc()){
            echo "<option value='".$row['name']."' data-id='".$row['id']."'>".$row['name']."</option>";
        }
        ?>
    </select>
</div>

<div class="form-group" id="model-group" style="display:none;">
    <label>Model</label>
    <select id="model" name="model"></select>
</div>

<div class="form-group" id="year-group" style="display:none;">
    <label>Year</label>
    <select id="year" name="year"></select>
</div>

<div class="form-group" id="fuel-group" style="display:none;">
    <label>Fuel Type</label>
    <select id="fuel" name="fuel"></select>
</div>

<div class="form-group" id="variant-group" style="display:none;">
    <label>Variant</label>
    <select id="variant" name="variant"></select>
</div>

<!-- TEXT FIELDS -->
<div id="extra-fields" style="display:none;">

    <div class="form-group">
        <label>License Number</label>
        <input type="text" name="license" required>
    </div>

    <div class="form-group">
        <label>KMs Driven</label>
        <input type="number" name="kms" required>
    </div>
    <div class="form-group">
        <label>KMs at Last Service</label>
        <input type="number" name="kms_last_service" required>
    </div>

    <div class="form-group">
        <label>Ownership Date</label>
        <input type="date" name="ownership_date" required>
    </div>

    <div class="form-group">
        <label>Last Service Date</label>
        <input type="date" name="last_service" required>
    </div>

</div>

<button type="submit">Add Vehicle</button>
</form>
</div>
<br><br><br><br><br><br><br>
<footer>
    © 2026 AutoCare | Designed by AutoCare Team
</footer>

<script src="assets/js/script.js"></script>

</body>
</html>