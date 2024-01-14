<?php

include '../connection.php';

$date = $_POST['data'];
$name = $_POST['name'];
$contact = $_POST['contact'];
$startTime = $_POST['startTime'];
$endTime = $_POST['endTime'];
$admin = $_POST['admin'];

$user_insert = "INSERT INTO `customers`(`name`, `phone`) VALUES ($name, $contact)";
$user_insert_qry = mysqli_query($conn, $str);
// echo $date.'<br>'.$name.'<br>'.$contact.'<br>'.$startTime.'<br>'.$endTime;
echo $date.'<br>'.$name.'<br>'.$contact.'<br>'.$startTime.'<br>'.$endTime.'<br>'.$admin;
// $str = "UPDATE booking SET status = 'completed' WHERE id = $booking_id";
// $result = mysqli_query($conn, $str);

if(1){
    echo "success";
}

?>