<?php
include("../includes/db.php");

$company_id = $_GET['company_id'];

$res = $conn->query("SELECT * FROM models WHERE company_id='$company_id'");

echo '<option value="">Select Model</option>';

if($res->num_rows > 0){
    while($row = $res->fetch_assoc()){
        echo '<option value="'.$row['name'].'" data-id="'.$row['id'].'">'.$row['name'].'</option>';
    }
}
?>