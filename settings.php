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
        margin: 20px 0; /* Adjust the margin as needed */
        padding: 20px;
    }
</style>

<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Settings</h1>
        </div>
    </div>

    <div class="row" style="margin-left: px;">
        <div class="col-lg-6">
            <form action="process_settings.php" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="name">Brand Name:</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Enter Your Brand Name" required>
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Enter Your Email" required>
                </div>
                <div class="form-group">
                    <label for="phone">Contact No.:</label>
                    <input type="tel" class="form-control" id="phone" name="phone" placeholder="Enter Your Phone Number" required>
                </div>
                <div class="form-group">
                    <label for="address">Address:</label>
                    <input type="text" class="form-control" id="address" name="address" placeholder="Enter Your Address" required>
                </div>
                <div class="form-group">
                    <label for="social">Social Media:</label>
                    <input type="text" class="form-control" id="social" name="social" placeholder="e.g., Facebook, Twitter">
                </div>
                <div class="form-group">
                    <label for="favicon">Favicon:</label>
                    <input type="file" class="form-control-file" id="favicon" name="favicon" accept="image/*">
                </div>
                <div class="form-group">
                    <label for="logo">Brand Logo:</label>
                    <input type="file" class="form-control-file" id="logo" name="logo" accept="image/*">
                </div>
                <button type="submit" class="btn btn-primary">Save Settings</button>
            </form>
        </div>
    </div>
</div>

<?php include_once('includes/footer.php'); ?>
