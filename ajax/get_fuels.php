<?php
include("../includes/db.php");

$res = $conn->query("SELECT * FROM fuels");

echo '<option value="">Select Fuel</option>';

while($row = $res->fetch_assoc()){
    echo '<option value="'.$row['name'].'" data-id="'.$row['id'].'">'.$row['name'].'</option>';
}
?>