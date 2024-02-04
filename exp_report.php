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
            <h1 class="page-header text-center">All Expanses</h1>
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
                $sql = "SELECT DATE(e.created_at) AS expense_date, SUM(e.amount) AS total_expense 
                        FROM expanse e
                        LEFT JOIN authentication a ON e.reference_id = a.id";

                switch ($interval) {
                    case 'last-7-days':
                        $sql .= " WHERE e.created_at >= CURDATE() - INTERVAL 6 DAY AND e.created_at <= NOW()";
                        break;

                    case 'last-30-days':
                        $sql .= " WHERE e.created_at >= CURDATE() - INTERVAL 29 DAY AND e.created_at <= NOW()";
                        break;

                    case 'monthly':
                        $sql .= " WHERE e.created_at >= DATE_SUB(NOW(), INTERVAL 1 MONTH) AND e.created_at <= NOW()";
                        break;

                    case 'yearly':
                        $sql .= " WHERE e.created_at >= DATE_SUB(NOW(), INTERVAL 1 YEAR) AND e.created_at <= NOW()";
                        break;
                }

                $sql .= " GROUP BY expense_date";

                $result = mysqli_query($conn, $sql);

                // Check for errors
                if (!$result) {
                    die("Error in SQL: " . mysqli_error($conn));
                }

                $data = array();

                // Fetch data and group by the specified interval from the expanse table
                while ($row = mysqli_fetch_assoc($result)) {
                    // Use the expense date for grouping
                    $date = date_create($row['expense_date']);
                    $groupKey = date_format($date, $format);

                    if (!isset($data[$groupKey])) {
                        $data[$groupKey] = 0;
                    }

                    // Sum up the total amount for each interval
                    $data[$groupKey] += $row['total_expense'];
                }

                return array('totalexpense' => $data);
            }




            // Display data by default (last 7 days)
            $data = fetchDataForChart('last-7-days', 'Y-m-d', $conn);
            ?>

            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

            <script>
    var myChart; // Variable to hold the Chart.js instance

    // Function to create a stylish Chart.js line chart
    function createChart(data) {
        var ctx = document.getElementById('myChart').getContext('2d');

        // Check if a chart instance exists, destroy it before creating a new one
        if (window.myChart) {
            window.myChart.destroy();
        }

        var labels = [];
        var values = [];

        // Extract keys (labels) and values from the data.totalExpense array
        for (var key in data.totalExpense) {
            labels.push(key);
            values.push(data.totalExpense[key]);
        }

        // Define vibrant and deeper colors for the line
        var lineColor = 'rgba(75, 192, 192, 1)';

        window.myChart = new Chart(ctx, {
            type: 'line', // Change type to line
            data: {
                labels: labels,
                datasets: [{
                    label: 'Total Expense',
                    data: values,
                    fill: true,
                    borderColor: lineColor,
                    borderWidth: 2,
                    backgroundColor: 'rgba(75, 192, 192, 0.2)'
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

    // Function to fetch data and update the chart
    function fetchDataAndCreateChart(filter) {
        $.ajax({
            method: 'POST',
            url: 'exp_update.php',
            data: {
                filter: filter
            },
            dataType: 'json',
            cache: false,
            success: function(response) {
                if (response.error) {
                    console.error('Error:', response.error);
                } else {
                    // Call the function to create the chart
                    createChart(response.data);
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error:', error);
            }
        });
    }

    // Bind the fetchDataAndCreateChart function to the change event of the select box
    $('#interval').change(function() {
        var selectedFilter = $(this).val();
        fetchDataAndCreateChart(selectedFilter);
    });

    // Initial data fetch and chart creation on page load
    var initialFilter = $('#interval').val();
    fetchDataAndCreateChart(initialFilter);
</script>




        </div>
    </div>
</div>

<?php include_once('includes/footer.php'); ?>