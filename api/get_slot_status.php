<?php
// Get slot status API
include '../connection.php';

// data from API response
$date = (string) $_POST['date'];

// get starting slot id
$qry = "SELECT customers.name as cus_name,
        start_slot.start_time as start_time, 
        end_slot.end_time as end_time
        FROM booking 
        LEFT JOIN customers ON booking.user_id = customers.id
        LEFT JOIN slot_management AS start_slot ON booking.start_slot_id = start_slot.id
        LEFT JOIN slot_management AS end_slot ON booking.end_slot_id = end_slot.id
        WHERE booking.date = '$date'";

$sql = mysqli_query($conn, $qry);
$data = [];
$i = 0;

if($sql) {
    while($row = mysqli_fetch_array($sql))
    {
        $name = $row['cus_name'];
        $start_time = $row['start_time'];
        $end_time = $row['end_time'];
        
        $data[$i]['name'] = $name;
        $data[$i]['start'] = $start_time;
        $data[$i]['end'] = $end_time;
        $i++;
    }
    echo json_encode(array("data" => $data));
}
else {
    echo json_encode(array("err" => mysqli_error()));
}
mysqli_close($conn);

?>