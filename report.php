<?php
session_start();

include 'connection.php';
if (!isset($_SESSION['id']) || !isset($_SESSION['role'])) {
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

// Fetch data for the new chart (total amount of last twelve months and total customers in each month)
$twelveMonthsAgo = date('Y-m-d', strtotime('-12 months'));

$sqlTransactionsThisYear = "SELECT MONTH(`created_at`) AS month_number,
                                   SUM(`total`) AS total_amount
                            FROM `transaction`
                            WHERE YEAR(`created_at`) = YEAR(CURDATE())
                            GROUP BY month_number";

$resultTransactionsThisYear = mysqli_query($conn, $sqlTransactionsThisYear);

$labelsTransactionsThisYear = [];
$dataTransactionsThisYear = [];

while ($rowTransactionsThisYear = mysqli_fetch_assoc($resultTransactionsThisYear)) {
    $labelsTransactionsThisYear[] = $rowTransactionsThisYear['month_number'];
    $dataTransactionsThisYear[] = $rowTransactionsThisYear['total_amount'];
}

mysqli_close($conn);
?>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>
    #transactionChart,
    #customerChart {
        background-color: #e1f7d5;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        margin-bottom: 20px;
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

        
        <canvas id="transactionChart" width="50" height="10"></canvas>

        <canvas id="customerChart" width="50" height="10"></canvas>
        <div style="width: 300px; height: 300px; margin: auto; display: flex; justify-content: center; align-items: center;">
    <canvas id="transactionDoughnutChart"></canvas>
</div>





        <script>
            var ctx = document.getElementById('transactionChart').getContext('2d');
            var ctxCustomers = document.getElementById('customerChart').getContext('2d');
            var myChart;
            var myCustomerChart;

            function updateChart() {
                var selectedInterval = document.getElementById('interval').value;

                fetchChartData(selectedInterval);
                fetchCustomerChartData(selectedInterval);
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

            function fetchCustomerChartData(selectedInterval) {
                var apiUrl = 'api/reportHtml.php?interval=' + selectedInterval;

                fetch(apiUrl)
                    .then(response => response.json())
                    .then(data => {
                        myCustomerChart.data.labels = data.labelsCustomers;
                        myCustomerChart.data.datasets[0].data = data.dataCustomers;
                        myCustomerChart.update();
                    })
                    .catch(error => {
                        console.error('Error fetching customer data:', error);
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


            
myCustomerChart = new Chart(ctxCustomers, {
    type: 'bar',
    data: {
        labels: <?php echo json_encode($labelsCustomers); ?>,
        datasets: [
            {
                label: 'Total Customers',
                data: <?php echo json_encode($dataCustomers); ?>,
                backgroundColor: 'rgba(255, 165, 0, 0.7)', // Bright orange for the bar
                borderWidth: 1,
                yAxisID: 'y-axis', // Use 'y-axis' for the bar dataset
                order: 2, // Set a higher order for the bar dataset
            },
        ],
    },
    options: {
        scales: {
            y: [
                {
                    stacked: false,
                    position: 'left',
                    id: 'y-axis',
                    ticks: {
                        stepSize: 10,
                        beginAtZero: true,
                        callback: function (value) {
                            console.log(value);
                            return value;
                        },
                    },
                },
                {
                    stacked: false,
                    position: 'right',
                    id: 'y-line-axis', // Use a different ID for the line dataset
                    ticks: {
                        stepSize: 10,
                        beginAtZero: true,
                        callback: function (value) {
                            console.log(value);
                            return value;
                        },
                    },
                },
            ],
            x: {
                ticks: {
                    autoSkip: false,
                    maxRotation: 45,
                    minRotation: 45,
                },
            },
        },
        plugins: {
            tooltip: {
                callbacks: {
                    label: function (context) {
                        var label = context.dataset.label || '';
                        if (label) {
                            label += ': ';
                        }
                        label += context.parsed.y;
                        return label;
                    },
                },
            },
        },
        // Set the background color of the chart
        backgroundColor: 'rgba(255, 255, 255, 0.9)', // Bright white background
    },
});

// Add the line chart to the existing chart
myCustomerChart.data.datasets.push({
    label: 'Total Transactions',
    data: <?php echo json_encode($data); ?>,
    type: 'line',
    borderColor: 'rgba(255, 69, 0, 1)', // Bright orange for the line
    backgroundColor: 'rgba(255, 69, 0, 0.2)',
    borderWidth: 2,
    fill: true,
    yAxisID: 'y-line-axis', // Use the same ID as specified in the second y-axis
    order: 1, // Set a lower order for the line dataset
});

// Update the chart to reflect the changes
myCustomerChart.update();



// doughnut

var ctxDoughnut = document.getElementById('transactionDoughnutChart').getContext('2d');
        var myDoughnutChart;

        function fetchDoughnutChartData() {
            var apiUrl = 'api/reportHtml.php?interval=this-year';

            fetch(apiUrl)
                .then(response => response.json())
                .then(data => {
                    myDoughnutChart.data.labels = data.labelsTransactionsThisYear;
                    myDoughnutChart.data.datasets[0].data = data.dataTransactionsThisYear;
                    myDoughnutChart.update();
                })
                .catch(error => {
                    console.error('Error fetching doughnut data:', error);
                });
        }

        myDoughnutChart = new Chart(ctxDoughnut, {
            type: 'doughnut',
            data: {
                labels: <?php echo json_encode($labelsTransactionsThisYear); ?>,
                datasets: [{
                    data: <?php echo json_encode($dataTransactionsThisYear); ?>,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.7)',
                        'rgba(255, 159, 64, 0.7)',
                        'rgba(255, 205, 86, 0.7)',
                        'rgba(75, 192, 192, 0.7)',
                        'rgba(54, 162, 235, 0.7)',
                        'rgba(153, 102, 255, 0.7)',
                        'rgba(201, 203, 207, 0.7)',
                        'rgba(255, 215, 0, 0.7)',
                        'rgba(255, 140, 0, 0.7)',
                        'rgba(0, 255, 0, 0.7)',
                        'rgba(0, 0, 255, 0.7)',
                        'rgba(128, 0, 128, 0.7)'
                    ],
                }],
            },
            options: {
                responsive: false, 
        maintainAspectRatio: false,
                width: 20,
                height: 20, 
                plugins: {
                    legend: {
                        display: true,
                        position: 'top',
                    },
                },
            },
        });

        // ... (existing JavaScript)

        function updateChart() {
            var selectedInterval = document.getElementById('interval').value;

            fetchChartData(selectedInterval);
            fetchCustomerChartData(selectedInterval);
            fetchDoughnutChartData(); // Fetch data for the doughnut chart
        }

        // ... (existing JavaScript)

        // Initial fetching of data
        fetchChartData('all-time');
        fetchCustomerChartData('all-time');
        fetchDoughnutChartData();




            console.log('Initial labels:', myChart.data.labels);
            console.log('Initial data:', myChart.data.datasets[0].data);
            console.log('Initial customer labels:', myCustomerChart.data.labels);
            console.log('Initial customer data:', myCustomerChart.data.datasets[0].data);

            fetchChartData('all-time');
            fetchCustomerChartData('all-time');
        </script>
    </div>
</div>

<?php include_once('includes/footer.php'); ?>