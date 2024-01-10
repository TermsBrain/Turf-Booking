<?php
session_start();

if (!isset($_SESSION['name']) || !isset($_SESSION['role'])) {
    header('Location: login.php');
    exit;
}

include_once('includes/header.php');
?>
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Slot Management</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="card ml-2">
            <div class="card-body">
                <form action="slotManagement.php" method="POST">
                    <h5 class="card-title mb-0">Create Slots</h5>
                    <div class="form-group mt-3">
                        <label>
                            Start Time
                            <small class="text-muted">HH:MM</small></label>
                        <input type="time" class="form-control date-inputmask" name="stime" id="stime" placeholder="Enter Start Time" />
                    </div>
                    <div class="form-group mt-3">
                        <label>
                            Finish Time
                            <small class="text-muted">HH:MM</small></label>
                        <input type="time" class="form-control date-inputmask" name="ftime" id="ftime" placeholder="Enter Finish Time" />
                    </div>
                    <div class="form-group">
                        <label>Slot Interval
                            <small class="text-muted">Interval between slots in minutes</small></label>
                        <input type="number" class="form-control phone-inputmask" name="slotInterval" id="slotInterval" placeholder="Enter Time Interval" />
                    </div>
                    <div class="form-group">
                        <label>Number of Slots
                            <small class="text-muted">Number of slots can be generated</small></label>
                        <input type="number" disabled name="slotNumber" class="form-control purchase-inputmask" id="slotNumber" placeholder="Number of slots" />
                    </div>
                    <button type="submit" name="submit" class="btn btn-primary">
                        Proceed
                    </button>
                </form>
            </div>
        </div>

    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        $(document).ready(function() {
            $("#slotInterval").change(function(event) {
                var startTime = $("#stime").val();
                var endTime = $("#ftime").val();
                var intervalInMinutes = $("#slotInterval").val();
                console.log(startTime, endTime, intervalInMinutes);
                
                // var userHtml = '<div class="d-flex justify-content-end mb-4"><div class="msg_cotainer_send">' + rawText + '<span class="msg_time_send">'+ str_time + '</span></div><div class="img_cont_msg"><img src="https://i.ibb.co/d5b84Xw/Untitled-design.png" class="rounded-circle user_img_msg"></div></div>';
                // $("#text").val("");
                // $("#messageFormeight").append(userHtml);
                
                // window.setTimeout(function(){
                //     var loadingHtml = '<div class="d-flex justify-content-start mb-4"><div class="img_cont_msg"><img src="https://i.ibb.co/MRVSZRX/DALL-E-2023-12-30-11-50-00-A-lifelike-shaggy-brown-dog-inspired-by-the-first-generated-image-of-Prim.jpg" class="rounded-circle user_img_msg"></div><div class="msg_cotainer">Fetching from thread history, please wait...<span class="msg_time">' + str_time + '</span></div></div>';
                //     $("#messageFormeight").append(loadingHtml);
                // }, 800);
                const totalHours = calculateTotalHours(startTime, endTime);
                const timeSlots = generateTimeSlots(startTime, endTime, intervalInMinutes);

                console.log(`Total hours between ${startTime} and ${endTime}: ${totalHours} hours.`);
                console.log("Time slots:");
                timeSlots.forEach(timeSlot => console.log(timeSlot));
                event.preventDefault();
            });

            function calculateTotalHours(startTime, endTime) {
                const startTime24 = new Date('2000-01-01 ' + startTime).toLocaleTimeString('en-US', { hour12: false });
                const endTime24 = new Date('2000-01-01 ' + endTime).toLocaleTimeString('en-US', { hour12: false });

                const startDateTime = new Date('2000-01-01 ' + startTime24);
                const endDateTime = new Date('2000-01-01 ' + endTime24);

                const interval = Math.abs(endDateTime - startDateTime);
                const totalHours = interval / (1000 * 60 * 60);

                return totalHours;
            }

            function generateTimeSlots(startTime, endTime, intervalInMinutes) {
                const timeSlots = [];
                let currentDateTime = new Date('2000-01-01 ' + startTime);

                while (currentDateTime <= new Date('2000-01-01 ' + endTime)) {
                    timeSlots.push(currentDateTime.toLocaleTimeString('en-US', { hour: 'numeric', minute: 'numeric' }));
                    currentDateTime.setMinutes(currentDateTime.getMinutes() + intervalInMinutes);
                }

                return timeSlots;
            }
        });
    </script>	
</div>


<?php 
    // function calculateTotalHours($startTime, $endTime) {
    //     $startTime24 = date('H:i', strtotime($startTime));
    //     $endTime24 = date('H:i', strtotime($endTime));

    //     $startDateTime = new DateTime($startTime24);
    //     $endDateTime = new DateTime($endTime24);

    //     $interval = $startDateTime->diff($endDateTime);

    //     $totalHours = $interval->format('%H') + ($interval->format('%i') / 60);

    //     return $totalHours;
    // }

    // function generateTimeSlots($startTime, $endTime, $intervalInMinutes) {
    //     $timeSlots = [];
    //     $currentDateTime = new DateTime($startTime);

    //     while ($currentDateTime <= new DateTime($endTime)) {
    //         $timeSlots[] = $currentDateTime->format('h:i A');
    //         $currentDateTime->add(new DateInterval('PT' . $intervalInMinutes . 'M'));
    //     }

    //     return $timeSlots;
    // }

    // if (isset($_POST['submit'])) {
    //     // Example usage
    //     $startTime = $_POST['stime'];
    //     $endTime = $_POST['ftime'];
    //     $intervalInMinutes = $_POST['slotInterval'];

    //     $totalHours = calculateTotalHours($startTime, $endTime);
    //     $timeSlots = generateTimeSlots($startTime, $endTime, $intervalInMinutes);

    //     echo "Total hours between $startTime and $endTime: $totalHours hours.<br>". count($timeSlots) ."<br>";
    //     echo "<h3>Time slots:</h3><br>";
    //     foreach ($timeSlots as $timeSlot) {
    //         echo $timeSlot."<br>";
    //     }
    //     echo "<br><h3>------------</h3>";
    // }

    //     $totalHours = calculateTotalHours($startTime, $endTime);
    //     echo "Total hours between $startTime and $endTime: $totalHours hours.";
?>