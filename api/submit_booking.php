<?php

include '../connection.php';

$date = $_POST['data'];
$name = $_POST['name'];
$contact = $_POST['contact'];
$startTime = $_POST['startTime'];
$endTime = $_POST['endTime'];

$user_insert = "INSERT INTO `customers`(`name`, `phone`) VALUES ($name, $contact)";
$user_insert_qry = mysqli_query($conn, $str);
if ($)
// echo $date.'<br>'.$name.'<br>'.$contact.'<br>'.$startTime.'<br>'.$endTime;
// $str = "UPDATE booking SET status = 'completed' WHERE id = $booking_id";
// $result = mysqli_query($conn, $str);

if(1){
    echo "success";
}

?>