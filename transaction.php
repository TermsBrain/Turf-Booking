<?php
session_start();
if (!isset($_SESSION['id']) || !isset($_SESSION['role'])) {
    header('Location: login.php');
    exit;
}
include 'connection.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if the "status" button is clicked
    if (isset($_POST['updatestatus']) && isset($_POST['transactionId'])) {
        $transactionId = $_POST['transactionId'];

        // Retrieve the current "due" and "cash" values
        $query = "SELECT due, cash FROM transaction WHERE id = $transactionId";
        $result = mysqli_query($conn, $query);

        if ($row = mysqli_fetch_assoc($result)) {
            $dueValue = $row['due'];
            $cashValue = $row['cash'];
            $status = $row['status'];

            // Perform the update to set "due" to 0 and add "due" to "cash"
            $updateQuery = "UPDATE transaction SET due = 0, status = 1, cash = cash + $dueValue WHERE id = $transactionId";

            $updateResult = mysqli_query($conn, $updateQuery);

            if ($updateResult) {
                // Redirect or perform any additional actions after the update
                header('Location: transaction.php');
                exit;
            } else {
                // Handle the update failure
                echo "Failed to update due value and add to cash.";
            }
        } else {
            // Handle error if the transaction ID is not valid
            echo "Invalid transaction ID.";
        }
    }
}
include_once('includes/header.php');
?>

<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Transaction</h1>
        </div>
    </div>
    <div class="row">
        <div class="table-responsive">
            <table id="yourTableID" class="table table-dark table-striped">
                <thead>
                    <th>Date</th>
                    <th>Contact</th>
                    <th>Advance</th>
                    <th>Cash</th>
                    <th>Due</th>
                    <th>Total</th>
                    <th>Method</th>
                    <th>Action</th>
                    <th>status</th>
                </thead>
                <tbody>
                    <?php
                    $query = "SELECT transaction.*, customers.phone as phone FROM transaction 
                          LEFT JOIN customers ON transaction.user_id = customers.id";
                    $sql = mysqli_query($conn, $query);

                    while ($row = mysqli_fetch_array($sql)) { ?>
                        <tr>
                            <td><?php
                                $temp = $row['created_at'];
                                $dates = explode(' ', $temp);
                                echo $dates[0];
                                ?></td>
                            <td><?php echo $row['phone'] ?></td>
                            <td><?php echo $row['advance'] ?></td>
                            <td><?php echo $row['cash'] ?></td>
                            <td><?php echo $row['due'] ?></td>
                            <td><?php echo $row['total'] ?></td>
                            <td><?php echo $row['method'] ?></td>
                            <td>
                                <a class="btn btn-primary" href="editTransaction.php?id=<?php echo $row['id'] ?>">Edit</a>
                            </td>
                            <td>
                                <?php
                                // Set button color and label based on the value of "Due" and "Status"
                                $buttonColor = ($row['due'] == 0) ? 'btn-success' : 'btn-danger';
                                $buttonLabel = ($row['due'] == 0) ? 'Paid' : 'Unpaid';

                                // Output the button with dynamic color and label, conditionally disabling it
                                echo '<form method="post" action="">
                                            <input type="hidden" name="transactionId" value="' . $row['id'] . '">
                                            <button type="submit" class="btn ' . $buttonColor . '" name="updatestatus" ' . ($row['due'] == 0 && $row['status'] == 1 ? 'disabled' : '') . '>' . $buttonLabel . '</button>
                                        </form>';
                                ?>
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