<?php
session_start();

include 'connection.php';

if (!isset($_SESSION['id']) || !isset($_SESSION['role'])) {
    header('Location: login.php');
    exit;
}

include_once('includes/header.php');
?>
<style>
    .filter-container {
        background-color: #e1f7d5;
        margin-bottom: 20px;
        padding: 15px;
        border-radius: 8px;
    }
</style>


<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header text-center">Advanced Payment Reports</h1>
        </div>
    </div>
    <div class="row">
        <div class=" mt-4">
            <!-- Filter Select Box -->
            <div class="filter-container">
                <h3 class="text-center">Payment Method</h3>
            </div>
        </div>
    </div>
    <div class="row mt-4">
        <!-- Stylish Canvas for Chart.js -->
        <div class="card">
            <div class="card-body">
                <canvas id="paymentChart" width="400" height="400"></canvas>
            </div>
        </div>
    </div>

    <?php
    function fetchDataForPaymentChart($conn)
    {
        $sql = "SELECT `method`, SUM(`total`) AS `total_amount` 
                FROM `transaction` 
                GROUP BY `method`";

        $result = mysqli_query($conn, $sql);

        if (!$result) {
            die("Error in SQL: " . mysqli_error($conn));
        }

        $data = array();

        while ($row = mysqli_fetch_assoc($result)) {
            $data[$row['method']] = $row['total_amount'];
        }

        return $data;
    }

    // Fetch data for the payment chart
    $paymentData = fetchDataForPaymentChart($conn);
    ?>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>

    <script>
    var paymentChart;

    function createPaymentChart(data) {
        var ctx = document.getElementById('paymentChart').getContext('2d');

        if (window.paymentChart) {
            window.paymentChart.destroy();
        }

        var labels = Object.keys(data);
        var values = Object.values(data);

        var pieColors = [
            'rgba(255, 99, 132, 0.8)',
            'rgba(54, 162, 235, 0.8)',
            'rgba(255, 206, 86, 0.8)',
            // Add more colors if needed
        ];

        window.paymentChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: labels,
                datasets: [{
                    data: values,
                    backgroundColor: pieColors,
                    borderWidth: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true,
                        position: 'bottom',
                        labels: {
                            boxWidth: 15,
                            fontSize: 12
                        }
                    },
                    datalabels: {
                        color: 'black', // Change the color to black
                        formatter: (value, context) => {
                            var sum = context.dataset.data.reduce((a, b) => a + b, 0);
                            var percentage = (value / sum * 100).toFixed(2);
                            return percentage + '%';
                        }
                    }
                }
            }
        });
    }

    // Initial chart creation
    createPaymentChart(<?php echo json_encode($paymentData); ?>);
</script>

    <!-- <script src="https://cdn.canvasjs.com/canvasjs.min.js"></script> -->



</div>


<?php include_once('includes/footer.php'); ?>