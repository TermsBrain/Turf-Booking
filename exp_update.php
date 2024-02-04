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
    $sql = "SELECT DATE(e.created_at) AS expense_date, SUM(e.amount) AS total_expense 
            FROM expanse e
            LEFT JOIN authentication a ON e.reference_id = a.id";

    switch ($interval) {
        case 'last-7-days':
            $sql .= " WHERE e.created_at >= DATE_SUB(NOW(), INTERVAL 6 DAY) AND e.created_at <= NOW()";
            break;
        case 'last-30-days':
            $sql .= " WHERE e.created_at >= DATE_SUB(NOW(), INTERVAL 30 DAY) AND e.created_at <= NOW()";
            break;
        case 'monthly':
            $sql .= " WHERE e.created_at >= DATE_SUB(NOW(), INTERVAL 1 MONTH)";
            break;
        case 'yearly':
            $sql .= " WHERE e.created_at >= DATE_SUB(NOW(), INTERVAL 1 YEAR)";
            break;
        // Add more cases for other intervals if needed
    }

    $sql .= " GROUP BY expense_date";
    
    $result = mysqli_query($conn, $sql);

    // Check for errors
    if (!$result) {
        die("Error in SQL: " . mysqli_error($conn));
    }

    $data = array();

    // Fetch data and group by the specified interval from the expanse table
    while ($row = mysqli_fetch_assoc($result)) {
        // Use the expense date for grouping
        $date = date_create($row['expense_date']);
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
        $data[$groupKey] += $row['total_expense'];
    }

    return array('totalExpense' => $data);
}

?>
