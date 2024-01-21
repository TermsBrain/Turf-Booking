<?php
include '../connection.php';
if(isset($_GET['date'])) {
    $date = $_GET['date'];
    
    $query = "SELECT * FROM slot_live WHERE date = '$date' AND status=1 ORDER BY slot_id ASC";
    $result = mysqli_query($conn, $query);
    $data = [];
    while($row = mysqli_fetch_array($result)) {
        $data[] = $row;
    }
    echo json_encode($data);
}
?>