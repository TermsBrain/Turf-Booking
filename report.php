<?php
session_start();

include 'connection.php';
if (!isset($_SESSION['name']) || !isset($_SESSION['role'])) {
    header('Location: login.php');
    exit;
}
include_once('includes/header.php');

function formatDate($weekNumber, $month, $interval)
{
    return 'Week ' . $weekNumber . ' - ' . $month;
}

$interval = isset($_GET['interval']) ? $_GET['interval'] : 'all-time';

// Calculate the start and end dates for the current week and the previous four weeks
$currentWeekStart = date('Y-m-d', strtotime('this week'));
$currentWeekEnd = date('Y-m-d', strtotime('next week - 1 day'));
$fourWeeksAgoStart = date('Y-m-d', strtotime('-4 weeks this week'));
$fourWeeksAgoEnd = date('Y-m-d', strtotime('last week'));

$sql = "SELECT WEEK(`created_at`) AS week_number,
               MONTHNAME(`created_at`) AS month_name,
               SUM(`total`) AS total_amount
        FROM `transaction`
        WHERE (`created_at` BETWEEN '$currentWeekStart' AND '$currentWeekEnd') OR
              (`created_at` BETWEEN '$fourWeeksAgoStart' AND '$fourWeeksAgoEnd')
        GROUP BY week_number, month_name";

$result = mysqli_query($conn, $sql);

$labels = [];
$data = [];

while ($row = mysqli_fetch_assoc($result)) {
    $labels[] = formatDate($row['week_number'], $row['month_name'], $interval);
    $data[] = $row['total_amount'];
}

mysqli_close($conn);
?>






<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>
    #transactionChart {
        background-color: #e1f7d5; /* Change this color */
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        margin-bottom: 20px;
    }

    .filter-container {
        background-color: #e1f7d5; /* Change this color */
        margin-bottom: 20px;
        padding: 15px; /* Add padding for a better visual appearance */
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
</style>


<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Reports</h1>
        </div>
    </div>

    <div class="row">
        <div class="filter-container">
            <label for="interval">Select Interval:</label>
            <select id="interval" onchange="updateChart()">
                <option value="all-time">All Time</option>
                <option value="weekly">Weekly</option>
                <option value="monthly">Monthly</option>
                <option value="yearly">Yearly</option>
            </select>
        </div>

        <canvas id="transactionChart" width="400" height="200"></canvas>

        <script>
            var ctx = document.getElementById('transactionChart').getContext('2d');
            var myChart;

            function updateChart() {
                var selectedInterval = document.getElementById('interval').value;

                fetchChartData(selectedInterval);
            }

            function fetchChartData(selectedInterval) {
                var apiUrl = 'reportHtml.php?interval=' + selectedInterval;

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
</div>

<?php include_once('includes/footer.php'); ?>