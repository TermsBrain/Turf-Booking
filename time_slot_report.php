<?php
session_start();
if (!isset($_SESSION['id']) || !isset($_SESSION['role'])) {
    header('Location: login.php');
    exit;
}
include 'connection.php';
include_once('includes/header.php');
?>

<style>
    .filter-container {
        background-color: #e1f7d5;
        margin-bottom: 20px;
        padding: 15px;
        border-radius: 8px;
    }

    #barChart {
        width: 80%;
        margin: auto;
    }
</style>

<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header text-center">Time Slot Reports</h1>
        </div>
    </div>

    <!-- Add a container for the bar chart -->
    <div class="filter-container">
        <canvas id="barChart"></canvas>
    </div>
</div>

<!-- Include Chart.js library -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    // Use Chart.js to create a bar graph
    var ctx = document.getElementById('barChart').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: <?php echo json_encode($dates); ?>,
            datasets: [{
                label: 'Number of Bookings',
                data: <?php echo json_encode($counts); ?>,
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                x: {
                    type: 'time',
                    time: {
                        unit: 'day',
                        tooltipFormat: 'DD-MM-YYYY'
                    }
                },
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>

<?php include_once('includes/footer.php'); ?>
