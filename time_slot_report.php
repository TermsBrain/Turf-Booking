<?php
session_start();

include 'connection.php';

if (!isset($_SESSION['id']) || !isset($_SESSION['role'])) {
    header('Location: login.php');
    exit;
}

include_once('includes/header.php');
?>

<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header text-center">All Reports</h1>
        </div>
    </div>

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

    <div class="row">
        <div class=" mt-4">
            <!-- Filter Select Box -->
            <div class="filter-container">
                <label for="interval">Select Interval:</label>
                <select id="interval" name="filter" class="form-select">
                    <option value="last-7-days" <?php echo (!isset($_POST['filter']) || $_POST['filter'] == 'last-7-days') ? 'selected' : ''; ?>>Last 7 Days</option>
                    <option value="last-30-days" <?php echo (isset($_POST['filter']) && $_POST['filter'] == 'last-30-days') ? 'selected' : ''; ?>>Last 30 Days</option>
                    <option value="monthly" <?php echo (isset($_POST['filter']) && $_POST['filter'] == 'monthly') ? 'selected' : ''; ?>>Monthly</option>
                    <option value="yearly" <?php echo (isset($_POST['filter']) && $_POST['filter'] == 'yearly') ? 'selected' : ''; ?>>Yearly</option>
                    <!-- <option value="all-time" <?php echo (isset($_POST['filter']) && $_POST['filter'] == 'all-time') ? 'selected' : ''; ?>>All Time</option> -->
                </select>
            </div>

            <!-- Stylish Canvas for Chart.js -->
            <div class="card">
                <div class="card-body">
                    <canvas id="myChart" width="400" height="150"></canvas>
                </div>
            </div>

            <?php
            function fetchDataForChart($interval, $format, $conn)
            {
                $sql = "SELECT DATE(b.date) AS booking_date, TIME(start_slot.start_time) AS start_time, TIME(end_slot.end_time) AS end_time, SUM(t.total) AS total_income 
                        FROM booking b
                        LEFT JOIN transaction t ON b.transaction_id = t.id
                        LEFT JOIN slot_management AS start_slot ON b.start_slot_id = start_slot.id
                        LEFT JOIN slot_management AS end_slot ON b.end_slot_id = end_slot.id";

                switch ($interval) {
                    case 'last-7-days':
                        $sql .= " WHERE b.date >= CURDATE() - INTERVAL 6 DAY AND b.date <= NOW()";
                        break;

                    case 'last-30-days':
                        $sql .= " WHERE b.date >= CURDATE() - INTERVAL 29 DAY AND b.date <= NOW()";
                        break;

                    case 'monthly':
                        $sql .= " WHERE b.date >= DATE_SUB(NOW(), INTERVAL 1 MONTH) AND b.date <= NOW()";
                        break;

                    case 'yearly':
                        $sql .= " WHERE b.date >= DATE_SUB(NOW(), INTERVAL 1 YEAR) AND b.date <= NOW()";
                        break;
                        // Add more cases for other intervals if needed
                }

                $sql .= " GROUP BY booking_date, start_time, end_time";

                $result = mysqli_query($conn, $sql);

                // Check for errors
                if (!$result) {
                    die("Error in SQL: " . mysqli_error($conn));
                }

                $data = array();

                // Fetch data and group by the specified interval from the booking table
                while ($row = mysqli_fetch_assoc($result)) {
                    // Use the booking date for grouping
                    $date = date_create($row['booking_date']);
                    $groupKey = date_format($date, $format) . ' ' . $row['start_time'] . '-' . $row['end_time'];

                    if (!isset($data[$groupKey])) {
                        $data[$groupKey] = 0;
                    }

                    // Sum up the total amount for each interval
                    $data[$groupKey] += $row['total_income'];
                }

                return array('totalIncome' => $data);
            }


            // Display data by default (last 30 days)
            $data = fetchDataForChart('last-7-days', 'Y-m-d', $conn);
            ?>

            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

            <script>
                var myChart; // Variable to hold the Chart.js instance

                // Function to create a stylish Chart.js line chart with tension
                function createChart(data) {
                    var ctx = document.getElementById('myChart').getContext('2d');

                    // Check if a chart instance exists, destroy it before creating a new one
                    if (window.myChart) {
                        window.myChart.destroy();
                    }

                    var labels = [];
                    var values = [];

                    // Extract keys (labels) and values from the data.totalIncome array
                    for (var key in data.totalIncome) {
                        labels.push(key);
                        values.push(data.totalIncome[key]);
                    }

                    window.myChart = new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: labels,
                            datasets: [{
                                label: 'Total Amount',
                                data: values,
                                fill: false,
                                borderColor: 'rgba(75, 192, 192, 1)',
                                borderWidth: 2,
                                tension: 0.4, // Adjust the tension as needed
                                pointRadius: 4,
                                pointHoverRadius: 6,
                            }]
                        },
                        options: {
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    grid: {
                                        color: 'rgba(0, 0, 0, 0.1)',
                                    }
                                },
                                x: {
                                    grid: {
                                        color: 'rgba(0, 0, 0, 0)',
                                    }
                                }
                            },
                            plugins: {
                                legend: {
                                    display: true,
                                    position: 'top',
                                }
                            }
                        }
                    });
                }

                // Function to update the chart
                function updateChart() {
                    // Fetch data using jQuery AJAX
                    var selectedFilter = $('#interval').val();

                    $.ajax({
                        method: 'POST',
                        url: 'update_chart_data.php',
                        data: {
                            filter: selectedFilter
                        },
                        dataType: 'json',
                        cache: false, // Add this line to prevent caching
                        success: function(response) {
                            if (response.error) {
                                console.error('Error:', response.error);
                            } else {
                                // Call the function to update the chart
                                createChart(response.data);
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error('AJAX Error:', error);
                        }
                    });
                }

                // Bind the updateChart function to the change event of the select box
                $('#interval').change(updateChart);

                // Initial chart creation
                createChart(<?php echo json_encode($data); ?>);

            </script>

        </div>
    </div>
</div>

<?php include_once('includes/footer.php'); ?>
