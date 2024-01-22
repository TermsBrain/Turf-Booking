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
            <h1 class="page-header">Staff</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <table id="yourTableID" class="table table-dark table-striped">
            <thead>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <?php if ($_SESSION['role'] != 'manager') : ?>
                    <th>Status</th>
                <?php endif; ?>
                <th>Action</th>
            </thead>
            <tbody>
                <?php
                $query = "SELECT * FROM authentication";
                $sql = mysqli_query($conn, $query);
                while ($row = mysqli_fetch_array($sql)) { ?>
                    <tr>
                        <td><?php echo $row['id'] ?></td>
                        <td><?php echo $row['name'] ?></td>
                        <td><?php echo $row['email'] ?></td>
                        <td><?php echo $row['role'] ?></td>
                        <?php if ($_SESSION['role'] != 'manager') : ?>
                            <td>
                                <input <?php echo ($row['role']!='admin') ? '' : 'disabled' ?> type="checkbox" <?php echo $row['status'] == 1 ? 'checked' : ''; ?> class="status-toggle" data-id="<?php echo $row['id']; ?>">
                            </td>
                        <?php endif; ?>                       
                        <td>
                            <a class="btn btn-primary" href="editStaff.php?id=<?php echo $row['id'] ?>">Edit</a>
                        </td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Include jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Include Bootstrap JavaScript library -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<!-- Include DataTables and its dependencies -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
<script type="text/javascript" src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>

<!-- Your custom scripts -->
<script>
    $(document).ready(function() {
        $('#yourTableID').DataTable({
            dom: 'Bfrtip',
            buttons: ['copy', 'csv', 'excel', 'pdf', 'print']
        });

        // Add event listener for the checkbox change event
        $('.status-toggle').change(function() {
            var status = this.checked ? 1 : 0;
            var userId = $(this).data('id');
            console.log(status);
            console.log(userId);
            // Use Ajax to send a request to updateStatus.php
            $.ajax({
                type: 'POST',
                url: 'api/updateStatus.php',
                data: {
                    id: userId,
                    status: status
                },
                success: function(response) {
                    // Handle the response if needed
                    console.log(response);
                },
                error: function(error) {
                    console.log(error);
                }
            });
        });
    });
</script>

<?php include_once('includes/footer.php'); ?>