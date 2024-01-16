<?php
session_start();
if (!isset($_SESSION['id']) || !isset($_SESSION['role'])) {
    header('Location: login.php');
    exit;
}
include 'connection.php';
include_once('includes/header.php');
?>

<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Booking Details</h1>
        </div>
    </div>
    <div class="row">
        <div class="table-responsive">
            <table id="yourTableID" class="table table-dark table-striped">
                <thead>
                    <th>Date</th>
                    <th>Contact</th>
                    <th>Start Time</th>
                    <th>End Time</th>
                    <th>Action</th>
                </thead>
                <tbody>
                    <?php
                    $query = "SELECT booking.date as booking_date,
                    customers.phone as phone, 
                    start_slot.start_time as start_time, 
                    end_slot.end_time as end_time
             FROM booking 
             LEFT JOIN customers ON booking.user_id = customers.id
             LEFT JOIN slot_management AS start_slot ON booking.start_slot_id = start_slot.id
             LEFT JOIN slot_management AS end_slot ON booking.end_slot_id = end_slot.id;
             ";
                    $sql = mysqli_query($conn, $query);

                    while ($row = mysqli_fetch_array($sql)) { ?>
                        <tr>
                            <td><?php echo $row['booking_date']; ?></td>
                            <td><?php echo $row['phone']; ?></td>
                            <td><?php echo $row['start_time']; ?></td>
                            <td><?php echo $row['end_time']; ?></td>
                            <td>
                                <!-- <a class="btn btn-primary" href="editBooking.php?id=<?php echo $row['id']; ?>">Edit</a> -->
                            </td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Include jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Include DataTables CSS and JS -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
<script type="text/javascript" src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.js"></script>

<!-- Include DataTables Buttons CSS and JS -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>

<!-- Include DataTables Responsive CSS and JS -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.dataTables.min.css">
<script type="text/javascript" src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>

<script>
    $(document).ready(function() {
        $('#yourTableID').DataTable({
            dom: 'Bfrtip',
            responsive: true,
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ],
            columnDefs: [{
                    "orderable": false,
                    "targets": -2
                }, // Disable sorting for the second-to-last column (Action)
                {
                    "orderable": false,
                    "targets": -1
                } // Disable sorting for the last column (status)
            ]
        });
    });
</script>

<?php include_once('includes/footer.php'); ?>