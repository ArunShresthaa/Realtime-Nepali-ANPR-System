<?php
include('../../Includes/dbcon.php');


if(isset($_POST['view'])){

if($_POST["view"] != '')
{
    $update_query = "UPDATE hitlogs SET is_new = 'no' WHERE is_new = 'yes'";
    mysqli_query($conn, $update_query);
}

$query = "SELECT hitlogs.id,records.plate_no,camera.location FROM hitlogs INNER JOIN bolo ON hitlogs.record_id = bolo.id INNER JOIN records ON bolo.record_id = records.Id INNER JOIN camera ON hitlogs.camera_id = camera.id WHERE status = 'unread' ORDER BY hitlogs.created_at DESC";
$result = mysqli_query($conn, $query);
$output = '';
$notification_content = '';
if(mysqli_num_rows($result) > 0)
{
    $row = mysqli_fetch_array($result);
    $output .= '<a class="dropdown-item" href="./hitDetail.php?id=' . urlencode($row['id']) . '">' . $row['plate_no'] . ': ' . $row['location'] . '</a>';
    $notification_content = 'Plate No: '.$row['plate_no'].' has been detected at '.$row['location'];

 while($row = mysqli_fetch_array($result))
 {
    // $output .='<a class="dropdown-item" href="./hitDetail.php">'. $row['plate_no'] .': ' . $row['location'] . '</a>';
    $output .= '<a class="dropdown-item" href="./hitDetail.php?id=' . urlencode($row['id']) . '">' . $row['plate_no'] . ': ' . $row['location'] . '</a>';


 }
}
else{
     $output .= '
     <li><a href="#" class="text-bold text-italic">No Notifications.</a></li>';
}



$status_query = "SELECT * FROM hitlogs WHERE is_new = 'yes'";
$result_query = mysqli_query($conn, $status_query);
$count = mysqli_num_rows($result_query);
$data = array(
    'notification' => $output,
    'unseen_notification'  => $count,
    'notification_content' => $notification_content
);

echo json_encode($data);

}

?>