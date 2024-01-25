<?php
session_start();

include 'connection.php';

// Check if the filter parameter is set
if (isset($_POST['filter'])) {
    $selectedFilter = $_POST['filter'];
    
    // Fetch and format data for Chart.js
    $data = fetchDataForChart($selectedFilter, ($selectedFilter == 'monthly' ? 'F Y' : 'Y-m-d'), $conn);

    // Return the JSON response
    echo json_encode(['data' => $data]);
} else {
    // Return an error JSON response if filter parameter is not set
    echo json_encode(['error' => 'Filter parameter not provided']);
}

function fetchDataForChart($interval, $format, $conn)
{
    // Modify the SQL query to join the `booking` and `transaction` tables
    $sql = "SELECT DATE(b.date) AS booking_date, SUM(t.total) AS total_income 
            FROM booking b
            LEFT JOIN transaction t ON b.transaction_id = t.id";

    switch ($interval) {
        case 'last-30-days':
            $sql .= " WHERE b.date >= DATE_SUB(NOW(), INTERVAL 30 DAY)";
            break;
        case 'monthly':
            $sql .= " WHERE b.date >= DATE_SUB(NOW(), INTERVAL 1 MONTH)";
            break;
        case 'yearly':
            $sql .= " WHERE b.date >= DATE_SUB(NOW(), INTERVAL 1 YEAR)";
            break;
        // Add more cases for other intervals if needed
    }

    $sql .= " GROUP BY booking_date";
    
    $result = mysqli_query($conn, $sql);

    // Check for errors
    if (!$result) {
        die("Error in SQL: " . mysqli_error($conn));
    }

    $data = array();

    // Fetch data and group by the specified interval from the booking table
    while ($row = mysqli_fetch_assoc($result)) {
        // Use the booking date for grouping
        $date = date_create($row['booking_date']);
        $groupKey = date_format($date, $format);

        if (!isset($data[$groupKey])) {
            $data[$groupKey] = 0;
        }

        // Sum up the total amount for each interval
        $data[$groupKey] += $row['total_income'];
    }

    return array('totalIncome' => $data);
}
?>
