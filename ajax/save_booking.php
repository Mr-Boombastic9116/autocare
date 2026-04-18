<?php
session_start();
include("../includes/db.php");

header('Content-Type: application/json');

if(!isset($_SESSION['user'])){
    echo json_encode(["status"=>"error"]);
    exit();
}

$user = $_SESSION['user'];

$date     = $_POST['date'] ?? '';
$time     = $_POST['time'] ?? '';
$services = $_POST['services'] ?? '';
$notes    = $_POST['notes'] ?? '';
$total    = $_POST['total'] ?? 0;

$vehicle_id = 3;   // ✅ HARDCODED
$advance = 500;
$status  = "Confirmed";

$sql = "INSERT INTO bookings 
(user, vehicle_id, service_date, time_slot, services, special_request, total, advance, status)
VALUES 
('$user','$vehicle_id','$date','$time','$services','$notes','$total','$advance','$status')";

if($conn->query($sql)){
    echo json_encode([
        "status"=>"success",
        "booking_id"=>$conn->insert_id
    ]);
} else {
    echo json_encode([
        "status"=>"error",
        "msg"=>$conn->error
    ]);
}
?>