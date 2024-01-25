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
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-zt4p0WigVNZ71UKsgm3q2Kd6BP3sXcFRwhPQc9zLbU/GyZHPsAxe90BRsdMr1yejzEFB5xbjNc9PnByhJkTKZw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<style>
        #page-wrapper {
            text-align: center;
        }

        #yourTableID {
            margin: 0 auto;
            width: 80%;
        }
    </style>


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
                    <th>Status</th>
                    <th>Invoice</th>
                </thead>
                <tbody>
                    <?php
                    $query = "SELECT transaction.*, customers.phone as phone
                    FROM transaction 
                    LEFT JOIN customers ON transaction.user_id = customers.id
                    ORDER BY transaction.due DESC";
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
                            <td><a style="display: inline-block; font-size: 30px; text-align: center; text-decoration: none; color: #fff; border-radius: 5px; " href="invoice.php?id=<?php echo $row['id'] ?>">
                                    <svg style="margin-right: 10px; color: #ffd700; font-size: 30px;" class="fas fa-file-invoice" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 30 30" width="30" height="30">
                                        <path d="M4 1h16a2 2 0 0 1 2 2v18a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2zm14 6H6a1 1 0 0 0 0 2h12a1 1 0 0 0 0-2zM6 14h12a1 1 0 0 0 0-2H6a1 1 0 0 0 0 2zm0 4h12a1 1 0 0 0 0-2H6a1 1 0 0 0 0 2z" />
                                    </svg>
                                </a></td>

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
            dom: 'Blfrtip',
            responsive: true,
            buttons: ['copy', 'csv', 'excel', 'pdf', 'print'],
            order: [[4, 'desc']] // Assuming 'due' is the fifth column (index 4)
        });
    });
</script>

<?php include_once('includes/footer.php'); ?>