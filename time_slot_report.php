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
            <h1 class="page-header text-center">Time Slot Reports</h1>
        </div>
    </div>
    <div class="row">
        <div class=" mt-4">
            <!-- Filter Select Box -->
            <div class="filter-container">
                <h3 class="text-center">Time Slot</h3>
                <!-- Chart Container -->
                <div id="timeSlotChart" style="height: 400px;"></div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class=" mt-4">
            <!-- Filter Select Box -->
            <div class="filter-container">
                <label for="interval">Select Interval:</label>
                <select id="interval" name="filter" class="form-select">
                    <option value="monday" <?php echo (!isset($_POST['filter']) || $_POST['filter'] == 'monday') ? 'selected' : ''; ?>>Monday</option>
                    <option value="tuesday" <?php echo (isset($_POST['filter']) && $_POST['filter'] == 'tuesday') ? 'selected' : ''; ?>>Tuesday</option>
                    <option value="wednesday" <?php echo (isset($_POST['filter']) && $_POST['filter'] == 'wednesday') ? 'selected' : ''; ?>>Wednesday</option>
                    <option value="thursday" <?php echo (isset($_POST['filter']) && $_POST['filter'] == 'thursday') ? 'selected' : ''; ?>>Thursday</option>
                    <option value="friday" <?php echo (isset($_POST['filter']) && $_POST['filter'] == 'friday') ? 'selected' : ''; ?>>Friday</option>
                    <option value="saturday" <?php echo (isset($_POST['filter']) && $_POST['filter'] == 'saturday') ? 'selected' : ''; ?>>Saturday</option>
                    <option value="sunday" <?php echo (isset($_POST['filter']) && $_POST['filter'] == 'sunday') ? 'selected' : ''; ?>>Sunday</option>
                </select>
            </div>

            <!-- Stylish Canvas for Chart.js -->
            <div class="card">
                <div class="card-body">
                    <canvas id="timeSlotChart" width="400" height="150"></canvas>
                </div>
            </div>
    <?php
    // Fetch all possible time slots between 12:00 PM and 4:00 PM
    $timeSlots = [];
    $start_time = strtotime('12:00 PM');
    $end_time = strtotime('9:00 PM');

    while ($start_time < $end_time) {
        $timeSlots[] = date('h:i A', $start_time);
        $start_time = strtotime('+60 minutes', $start_time);
    }

    // Convert PHP array to JavaScript array for x-axis
    echo "<script>";
    echo "var timeSlots = " . json_encode($timeSlots) . ";";
    echo "</script>";

    // Fetch data from the database for the current day
    $query = "SELECT 
            TIME_FORMAT(CONVERT_TZ(CONCAT(booking.date, ' ', start_slot.start_time), 'UTC', 'Your_Timezone'), '%h:%i %p') AS time_slot,
            COUNT(booking.id) AS bookings_count
         FROM booking 
         LEFT JOIN slot_management AS start_slot ON booking.start_slot_id = start_slot.id
         WHERE booking.date = CURDATE()
         GROUP BY time_slot";

    $result = mysqli_query($conn, $query);

    // Debugging: Check if the SQL query executes correctly
    if (!$result) {
        die("Error in SQL: " . mysqli_error($conn));
    }

    // Process data for the chart
    $bookedSlots = [];

    while ($row = mysqli_fetch_assoc($result)) {
        $bookedSlots[$row['time_slot']] = $row['bookings_count'];
    }

    // Convert PHP array to JavaScript array for y-axis
    echo "<script>";
    echo "var bookedSlots = " . json_encode($bookedSlots) . ";";
    echo "</script>";

    mysqli_close($conn);
    ?>

    <!-- JavaScript to create the column chart using Highcharts -->
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Highcharts.chart('timeSlotChart', {
                chart: {
                    type: 'column'
                },
                title: {
                    text: 'Booked Slots Count by Time Slot'
                },
                xAxis: {
                    categories: timeSlots,
                    title: {
                        text: 'Time Slot'
                    }
                },
                yAxis: {
                    title: {
                        text: 'Bookings Count'
                    }
                },
                accessibility: {
                    enabled: false
                },
                series: [{
                    name: 'Bookings',
                    data: timeSlots.map(slot => bookedSlots[slot] || 0)
                }]
            });

        });
    </script>
</div>
<?php include_once('includes/footer.php'); ?>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>
