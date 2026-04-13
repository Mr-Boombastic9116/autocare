<?php
include("../includes/db.php");

$res = $conn->query("SELECT * FROM years");

echo '<option value="">Select Year</option>';

while($row = $res->fetch_assoc()){
    echo '<option value="'.$row['year'].'" data-id="'.$row['id'].'">'.$row['year'].'</option>';
}
?>