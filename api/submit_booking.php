<?php

include '../connection.php';

$date = $_POST['date'];
$name = $_POST['name'];
$ref_id = $_POST['ref_id'];
$contact = $_POST['contact'];
$startTime = $_POST['startTime'];
$endTime = $_POST['endTime'];
$due = $_POST['due'];
$total = $_POST['total'];

$customers = "INSERT INTO `customers`(`name`, `phone`) VALUES ($name, $contact)";
$user_insert_qry = mysqli_query($conn, $str);
$last_id = mysqli_insert_id($conn);
if($user_insert_qry){
    echo "Successfully inserted to cutomers table!\n".$last_id;
}
?>