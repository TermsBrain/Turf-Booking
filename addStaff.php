<?php
session_start();

if (!isset($_SESSION['name']) || !isset($_SESSION['role'])) {
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
    </div>
</div>

<?php include_once('includes/footer.php'); ?>
