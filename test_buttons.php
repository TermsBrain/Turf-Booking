<?php
session_start();
include 'connection.php';

if (!isset($_SESSION['id']) || !isset($_SESSION['role']) || !isset($_SESSION['status'])) {
    header('Location: login.php');
    exit;
}

include_once('includes/header.php');
?>
<style>
    #buttonContainer {
        display: flex;
        justify-content: center;
        align-items: center;
        flex-wrap: wrap;
    }
</style>

<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header text-center">Buttons</h1>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12 text-center">
            <div id="buttonContainer" class="d-flex justify-content-center align-items-center mx-auto">
                <!-- here is the buttons -->
            </div>
        </div>
    </div>

    <script>
        var buttonContainer = document.getElementById('buttonContainer');
        var numberOfButtons = 10;

        for (var i = 1; i <= numberOfButtons; i++) {
            var newButton = document.createElement('button');
            newButton.setAttribute('class', 'btn btn-primary m-2 col-lg-3 col-md-4 col-sm-6 col-xs-12 text-center');
            newButton.setAttribute('style', 'padding: 10px; margin: 5px;');
            newButton.innerText = 'Button ' + i;

            buttonContainer.appendChild(newButton);
        }
    </script>
</div>

<?php include_once('includes/footer.php'); ?>