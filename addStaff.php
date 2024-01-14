<?php
session_start();
include 'connection.php';

if (!isset($_SESSION['id']) || $_SESSION['role'] != 'admin') {
    header('Location: login.php');
   exit;
}

include_once('includes/header.php');
?>

<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Add Staff</h1>
        </div>
        <div class="row">
            <div class="col-md-6">
                <form class="form-horizontal form-label-left" action="" method="POST">
                    <div class="form-group">
                        <div class="col-md-12">
                            <label>Name</label>
                        </div>
                        <div class="col-md-12">
                            <input type="text" name="name" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-12">
                            <label>Email</label>
                        </div>
                        <div class="col-md-12">
                            <input type="email" name="email" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-12">
                            <label>Password</label>
                        </div>
                        <div class="col-md-12">
                            <input type="text" name="password" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-12">
                            <label for="role">Role</label>
                        </div>
                        <div class="col-md-12">
                            <select name="role" class="form-control">
                                <option value="admin">Admin</option>
                                <option value="manager">Manager</option>
                                <option value="staff">Staff</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group" hidden>
                        <div class="col-md-12">
                            <label>Status</label>
                        </div>
                        <div class="col-md-12">
                            <input type="text" name="status" class="form-control" value="0">
                        </div>
                    </div>
                    <input type="submit" name="submit" class="btn btn-primary" value="Add Staff">
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
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = $_POST['role'];
    $status = $_POST['status'];

    $q = "INSERT INTO authentication (name, email, password, role, status) VALUES ('$name', '$email', '$password', '$role', '$status')";
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
