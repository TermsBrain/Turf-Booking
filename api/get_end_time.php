<?php
// Get end time API
include '../connection.php';
// header('Access-Control-Allow-Origin: *');

if(isset($_GET['date'])) {
    $date = (string) $_GET['date'];
    
    // get starting time
    $query = "SELECT start_slot.end_time as end_time
                FROM booking 
                LEFT JOIN slot_management AS start_slot ON booking.start_slot_id = start_slot.id
                LEFT JOIN slot_management AS end_slot ON booking.end_slot_id = end_slot.id
                WHERE booking.date = '$date'";
    $result = mysqli_query($conn, $query);
    $data = [];
    $i = 0;
    while($row = mysqli_fetch_array($result)) {
        $data[$i] = $row['end_time'];
        $i+=1;
    }
    echo json_encode($data);
}
?>