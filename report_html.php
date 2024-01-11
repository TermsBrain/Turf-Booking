<?php
include 'connection.php';

function formatDate($date, $interval) {
    switch ($interval) {
        case 'weekly':
            return date('W-Y', strtotime($date));
        case 'monthly':
            return date('M Y', strtotime($date));
        case 'yearly':
            return date('Y', strtotime($date));
        default:
            return date('M d, Y', strtotime($date));
    }
}

$interval = isset($_GET['interval']) ? $_GET['interval'] : 'all-time';

$sql = "SELECT DATE_FORMAT(`created_at`, '%Y-%m-%d') AS date,
               SUM(`total`) AS total_amount
        FROM `transaction`
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