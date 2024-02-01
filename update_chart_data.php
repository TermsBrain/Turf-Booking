<?php
session_start();

include 'connection.php';

// Check if the filter parameter is set
if (isset($_POST['filter'])) {
    $selectedFilter = $_POST['filter'];
    
    // Fetch and format data for Chart.js
    $data = fetchDataForChart($selectedFilter, $conn);

    // Return the JSON response
    echo json_encode(['data' => $data]);
} else {
    // Return an error JSON response if filter parameter is not set
    echo json_encode(['error' => 'Filter parameter not provided']);
}

function fetchDataForChart($interval, $conn)
{
    // Modify the SQL query to join the `booking` and `transaction` tables
    $sql = "SELECT DATE(b.date) AS booking_date, SUM(t.total) AS total_income 
            FROM booking b
            LEFT JOIN transaction t ON b.transaction_id = t.id";

    switch ($interval) {
        case 'last-7-days':
            $sql .= " WHERE b.date >= DATE_SUB(NOW(), INTERVAL 6 DAY) AND b.date <= NOW()";
            break;
        case 'last-30-days':
            $sql .= " WHERE b.date >= DATE_SUB(NOW(), INTERVAL 30 DAY) AND b.date <= NOW()";
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
        // Modify the date format based on the selected interval
        switch ($interval) {
            case 'last-7-days':
                $groupKey = date_format($date, 'Y-m-d') . ' ' . date_format($date, 'l'); // Concatenate date and day name

                break;
            case 'last-30-days':
                $groupKey = date_format($date, 'Y-m-d');
                break;
            case 'monthly':
                $groupKey = date_format($date, 'F Y'); // Full month name and year
                break;
            case 'yearly':
                $groupKey = date_format($date, 'Y'); // Year
                break;
            // Add more cases for other intervals if needed
        }

        if (!isset($data[$groupKey])) {
            $data[$groupKey] = 0;
        }

        // Sum up the total amount for each interval
        $data[$groupKey] += $row['total_income'];
    }

    return array('totalIncome' => $data);
}
?>
