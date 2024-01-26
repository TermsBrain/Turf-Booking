<?php
session_start();

include 'connection.php';

if (!isset($_SESSION['id']) || !isset($_SESSION['role'])) {
    header('Location: login.php');
    exit;
}

include_once('includes/header.php');
?>
<style>
    .filter-container {
        background-color: #e1f7d5;
        margin-bottom: 20px;
        padding: 15px;
        border-radius: 8px;
    }
</style>


<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header text-center">time_slot Reports</h1>
        </div>
    </div>
    <div class="row">
        <div class=" mt-4">
            <!-- Filter Select Box -->
            <div class="filter-container">
                <h3 class="text-center">time_slot</h3>
            </div>
        </div>
    </div>


<?php include_once('includes/footer.php'); ?>