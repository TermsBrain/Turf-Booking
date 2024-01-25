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
        <option value="all-time" <?php echo (isset($_POST['filter']) && $_POST['filter'] == 'all-time') ? 'selected' : ''; ?>>All Time</option>
    </select>
</div>


            <!-- Stylish Canvas for Chart.js -->
            <div class="card">
                <div class="card-body">
                    <canvas id="myChart" width="400" height="150"></canvas>
                </div>
            </div>

            <?php
            // Function to fetch and format data for Chart.js
            function fetchDataForChart($interval, $format, $conn)
            {
                $sql = "SELECT DATE(b.date) AS booking_date, SUM(t.total) AS total_income 
            FROM booking b
            LEFT JOIN transaction t ON b.transaction_id = t.id";

                switch ($interval) {
                    case 'last-7-days':
                        $sql .= " WHERE b.date >= CURDATE() - INTERVAL 6 DAY AND b.date <= NOW()";
                        break;
                    
                                        
                    case 'last-30-days':
                        $sql .= " WHERE b.date >= DATE_SUB(NOW(), INTERVAL 30 DAY)";
                        break;
                    case 'monthly':
                        $sql .= " WHERE b.date >= DATE_SUB(NOW(), INTERVAL 1 MONTH)";
                        break;
                    case 'yearly':
                        $sql .= " WHERE b.date >= DATE_SUB(NOW(), INTERVAL 1 YEAR)";
                        break;
                        // Add more cases for other intervals if needed
                }

                $sql .= " GROUP BY booking_date";

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
                    $groupKey = date_format($date, $format);

                    if (!isset($data[$groupKey])) {
                        $data[$groupKey] = 0;
                    }

                    // Sum up the total amount for each interval
                    $data[$groupKey] += $row['total_income'];
                }

                return array('totalIncome' => $data);
            }



            // Display data by default (last 30 days)
            $data = fetchDataForChart('last-30-days', 'Y-m-d', $conn);
            ?>

            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

            <script>
                var myChart; // Variable to hold the Chart.js instance

                // Function to create a stylish Chart.js bar chart
                function createChart(data) {
                    var ctx = document.getElementById('myChart').getContext('2d');

                    // Check if a chart instance exists, destroy it before creating a new one
                    if (window.myChart) {
                        window.myChart.destroy();
                    }

                    window.myChart = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: Object.keys(data.totalIncome),
                            datasets: [{
                                label: 'Total Amount',
                                data: Object.values(data.totalIncome),
                                backgroundColor: [
                                    'rgba(255, 99, 132, 0.6)',
                                    'rgba(255, 159, 64, 0.6)',
                                    'rgba(255, 205, 86, 0.6)',
                                    'rgba(75, 192, 192, 0.6)',
                                    'rgba(54, 162, 235, 0.6)',
                                    'rgba(153, 102, 255, 0.6)',
                                    'rgba(201, 203, 207, 0.6)'
                                ],
                                borderColor: [
                                    'rgba(255, 99, 132, 1)',
                                    'rgba(255, 159, 64, 1)',
                                    'rgba(255, 205, 86, 1)',
                                    'rgba(75, 192, 192, 1)',
                                    'rgba(54, 162, 235, 1)',
                                    'rgba(153, 102, 255, 1)',
                                    'rgba(201, 203, 207, 1)'
                                ],
                                borderWidth: 2
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