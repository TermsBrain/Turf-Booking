<!DOCTYPE html>
<html>
<head>
    <title>Transaction Graph</title>
    <!-- Include Chart.js library -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>

<!-- Create canvas for the chart -->
<canvas id="transactionChart" width="800" height="400"></canvas>

<?php
// Database connection
include 'connection.php';

// Fetch data from the database
$sql = "SELECT created_at, Due, Cash, Total FROM transaction";
$result = $conn->query($sql);

// Extract data for labels, bar dataset, line dataset, and total dataset
$labels = [];
$barData = [];
$lineData = [];
$totalData = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $labels[] = $row["created_at"];
        $barData[] = $row["Due"];
        $lineData[] = $row["Cash"];
        $totalData[] = $row["Total"];
    }
}

$conn->close();
?>

<!-- Script to create the chart -->
<script>
    // Get canvas element
    var ctx = document.getElementById('transactionChart').getContext('2d');

    // Create bar and line chart
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: <?php echo json_encode($labels); ?>,
            datasets: [{
                label: 'Due Amount',
                data: <?php echo json_encode($barData); ?>,
                backgroundColor: 'rgba(75, 192, 192, 0.5)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1,
                yAxisID: 'y-axis-bar'
            }, {
                label: 'Cash Amount',
                data: <?php echo json_encode($lineData); ?>,
                type: 'bar',
                fill: false,
                borderColor: 'rgba(255, 99, 132, 1)',
                borderWidth: 2,
                yAxisID: 'y-axis-line'
            }, {
                label: 'Total Amount',
                data: <?php echo json_encode($totalData); ?>,
                type: 'bar',
                fill: false,
                borderColor: 'rgba(255, 206, 86, 1)',
                borderWidth: 2,
                yAxisID: 'y-axis-line'
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    type: 'linear',
                    display: true,
                    position: 'left',
                    id: 'y-axis-bar'
                }, {
                    type: 'linear',
                    display: true,
                    position: 'right',
                    id: 'y-axis-line'
                }]
            }
        }
    });
</script>

</body>
</html>
