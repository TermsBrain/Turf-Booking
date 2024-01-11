<?php
session_start();

if (!isset($_SESSION['name']) || !isset($_SESSION['role'])) {
    header('Location: login.php');
    exit;
}

include_once('includes/header.php');
?>

<style>
    #page-wrapper {
        padding: 20px;
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
</style>

<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Settings</h1>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6">
            <form action="process_settings.php" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="name">Brand Name:</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>
                <div class="form-group">
                    <label for="phone">Contact No.:</label>
                    <input type="tel" class="form-control" id="phone" name="phone" required>
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
