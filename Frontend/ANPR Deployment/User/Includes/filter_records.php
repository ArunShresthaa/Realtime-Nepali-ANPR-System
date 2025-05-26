<?php
include('../../Includes/dbcon.php');

// Get filter values
$reason = $_POST['reason'];
$vehicleType = $_POST['vehicle_type'];
$vehicleOwnership = $_POST['vehicle_ownership'];
$province = $_POST['province'];
$district = $_POST['district'];

// Construct the SQL query based on the selected filters
$query = "SELECT * FROM records WHERE 1=1";

if (!empty($reason)) {
    $query .= " AND reason = '$reason'";
}

if (!empty($vehicleType)) {
    $query .= " AND vehicle_type = '$vehicleType'";
}

if (!empty($vehicleOwnership)) {
    $query .= " AND vehicle_ownership = '$vehicleOwnership'";
}

if (!empty($province)) {
    $query .= " AND province = '$province'";
}

if (!empty($district)) {
    $query .= " AND district = '$district'";
}

// Execute the query and fetch filtered records
$rs = $conn->query($query);
$num = $rs->num_rows;

if ($num > 0) {
    $sn = 0;
    while ($rows = $rs->fetch_assoc()) {
        $sn = $sn + 1;
        echo "
                                <tr>
                                    <td>".$sn."</td>
                                    <td>".$rows['plate_no']."</td>
                                    <td>".$rows['reason']."</td>
                                    <td>".$rows['vehicle_type']."</td>
                                    <td>".$rows['vehicle_ownership']."</td>
                                    <td>".$rows['province']."</td>
                                    <td>".$rows['district']."</td>
                                    <td>".$rows['location']."</td>
                                    <td>".$rows['description']."</td>
                                    <td>".$rows['remarks']."</td>
                                    <td>".$rows['created_at']."</td>
                                    <td>".$rows['updated_at']."</td>
                                </tr>";
    }
} else {
    echo "<tr><td colspan='3'>No matching records found!</td></tr>";
}
?>
