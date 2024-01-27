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
            <h1 class="page-header text-center">Booking Details</h1>
        </div>
    </div>
    <div class="row">
        <div class="table-responsive">
            <table id="yourTableID" class="table table-striped table-bordered">
                <thead>
                    <th>Booked On</th>
                    <th>Booked For</th>
                    <th>Contact</th>
                    <th>Slot Time</th>
                    <th>Booked By</th>
                    <th>Status</th>
                    <!-- <th>Action</th> -->
                </thead>
                <tbody>
                    <?php
                    $query = "SELECT booking.id as booking_id,
                    booking.created_at as booked_on_date,
                        booking.date as booking_date,
                        authentication.name as ref_name,
                        transaction.status as transaction_status,
                        customers.name as cus_name,
                        customers.phone as phone, 
                        start_slot.start_time as start_time, 
                        end_slot.end_time as end_time
                 FROM booking 
                 LEFT JOIN authentication ON booking.reference_id = authentication.id
                 LEFT JOIN customers ON booking.user_id = customers.id
                 LEFT JOIN transaction ON booking.transaction_id = transaction.id
                 LEFT JOIN slot_management AS start_slot ON booking.start_slot_id = start_slot.id
                 LEFT JOIN slot_management AS end_slot ON booking.end_slot_id = end_slot.id";
                    $sql = mysqli_query($conn, $query);

                    while ($row = mysqli_fetch_array($sql)) { ?>
                        <tr>
                            <!-- <td><?php
                                $temp = $row['booked_on_date'];
                                $dates = explode(' ', $temp);
                                echo $dates[0];
                                ?></td> -->
                                <td><?php echo $row['booked_on_date']; ?></td>
                            <td><?php echo $row['booking_date']; ?></td>
                            <td><?php echo $row['phone']; ?> (<?php echo $row['cus_name']; ?>)</td>
                            <td><?php echo $row['start_time']; ?> - <?php echo $row['end_time']; ?></td>
                            <td><?php echo $row['ref_name']; ?></td>
                            <td><?php echo ($row['transaction_status'] == 0) ? 'Unpaid' : 'Paid'; ?></td>
                            <!-- <td>
                                <a class="btn btn-primary" href="editBooking.php?id=<?php echo $row['booking_id']; ?>">Edit</a>
                            </td> -->
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
<!-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css"> -->
<!-- <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script> -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<!-- <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script> -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>

<!-- Include DataTables Responsive CSS and JS -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.dataTables.min.css">
<script type="text/javascript" src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>


<!-- Include jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Include DataTables CSS and JS -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
<script type="text/javascript" src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.js"></script>

<!-- Include DataTables Buttons CSS and JS -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>

<script>
    $(document).ready(function() {
        $('#yourTableID').DataTable({
            "dom": '<"row mb-3"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>' +
                '<"row"<"col-sm-12"B>>' +
                '<"row"<"col-sm-12"tr>>' +
                '<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>',
            responsive: true,
            "buttons": [{
                    extend: 'copyHtml5',
                    className: 'btn btn-success',
                    text: 'Copy to Clipboard',
                    exportOptions: {
                        title: function() {
                            return 'Custom File Name - Copy';
                        }
                    }
                },
                {
                    extend: 'csvHtml5',
                    className: 'btn btn-warning',
                    text: 'Export to CSV',
                    exportOptions: {
                        title: function() {
                            return 'Custom File Name - CSV';
                        }
                    }
                },
                {
                    extend: 'excelHtml5',
                    className: 'btn btn-primary',
                    text: 'Export to Excel',
                    exportOptions: {
                        title: function() {
                            return 'Custom File Name - Excel';
                        }
                    }
                },
                {
                    extend: 'pdfHtml5',
                    className: 'btn btn-danger',
                    text: 'Export to PDF',
                    exportOptions: {
                        title: function() {
                            return 'Custom File Name - PDF';
                        }
                    }
                },
                'print'
            ],
            "lengthMenu": [
                [15, 25, 50, -1],
                [15, 25, 50, "All"]
            ],
            "pageLength": 15,
            "language": {
                "lengthMenu": "Show _MENU_ entries per page",
                "zeroRecords": "No matching records found",
                "info": "Showing _START_ to _END_ of _TOTAL_ entries",
                "infoEmpty": "Showing 0 to 0 of 0 entries",
                "infoFiltered": "(filtered from _MAX_ total entries)",
                "paginate": {
                    "first": "First",
                    "previous": "Previous",
                    "next": "Next",
                    "last": "Last"
                }
            },
            "initComplete": function(settings, json) {
                // Apply custom styling to the buttons
                var buttons = $('.dt-buttons button');
                buttons.css({
                    'background-color': '#337ab7',
                    'border-radius': '5px',
                    'color': '#fff',
                    'transition': 'background-color 0.3s ease, border-radius 0.3s ease'
                });

                // Add hover effect
                buttons.hover(
                    function() {
                        $(this).css('background-color', '#2d70aa');
                    },
                    function() {
                        $(this).css('background-color', '#337ab7');
                    }
                );

                var searchInput = $('.dataTables_filter input');
                // searchInput.addClass('form-control rounded-pill'); // Bootstrap class for input styling and border-radius
                searchInput.attr('placeholder', 'Search...');
            }
        });
    });
</script>


<?php include_once('includes/footer.php'); ?>