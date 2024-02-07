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
            <h1 class="page-header text-center">Booking Slot Reports</h1>
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
            <!-- <div class="filter-container">
                <label for="interval">Select Interval:</label>
                <select id="interval" name="filter" class="form-select">
                    <option value="all-time" <?php echo (!isset($_POST['filter']) || $_POST['filter'] == 'all-time') ? 'selected' : ''; ?>>All Time</option>
                </select>
            </div> -->

            <!-- Stylish Canvas for Chart.js -->
            <div class="card">
                <div class="card-body">
                    <canvas id="myChart" width="400" height="150"></canvas>
                </div>
            </div>

            <?php
            function fetchDataForChart($conn)
            {
                $sql = "SELECT DATE(b.date) AS booking_date, COUNT(b.id) AS total_bookings FROM slot_live b WHERE b.date >= CURDATE() - 
                INTERVAL 6 DAY AND b.date <= NOW() GROUP BY booking_date";

                $result = mysqli_query($conn, $sql);

                // Check for errors
                if (!$result) {
                    die("Error in SQL: " . mysqli_error($conn));
                }

                $data = array();

                // Fetch data and group by the booking date
                while ($row = mysqli_fetch_assoc($result)) {
                    // Use the booking date for grouping
                    $date = date_create($row['booking_date']);
                    $groupKey = date_format($date, 'Y-m-d (D)');

                    if (!isset($data[$groupKey])) {
                        $data[$groupKey] = 0;
                    }

                    // Count the number of bookings for each day
                    $data[$groupKey] += $row['total_bookings'];
                }

                return array('totalBookings' => $data);
            }

            // Display data for the last 7 days
            $data = fetchDataForChart($conn);

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

                    var labels = [];
                    var values = [];

                    // Extract keys (labels) and values from the data.totalBookings array
                    for (var key in data.totalBookings) {
                        labels.push(key);
                        values.push(data.totalBookings[key]);
                    }

                    // Define vibrant and deeper colors for the bars
                    var barColors = [
                        'rgba(75, 192, 192, 0.8)',
                        
                    ];

                    window.myChart = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: labels,
                            datasets: [{
                                label: 'Total Bookings',
                                data: values,
                                backgroundColor: barColors,
                                borderColor: barColors.map(color => color.replace('0.8', '1')),
                                borderWidth: 2
                            }]
                        },
                        options: {
                            scales: {
                                y: {
                                    title: {
                                        display: true,
                                        text: 'Booking Slot Count',
                                    },
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

                // Initial chart creation
                createChart(<?php echo json_encode($data); ?>);
            </script>

        </div>
    </div>
</div>

<?php include_once('includes/footer.php'); ?>