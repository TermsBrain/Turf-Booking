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
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reports</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/chart.js">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        #page-wrapper {
            max-width: 1200px;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1.page-header {
            color: #007bff;
        }

        .filter-container {
            background-color: #e1f7d5;
            margin-bottom: 20px;
            padding: 15px;
            border-radius: 8px;
        }

        .filter-container label {
            margin-right: 10px;
            font-weight: bold;
            color: #007bff;
        }

        .filter-container select {
            padding: 8px;
            border-radius: 4px;
            border: 1px solid #ced4da;
            outline: none;
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        }

        canvas {
            background-color: #e1f7d5;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }
    </style>
</head>

<body>

    <div id="page-wrapper">
        <div class="filter-container">
            <label for="interval">Select Interval:</label>
            <select id="interval" onchange="updateChart()">
                <option value="all-time">All Time</option>
                <option value="weekly">Weekly</option>
                <option value="monthly">Monthly</option>
                <option value="yearly">Yearly</option>
            </select>
        </div>

        <canvas id="transactionChart" width="200" height="100"></canvas>

        <script>
            var ctx = document.getElementById('transactionChart').getContext('2d');
            var myChart;

            function updateChart() {
                var selectedInterval = document.getElementById('interval').value;

                fetchChartData(selectedInterval);
            }

            function fetchChartData(selectedInterval) {
                var apiUrl = 'api/reportHtml.php?interval=' + selectedInterval;

                fetch(apiUrl)
                    .then(response => response.json())
                    .then(data => {
                        myChart.data.labels = data.labels;
                        myChart.data.datasets[0].data = data.data;
                        myChart.update();
                    })
                    .catch(error => {
                        console.error('Error fetching data:', error);
                    });
            }

            myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: <?php echo json_encode($labels); ?>,
                    datasets: [{
                        label: 'Total Amount',
                        data: <?php echo json_encode($data); ?>,
                        fill: false,
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 2
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            console.log('Initial labels:', myChart.data.labels);
            console.log('Initial data:', myChart.data.datasets[0].data);

            fetchChartData('all-time');
        </script>
    </div>

</body>

</html>
