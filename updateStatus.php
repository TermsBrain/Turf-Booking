<?php
// updateStatus.php

session_start();

// Check if the user is logged in
if (!isset($_SESSION['name']) || !isset($_SESSION['role'])) {
    echo 'Unauthorized access';
    exit;
}

// Include the database connection
include 'connection.php';

// Check if the request is a POST request
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get user ID and status from the POST data
    $userId = $_POST['id'];
    $status = $_POST['status'];

    // Validate and sanitize input (you should improve this based on your needs)
    $userId = mysqli_real_escape_string($conn, $userId);
    $status = mysqli_real_escape_string($conn, $status);

    // Update the status in the authentication table
    $query = "UPDATE authentication SET status = '$status' WHERE id = $userId";
    $result = mysqli_query($conn, $query);

    if ($result) {
        echo 'Status updated successfully.';
    } else {
        echo 'Error updating status.';
    }
} else {
    echo 'Invalid request';
}
?>
