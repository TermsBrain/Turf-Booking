<?php

include '../connection.php';

$date = $_POST['data'];
$name = $_POST['name'];
$contact = $_POST['contact'];
$startTime = $_POST['startTime'];
$endTime = $_POST['endTime'];

// $str = "UPDATE booking SET status = 'completed' WHERE id = $booking_id";
// $result = mysqli_query($conn, $str);
echo $date.'<br>'.$name.'<br>'.$contact.'<br>'.$startTime.'<br>'.$endTime;

if(1){
    echo "success";
}

?>