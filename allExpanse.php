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
    #yourTableID {
        width: 100%;
        margin-top: 20px;
    }

    #yourTableID th,
    #yourTableID td {
        text-align: center;
    }

    #yourTableID th {
        background-color: #f8f9fa;
        color: #343a40;
    }

    #yourTableID tbody tr:hover {
        background-color: #f8f9fa;
        color: #343a40;
    }

    /* Style for the modal */
    .modal-content {
        background-color: #f8f9fa;
    }

    .modal-footer {
        background-color: #343a40;
        color: #ffffff;
    }

    /* Style for the toggle checkbox */
    .status-toggle {
        appearance: none;
        width: 50px;
        /* Adjust the width as needed */
        height: 30px;
        /* Adjust the height as needed */
        border-radius: 15px;
        /* Adjust the border-radius as needed */
        background-color: red;
        /* Background color when unchecked */
        position: relative;
        cursor: pointer;
        outline: none;
    }

    .status-toggle:checked {
        background-color: green;
        /* Background color when checked */
    }

    .status-toggle:before {
        content: '';
        position: absolute;
        width: 25px;
        /* Adjust the handle width as needed */
        height: 30px;
        /* Adjust the handle height as needed */
        border-radius: 50%;
        background-color: #ddd;
        /* Handle color */
        transition: 0.3s;
    }

    .status-toggle:checked:before {
        transform: translateX(25px);
        /* Adjust the handle position when checked */
    }
</style>
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header text-center">Expanse</h1>
        </div>
    </div>
    <div class="row">
        <table id="yourTableID" class="table table-striped table-bordered" cellspacing="0" width="100%">
            <caption class="text-center">See All Expanses</caption>
            <thead>
                <th>ID</th>
                <th>Description</th>
                <th>Amount</th>
                <th>Note</th>
                <th>Reference</th>
                <th <?php echo (isset($_SESSION['role']) && $_SESSION['role'] != 'admin') ? 'hidden' : '' ?>>Action</th>
            </thead>
            <tbody>
                <?php
                $query = "SELECT expanse.*, authentication.name FROM expanse
                LEFT JOIN authentication ON expanse.reference_id = authentication.id";
                $sql = mysqli_query($conn, $query);
                while ($row = mysqli_fetch_array($sql)) { ?>
                    <tr>
                        <td><?php echo $row['id'] ?></td>
                        <td><?php echo $row['description'] ?></td>
                        <td><?php echo $row['amount'] ?></td>
                        <td><?php echo $row['note'] ?></td>
                        <td><?php echo $row['name'] ?></td>
                        <td <?php echo (isset($_SESSION['role']) && $_SESSION['role'] != 'admin') ? 'hidden' : '' ?>>
                            <a href="editExpanse.php?id=<?php echo $row['id']; ?>" class="btn btn-primary">Edit</a>
                        </td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Include jQuery and Bootstrap JavaScript library -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<!-- Include DataTables and its dependencies -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
<script type="text/javascript" src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">
<!-- Your custom scripts -->
<script>
    $(document).ready(function() {
        $('#yourTableID').DataTable({
            "dom": '<"row mb-3"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>' +
                '<"row"<"col-sm-12"B>>' +
                '<"row"<"col-sm-12"tr>>' +
                '<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>',
            "paging": true,
            "autoWidth": true,
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
                            return 'Staff List - CSV';
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
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ],
            "pageLength": 10,
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