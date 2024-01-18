<?php
include 'connection.php';

$interval = isset($_GET['interval']) ? $_GET['interval'] : 'all-time';

switch ($interval) {
    case 'weekly':
        $intervalQuery = "WEEK(`booking`.`date`), YEAR(`booking`.`date`)";
        break;
    case 'monthly':
        $intervalQuery = "MONTH(`booking`.`date`), YEAR(`booking`.`date`)";
        break;
    case 'yearly':
        $intervalQuery = "YEAR(`booking`.`date`)";
        break;
    case 'all-time':
    default:
        $intervalQuery = "DATE_FORMAT(`booking`.`date`, '%Y-%m-%d')";
        break;
}

$sqlCustomers = "SELECT $intervalQuery AS date,
                        COUNT(DISTINCT `booking`.`customer_id`) AS total_customers
                FROM `booking`
                WHERE (`booking`.`date` BETWEEN DATE_SUB(NOW(), INTERVAL 5 WEEK) AND NOW())
                GROUP BY $intervalQuery";

$resultCustomers = mysqli_query($conn, $sqlCustomers);

$labelsCustomers = [];
$dataCustomers = [];

while ($rowCustomers = mysqli_fetch_assoc($resultCustomers)) {
    $labelsCustomers[] = $rowCustomers['date'];
    $dataCustomers[] = $rowCustomers['total_customers'];
}

echo json_encode(['labels' => $labels, 'data' => $data]);

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
                    labels: [],
                    datasets: [{
                        label: 'Total Amount',
                        data: [],
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

            // Fetch initial data for 'all-time'
            fetchChartData('all-time');
        </script>
    </div>

</body>

</html>

