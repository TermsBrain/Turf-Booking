<?php
session_start();
include 'connection.php';

function displayErrorModal($message)
{
    echo <<<HTML
    <div id="errorModal" class="modal">
        <div class="modal-content" style="text-align: center;">
            <span class="close" onclick="closeModal()">&times;</span>
            <p style="font-weight: bold; color: black; display: inline-block;">$message</p>
        </div>
    </div>
    <script>
        // Function to close the modal
        function closeModal() {
            var modal = document.getElementById('errorModal');
            modal.style.display = 'none';
        }
        // Display the modal on page load
        window.onload = function() {
            var modal = document.getElementById('errorModal');
            modal.style.display = 'block';
        };
    </script>
HTML;
}

if (isset($_SESSION['id']) && isset($_SESSION['role']) && isset($_SESSION['status'])) {
    if ($_SESSION['role'] == 'admin' || $_SESSION['role'] == 'manager') {
        if ($_SESSION['status'] == 1) {
            header('Location: index.php');
            exit;
        } else {
            echo "Your account is not active.";
        }
    }
}

if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $query = "SELECT * FROM authentication WHERE email = ? AND password = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "ss", $email, $password);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_array($result);
    

    if ($row) {
        $id = $row['id'];
        $role = $row['role'];
        $status = $row['status'];

        $_SESSION['id'] = $id;
        $_SESSION['role'] = $role;
        $_SESSION['status'] = $status;

        // Admin login
        if ($role == 'admin') {
            header('Location: index.php');
            exit;
        }
        //Manager login
        else if ($role == "manager") {
            header('Location: index.php');
            exit;
        } else {
            // Incorrect password, display error modal
            displayErrorModal("Wrong Email or Password");
        }
    } else {
        // Incorrect email or password, display error modal
        displayErrorModal("Wrong Email or Password");
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Turf Management System Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f4;
        margin: 0;
        padding: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        height: 100vh;
    }

    .main {
        background-color: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        width: 300px;
    }

    .form {
        text-align: center;
    }

    .form_title {
        margin-bottom: 20px;
        color: #333;
    }

    .form__input {
        width: 100%;
        padding: 10px;
        margin-bottom: 15px;
        box-sizing: border-box;
        border: 1px solid #ccc;
        border-radius: 4px;
    }

    .form__button {
        width: 100%;
        padding: 10px;
        background-color: #4caf50;
        color: #fff;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }

    .form__button:hover {
        background-color: #45a049;
    }

    .form_title {
        margin-bottom: 20px;
        color: #333;
        font-size: 24px;
        text-transform: uppercase;
        letter-spacing: 2px;
    }

    .form_title::after {
        content: '';
        display: block;
        width: 50%;
        margin: 10px auto;
        border-bottom: 2px solid #3498db;
    }

    .modal {
        display: none;
        position: fixed;
        top: 40;
        left: 38%;
        width: 320px;
        height: 50px;
        background-color: rgba(255, 158, 137);
        justify-content: center;
        align-items: center;
    }

    .modal-content {
        background-color: #fefefe;
        padding: 20px;
        border-radius: 8px;
    }

    .close {
        color: #aaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
        cursor: pointer;
    }

    .close:hover {
        color: #333;
    }

    .powered-by {
        text-align: center;
        margin-top: 20px;
        color: #555;
    }

    .powered-by a {
        color: #3498db;
        text-decoration: none;
    }

    .powered-by a:hover {
        text-decoration: underline;
    }
</style>

<body>
    <div class="main">
        <div class="container b-container" id="b-container">
            <form class="form" id="b-form" method="post" action="login.php">
                <h2 class="form_title title">Turf Management System</h2>
                <h2>LOGIN</h2>
                <input class="form__input" type="email" name="email" placeholder="Email" required>
                <input class="form__input" type="password" name="password" placeholder="Password" required>
                <button type="submit" name="submit" value="submit" class="form__button button submit">SIGN IN</button>
            </form>
        </div>
        <div class="powered-by">
            <p>Powered By <a href="https://termsbrain.com" target="_blank">TermsBrain</a></p>
        </div>
    </div>

</body>

</html>