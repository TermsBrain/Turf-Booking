<?php
session_start();

// Include connection.php and header.php
include 'connection.php';
include_once('includes/header.php');

// Function to format date based on the interval
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

// Check if user is not logged in, redirect to login page
if (!isset($_SESSION['name']) || !isset($_SESSION['role'])) {
    header('Location: login.php');
    exit;
}

// Handle interval selection from the dropdown
$interval = isset($_GET['interval']) ? $_GET['interval'] : 'all-time';

// SQL query to fetch data based on the selected interval
$sql = "SELECT DATE_FORMAT(`created_at`, '%Y-%m-%d') AS date,
               SUM(`total`) AS total_amount
        FROM `transaction`
        GROUP BY " . ($interval == 'weekly' ? "WEEK(`created_at`), YEAR(`created_at`)" : ($interval == 'monthly' ? "MONTH(`created_at`), YEAR(`created_at`)" : "YEAR(`created_at`)"));

$result = mysqli_query($conn, $sql);

$labels = [];
$data = [];

// Fetch data and format labels
while ($row = mysqli_fetch_assoc($result)) {
    $labels[] = formatDate($row['date'], $interval);
    $data[] = $row['total_amount'];
}

mysqli_close($conn);
?>

<!-- HTML content starts here -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<!-- Add some CSS styles for better presentation -->
<style>
    #transactionChart {
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        margin-bottom: 20px;
    }

    .filter-container {
        margin-bottom: 20px;
    }
</style>

<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Reports</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->

    <div class="row">
        <!-- Filter dropdown -->
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
                // Get the selected interval from the dropdown
                var selectedInterval = document.getElementById('interval').value;

                // Fetch data based on the selected interval
                fetchChartData(selectedInterval);
            }

            function fetchChartData(selectedInterval) {
                // Fetch data from the server based on the interval
                var apiUrl = 'report_html.php?interval=' + selectedInterval;

                fetch(apiUrl)
                    .then(response => response.json())
                    .then(data => {
                        // Update the chart data and labels
                        myChart.data.labels = data.labels;
                        myChart.data.datasets[0].data = data.data;
                        myChart.update();
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

            // Log the initial data to check if it's correct
            console.log('Initial labels:', myChart.data.labels);
            console.log('Initial data:', myChart.data.datasets[0].data);

            // Initially fetch data based on the selected interval
            fetchChartData('all-time');
        </script>
    </div>
</div>

<?php include_once('includes/footer.php'); ?>
