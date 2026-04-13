<?php
include("../includes/db.php");

$model_id = $_GET['model_id'];
$year_id = $_GET['year_id'];
$fuel_id = $_GET['fuel_id'];

$res = $conn->query("SELECT * FROM variants 
WHERE model_id='$model_id' 
AND year_id='$year_id' 
AND fuel_id='$fuel_id'");

echo '<option value="">Select Variant</option>';

if($res->num_rows > 0){
    while($row = $res->fetch_assoc()){
        echo '<option value="'.$row['name'].'">'.$row['name'].'</option>';
    }
}
?>