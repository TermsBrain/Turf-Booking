<?php
session_start();
include 'connection.php';

if (!isset($_SESSION['id']) || $_SESSION['role'] != 'admin') {
    header('description: login.php');
    exit;
}

include_once('includes/header.php');
?>
<style>
    .container-center {
        display: flex;
        justify-content: center;
        align-items: center;
    }
</style>

<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header text-center">Add Expense</h1>
        </div>
        <div class="row container-center">
            <div class="col-md-6">
                <form class="form-horizontal form-label-left" action="" method="POST">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <h3 class="panel-title text-center " style="font-weight: bold;">Add Expense</h3>
                        </div>
                        <div class="panel-body">
                            <div class="form-group">
                                <div class="col-md-12">
                                    <label>Description</label>
                                </div>
                                <div class="col-md-12">
                                <textarea rows="3" style="height:100%;" type="text" class="form-control" name="description" id="description" placeholder="Enter description"></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-12">
                                    <label>Amount</label>
                                </div>
                                <div class="col-md-12">
                                    <input type="number" name="amount" class="form-control" placeholder="Enter amount">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-12">
                                    <label>Note</label>
                                </div>
                                <div class="col-md-12">
                                <textarea rows="2" style="height:100%;" type="text" class="form-control" name="note" id="note" placeholder="Enter Note If needed"></textarea>
                                </div>
                            </div>
                            <div class="text-center">
                                <input type="submit" name="submit" class="btn btn-primary text-center" value="Add Expense">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Success and Error Modals -->
<div class="modal fade" id="successModal" tabindex="-1" role="dialog" aria-labelledby="successModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="successModalLabel">Success</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="successMessage">
                <!-- Success message will be displayed here -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="errorModal" tabindex="-1" role="dialog" aria-labelledby="errorModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="errorModalLabel">Error</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="errorMessage">
                <!-- Error message will be displayed here -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<?php
include("connection.php");
if (isset($_POST['submit'])) {
    // to receive value from the input fields
    $description = $_POST['description'];
    $amount = $_POST['amount'];
    $note = $_POST['note'];
    $reference_id = $_SESSION['id'];
    $status = 1;  // Set status to 1
    
    $q = "INSERT INTO expense (description, amount, note, reference_id, status) VALUES ('$description', '$amount', '$note', '$reference_id', '$status')";
    if (mysqli_query($conn, $q)) {
        // Trigger the success modal
        echo '<script>
                $("#successMessage").text("Successfully Added");
                $("#successModal").modal("show");
              </script>';
    } else {
        // Trigger the error modal
        echo '<script>
                $("#errorMessage").text("Error: ' . mysqli_error($conn) . '");
                $("#errorModal").modal("show");
              </script>';
    }
}
?>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<?php include_once('includes/footer.php'); ?>