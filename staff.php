<?php
session_start();

if (!isset($_SESSION['name']) || !isset($_SESSION['role'])) {
    header('Location: login.php');
    exit;
}
include 'connection.php';
include_once('includes/header.php');
?>

<link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>
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
                        

                        <td>
                            <style>
                                .toggle.ios,
                                .toggle-on.ios,
                                .toggle-off.ios {
                                    border-radius: 20rem;
                                }

                                .toggle.ios .toggle-handle {
                                    border-radius: 20rem;
                                }
                            </style>
                            <input type="checkbox" checked data-toggle="toggle" data-on="Active" data-off="Deactive" data-onstyle="success" data-offstyle="danger">
                            <a class="btn btn-primary" href="editCustomer.php?id=<?php echo $row['id'] ?>">Edit</a>
                            <button class="btn btn-danger" data-toggle="modal" data-target="#myModal<?php echo $row['id'] ?>">Delete</button>
                            <!-- Delete Modal -->
                            <div class="modal fade" id="myModal<?php echo $row['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title">Confirmation</h4>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            Are you sure you want to delete <strong><?php echo $row['name'] ?></strong>?
                                        </div>
                                        <div class="modal-footer">
                                            <a class="btn btn-success" href="deleteCustomer.php?id=<?php echo $row['id'] ?>">Delete</a>
                                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
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

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">
<script type="text/javascript" src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>


<!-- Add DataTables initialization script -->
<script>
    $(document).ready(function() {
        $('#yourTableID').DataTable({
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ]
        });
    });
</script>

<?php include_once('includes/footer.php'); ?>