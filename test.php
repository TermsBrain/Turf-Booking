<?php
include 'connection.php';

    
    $query = "SELECT * FROM slot_live WHERE date = '2024-01-24' AND status=1";
    $result = mysqli_query($conn, $query);
    $data = array();
    while($row = mysqli_fetch_array($result)) {
        $data[] = $row;
    }
    print_r($data);



?>