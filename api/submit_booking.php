<?php
// Booking API

include '../connection.php';

// data from API response
$name = $_POST['name'];
$ref_id = $_POST['ref_id'];
$contact = $_POST['contact'];
$startTime = $_POST['startTime'];
$endTime = $_POST['endTime'];
$advance = $_POST['advance'];
$total = $_POST['total'];
$date = $_POST['date'];
$method = $_POST['method'];
$due = $total - $advance;
$status = ($due == 0) ? 1 : 0;

// get starting slot id
$qry1 = "SELECT `id` FROM `slot_management` WHERE `start_time`='$startTime'";
$sql1 = mysqli_query($conn, $qry1);
$row1 = mysqli_fetch_array($sql1);
$sTimeId = $row1['id'];

// get ending slot id
$qry2 = "SELECT `id` FROM `slot_management` WHERE `end_time`='$endTime'";
$sql2 = mysqli_query($conn, $qry2);
$row2 = mysqli_fetch_array($sql2);
$fTimeId = $row2['id'];

// Insert into customer table
$customer = "INSERT INTO `customers`(`name`, `phone`) VALUES ('$name', '$contact')";

if(mysqli_query($conn, $customer)) {
    // get user id from most recent table
    $user_id = mysqli_insert_id($conn);

    // Insert into transaction table
    $transaction = "INSERT INTO `transaction`(`user_id`, `method`, `advance`, `due`, `cash`, `total`, `status`) VALUES ($user_id, '$method', $advance, $due, 0, $total, $status)";

    if(mysqli_query($conn, $transaction)) {

        // get user id from most recent table
        $transaction_id = mysqli_insert_id($conn);
        
        for($i = $sTimeId; $i <= $fTimeId; $i++) {
            // Insert into slot_live table
            $slot_live = "INSERT INTO `slot_live`(`date`, `slot_id`, `status`) VALUES ('$date', $i, 1)";
            mysqli_query($conn, $slot_live);        
        }
        
        // Insert into transaction table
        $booking = "INSERT INTO `booking`(`date`, `user_id`, `transaction_id`, `start_slot_id`, `end_slot_id`, `reference_id`, `status`) VALUES ('$date', $user_id, $transaction_id, $sTimeId, $fTimeId, $ref_id, 0)";

        if(mysqli_query($conn, $booking)) {
            echo 1;
        }        
        else {
            echo 0;
            // echo json_encode(array("err" => mysqli_error()));
        }
    }
    else {
        echo 0;
        // echo json_encode(array("err" => mysqli_error()));
    }
}
else {
    echo 0;
    // echo json_encode(array("err" => mysqli_error()));
}

mysqli_close($conn);

?>