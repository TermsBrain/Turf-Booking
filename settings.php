<?php
session_start();

if (!isset($_SESSION['id']) || $_SESSION['role'] != 'admin') {
    header('Location: login.php');
    exit;
}

include_once('includes/header.php');
?>

<style>
    #page-wrapper {
        padding: 20px;
        background-color: #fff;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .form-group {
        margin-bottom: 20px;
    }

    label {
        font-weight: bold;
    }

    .btn-primary {
        background-color: #007bff;
        color: #fff;
    }

    /* New styles for the row */
    .row-with-box-shadow {
        background-color: #fff;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        margin: 20px 0;
        /* Adjust the margin as needed */
        padding: 20px;
    }
</style>

<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Settings</h1>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-lg-6 mx-auto">
                <form action="" method="POST" enctype="multipart/form-data">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">Brand Information</h3>
                        </div>
                        <div class="panel-body">
                            <div class="form-group col-md-12">
                                <label for="brand">Brand Name:</label>
                                <input type="text" class="form-control" id="brand" name="brand" placeholder="Enter Your Brand Name" required>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="email">Email:</label>
                                    <input type="email" class="form-control" id="email" name="email" placeholder="Enter Your Email" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="phone">Contact No.:</label>
                                    <input type="tel" class="form-control" id="phone" name="phone" placeholder="Enter Your Phone Number" required>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="location">Location:</label>
                                    <input type="text" class="form-control" id="location" name="location" placeholder="Enter Your location" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="social">Social Media:</label>
                                    <input type="text" class="form-control" id="social" name="social" placeholder="e.g., Facebook, Twitter">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">Logo and Favicon</h3>
                        </div>
                        <div class="panel-body">
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="favicon">Favicon:</label>
                                    <input type="file" class="form-control" id="favicon" name="favicon" accept="image/*">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="logo">Brand Logo:</label>
                                    <input type="file" class="form-control" id="logo" name="logo" accept="image/*">
                                </div>
                            </div>
                        </div>
                    </div>

                    <button type="submit" name="submit" class="btn btn-primary">Save Settings</button>
                </form>

            </div>
        </div>
    </div>
</div>
<!-- Success Modal -->
<div class="modal fade" id="successModal" tabindex="-1" role="dialog" aria-labelledby="successModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="successModalLabel">Success!</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p id="successMessage"></p>
            </div>
        </div>
    </div>
</div>

<!-- Error Modal -->
<div class="modal fade" id="errorModal" tabindex="-1" role="dialog" aria-labelledby="errorModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="errorModalLabel">Error!</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p id="errorMessage"></p>
            </div>
        </div>
    </div>
</div>
<?php include_once('includes/footer.php'); ?>


<?php
include("connection.php");

if (isset($_POST['submit'])) {
    $brand = $_POST['brand'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $location = $_POST['location'];
    $social = $_POST['social'];

    $favicon = $_FILES['favicon']['name'];
    $logo = $_FILES['logo']['name'];

    $favicon = $_FILES['favicon']['name'];
    $logo = $_FILES['logo']['name'];



    // Additional debugging statement
    echo 'Debugging Information: ' . print_r($_FILES, true);

    // File upload paths
    $faviconPath = 'assets/uploads/' . $favicon;
    $logoPath = 'assets/uploads/' . $logo;

    // Move uploaded files to the specified paths
    if (
        move_uploaded_file($_FILES['favicon']['tmp_name'], $faviconPath) &&
        move_uploaded_file($_FILES['logo']['tmp_name'], $logoPath)
    ) {

        // Rest of your code...
        $q = "INSERT INTO `setting` (brand, favicon, logo, email, phone, location, social) VALUES (?, ?, ?, ?, ?, ?, ?)";

        $stmt = mysqli_prepare($conn, $q);
        mysqli_stmt_bind_param($stmt, 'sssssss', $brand, $favicon, $logo, $email, $phone, $location, $social);

        if (mysqli_stmt_execute($stmt)) {
            echo '<script>
                    $("#successMessage").text("Successfully Added");
                    $("#successModal").modal("show");
                  </script>';
        } else {
            echo '<script>
                    $("#errorMessage").text("Error: ' . mysqli_error($conn) . '");
                    $("#errorModal").modal("show");
                  </script>';
        }

        mysqli_stmt_close($stmt);
    } else {
        // File upload failed: Show error modal and debugging information
        echo '<script>
                $("#errorMessage").text("File upload failed.");
                $("#errorModal").modal("show");
              </script>';
    }
}
?>