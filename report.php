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
            <h1 class="page-header">Dashboard</h1>
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
        <div class="container mt-4">
            <!-- Filter Select Box -->
            <form method="post" class="mb-3">
                <div class="filter-container">
                    <label for="interval">Select Interval:</label>
                    <select id="interval" name="filter" onchange="updateChart()" class="form-select">
                        <option value="all-time" <?php echo ($_POST['filter'] == 'all-time') ? 'selected' : ''; ?>>All Time</option>
                        <option value="weekly" <?php echo ($_POST['filter'] == 'weekly' || !isset($_POST['filter'])) ? 'selected' : ''; ?>>Weekly</option>
                        <option value="monthly" <?php echo ($_POST['filter'] == 'monthly' || !isset($_POST['filter'])) ? 'selected' : ''; ?>>Monthly</option>
                        <option value="yearly" <?php echo ($_POST['filter'] == 'yearly') ? 'selected' : ''; ?>>Yearly</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Apply Filter</button>
            </form>

            <!-- Stylish Canvas for Chart.js -->
            <div class="card">
                <div class="card-body">
                    <canvas id="myChart" width="400" height="200"></canvas>
                </div>
            </div>

            <!-- Line Graph for Per Day Income (Last 30 Days) -->
            <div class="card mt-4">
                <div class="card-body">
                    <canvas id="perDayChart" width="400" height="200"></canvas>
                </div>
            </div>

            <?php
            // Function to fetch and format data for Chart.js
            function fetchDataForChart($interval, $format, $conn)
            {
                $sql = "SELECT transaction.*, booking.date as booking_date FROM `transaction`
                        LEFT JOIN booking ON booking.transaction_id = transaction.id";
                $result = mysqli_query($conn, $sql);

                // Check for errors
                if (!$result) {
                    die("Error in SQL: " . mysqli_error($conn));
                }

                $data = array();
                $perDayIncome = array();

                // Fetch data and group by the specified interval from the booking table
                while ($row = mysqli_fetch_assoc($result)) {
                    // Use the booking date for grouping
                    $date = date_create($row['booking_date']);
                    $groupKey = date_format($date, $format);

                    if (!isset($data[$groupKey])) {
                        $data[$groupKey] = 0;
                    }

                    // Sum up the total amount for each interval
                    $data[$groupKey] += $row['total'];

                    // Calculate per day income
                    $dayKey = date_format($date, 'Y-m-d');
                    if (!isset($perDayIncome[$dayKey])) {
                        $perDayIncome[$dayKey] = 0;
                    }
                    $perDayIncome[$dayKey] += $row['total'];
                }

                return array('totalIncome' => $data, 'perDayIncome' => $perDayIncome);
            }

            // Check if the form is submitted
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $selectedFilter = $_POST["filter"];
                $data = fetchDataForChart($selectedFilter, ($selectedFilter == 'monthly' ? 'F Y' : 'Y'), $conn);
            } else {
                // Display data by default (monthly)
                $data = fetchDataForChart('1 month', 'F Y', $conn);
            }
            ?>

            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <script>
                // Function to create a stylish Chart.js bar chart
                function createChart(data) {
                    var ctx = document.getElementById('myChart').getContext('2d');
                    var myChart = new Chart(ctx, {
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

                // Function to create a stylish Chart.js line chart for per day income
                function createPerDayChart(data) {
                    var ctx = document.getElementById('perDayChart').getContext('2d');
                    var perDayChart = new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: Object.keys(data.perDayIncome).slice(-7), // Show only the last 30 days
                            datasets: [{
                                label: 'Per Day Income',
                                data: Object.values(data.perDayIncome).slice(-7), // Show only the last 30 days
                                fill: false,
                                borderColor: 'rgba(75, 192, 192, 1)',
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

                // Call the functions to create the charts
                createChart(<?php echo json_encode($data); ?>);
                createPerDayChart(<?php echo json_encode($data); ?>);
            </script>
        </div>
    </div>
</div>

<?php include_once('includes/footer.php'); ?>
