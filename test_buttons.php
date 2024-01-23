<?php
session_start();
include 'connection.php';

if (!isset($_SESSION['id']) || !isset($_SESSION['role']) || !isset($_SESSION['status'])) {
    header('Location: login.php');
    exit;
}

include_once('includes/header.php');
?>

<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header text-center">Buttons</h1>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12 text-center">
            <div id="buttonContainer" class="row align-items-center justify-content-center">
                <!-- here is the buttons -->
            </div>
        </div>
    </div>

    <script>
        var buttonContainer = document.getElementById('buttonContainer');
        var numberOfButtons = 10;

        for (var i = 1; i <= numberOfButtons; i++) {
            var newButton = document.createElement('button');
            newButton.setAttribute('class', 'btn btn-primary m-2 col-lg-3 col-xs-12 col-md-4 text-center');
            newButton.setAttribute('style', 'padding: 10px; margin: 5px;');
            newButton.innerText = 'Button ' + i;

            buttonContainer.appendChild(newButton);
        }
    </script>

</div>

<?php include_once('includes/footer.php'); ?>
