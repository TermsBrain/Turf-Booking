<?php
include_once('connection.php');

session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (!isset($_SESSION['name']) || !isset($_SESSION['role'])) {
    header('Location: login.php');
    exit;
}

$timeRange = isset($_GET['time_range']) ? $_GET['time_range'] : 'monthly';

if ($timeRange === 'monthly') {
    $startTime = date('Y-m-01 00:00:00');
    $endTime = date('Y-m-t 23:59:59');
} elseif ($timeRange === 'yearly') {
    $startTime = date('Y-01-01');
    $endTime = date('Y-12-31');
} else {
    $startTime = '2014-01-01 00:00:00';
    $endTime = date('Y-m-d H:i:s');
}

function fetchChartData($conn, $startTime, $endTime)
{
    $query = "SELECT 
                CASE 
                    WHEN '$startTime' = '$endTime' THEN DATE_FORMAT(created_at, '%Y-%m-%d')
                    WHEN '$startTime' = DATE_FORMAT('$endTime', '%Y-%m-01 00:00:00') THEN DATE_FORMAT(created_at, '%Y-%m')
                    ELSE DATE_FORMAT(created_at, '%Y-%m')
                END AS date,
                SUM(total) AS total_income 
              FROM transaction 
              WHERE created_at BETWEEN '$startTime' AND '$endTime' 
              GROUP BY date;";

    $result = mysqli_query($conn, $query);

    if (!$result) {
        die("Query failed: " . mysqli_error($conn));
    }

    $data = array('labels' => array(), 'data' => array());

    while ($row = mysqli_fetch_assoc($result)) {
        $data['labels'][] = $row['date'];
        $data['data'][] = $row['total_income'];
    }

    return $data;
}

$chartData = fetchChartData($conn, $startTime, $endTime);

// header('Content-Type: application/json');
// echo json_encode($chartData);
?>

<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Report</h1>

            <label for="timeRange">Select Time Range:</label>
            <select id="timeRange" onchange="upcreated_atChart()">
                <option value="monthly">Monthly</option>
                <option value="yearly">Yearly</option>
                <option value="all-time">All Time</option>
            </select>

        </div>
    </div>
</div>

<?php include_once('includes/footer.php'); ?>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>


<script>
    $(document).ready(function() {
        // Define the chart creation function
        function createChart(data) {
            var ctx = document.getElementById('myChart').getContext('2d');
            var labelFormat = (data.labels.length > 1) ? 'MMMM YYYY' : 'MMMM DD, YYYY';

            var myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: data.labels.map(function(label) {
                        return moment(label).format(labelFormat);
                    }),
                    datasets: [{
                        label: 'Total Income',
                        data: data.data,
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value, index, values) {
                                    return '$' + value;
                                }
                            }
                        }
                    }
                }
            });
        }

        // Define the function to fetch data and update the chart
        function upcreated_atChart() {
            var selectedTimeRange = document.getElementById("timeRange").value;
            $.ajax({
                url: 'report.php',
                data: {
                    time_range: selectedTimeRange
                },
                dataType: 'json',
                success: function(data) {
                    // Call the chart creation function with the fetched data
                    createChart(data);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error("AJAX Error: " + textStatus, errorThrown);
                }
            });
        }

        // Call the chart creation function with empty data on page load
        createChart({ labels: [], data: [] });

        // Event listener for select change
        $('#timeRange').change(function() {
            upcreated_atChart();
        });
    });
</script>
