<?php
include '../connection.php';

$name = $_POST['name'];
$ref_id = $_POST['ref_id'];
$contact = $_POST['contact'];
$startTime = $_POST['startTime'];
$endTime = $_POST['endTime'];
$due = $_POST['due'];
$total = $_POST['total'];
$date = $_POST['date'];
$method = $_POST['method'];

$customers = "INSERT INTO `customers`(`name`, `phone`) VALUES ($name, $contact)";
$user_insert_qry = mysqli_query($conn, $str);
$last_id = mysqli_insert_id($conn);
if($user_insert_qry){
    echo "Successfully inserted to cutomers table! ID: ".$last_id;
}

?>