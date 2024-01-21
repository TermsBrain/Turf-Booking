<?php
include '../connection.php';

if (isset($_POST['id']) && isset($_POST['status'])) {
    $id = $_POST['id'];
    $status = $_POST['status'];

    $query = "UPDATE authentication SET status = '$status' WHERE id = '$id'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        echo "Status updated successfully";
    } else {
        echo "Error updating status: " . mysqli_error($conn);
    }
} else {
    echo "Invalid request";
}
?>
