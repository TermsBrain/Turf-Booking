<?php
include 'connection.php';

function formatDate($date, $interval) {
    switch ($interval) {
        case 'weekly':
            // Display month name and year for weekly interval
            return date('M Y', strtotime($date));
        case 'monthly':
            return date('M Y', strtotime($date));
        case 'yearly':
            return date('Y', strtotime($date));
        default:
            return date('M d, Y', strtotime($date));
    }
}

$interval = isset($_GET['interval']) ? $_GET['interval'] : 'all-time';

// Modify the SQL query to fetch data for the previous five weeks
$sql = "SELECT DATE_FORMAT(`created_at`, '%Y-%m-%d') AS date,
               SUM(`total`) AS total_amount
        FROM `transaction`
        WHERE (`created_at` BETWEEN DATE_SUB(NOW(), INTERVAL 5 WEEK) AND NOW())
        GROUP BY " . ($interval == 'weekly' ? "WEEK(`created_at`), YEAR(`created_at`)" : ($interval == 'monthly' ? "MONTH(`created_at`), YEAR(`created_at`)" : "YEAR(`created_at`)"));

$result = mysqli_query($conn, $sql);

$labels = [];
$data = [];

while ($row = mysqli_fetch_assoc($result)) {
    $labels[] = formatDate($row['date'], $interval);
    $data[] = $row['total_amount'];
}

mysqli_close($conn);

echo json_encode(['labels' => $labels, 'data' => $data]);
?>
