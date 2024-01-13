<?php
session_start();

if (!isset($_SESSION['name']) || !isset($_SESSION['role'])) {
    header('Location: login.php');
    exit;
}
include 'connection.php';
include_once('includes/header.php');
?>

<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Transaction</h1>
        </div>
    </div>
    <div class="row">
        <table id="yourTableID" class="table table-dark table-striped">
            <thead>
                <th>ID</th>
                <th>Date</th>
                <th>Contact</th>
                <th>Advance</th>
                <th>Due</th>
                <th>Total</th>
                <th>Method</th>
                <th>Action</th>
            </thead>
            <tbody>
                <?php
                $query = "SELECT transaction.*, customers.phone as phone FROM transaction 
                          LEFT JOIN customers ON transaction.user_id = customers.id";
                $sql = mysqli_query($conn, $query);

                while ($row = mysqli_fetch_array($sql)) { ?>
                    <tr>
                        <td><?php echo $row['id'] ?></td>
                        <td><?php
                            $temp = $row['created_at'];
                            $dates = explode(' ',$temp);
                            echo $dates[0];
                        ?></td>
                        <td><?php echo $row['phone'] ?></td>
                        <td><?php echo $row['advance'] ?></td>
                        <td><?php echo $row['due'] ?></td>
                        <td><?php echo $row['total'] ?></td>
                        <td><?php echo $row['method'] ?></td>
                        <td>
                            <a class="btn btn-primary" href="editTransaction.php?id=<?php echo $row['id'] ?>">Edit</a>
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