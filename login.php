<?php
session_start();
include 'connection.php';

function displayErrorModal($message)
{
    echo <<<HTML
    <div id="errorModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <p>$message</p>
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

if (isset($_SESSION['name']) && isset($_SESSION['role'])) {
    header('Location: index.php');
    exit;
}

if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $query = "SELECT * FROM authentication WHERE email = '$email' AND password='$password'";
    $sql = mysqli_query($conn, $query);
    $row = mysqli_fetch_array($sql);

    if ($row) {
        $role = $row['role'];

        // Admin login
        if ($role == 'admin') {
            $name = $row['name'];
            $_SESSION['name'] = $name;
            $_SESSION['role'] = $role;
            header('Location: index.php');
            exit;
        }
        // Teacher login (uncomment and modify as needed)
        // else if($role == "teacher"){
        //     $username = $row['name'];
        //     $id = $row['id'];
        //     $_SESSION['username'] = $username; 
        //     $_SESSION['id'] = $id; 
        //     $_SESSION['role'] = $role;
        //     header('Location: teacher/dashboard.php');
        //     exit;
        // }
        else {
            // Incorrect password, display error modal
            displayErrorModal("Wrong email or password");
        }
    } else {
        // Incorrect email or password, display error modal
        displayErrorModal("Wrong email or password");
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Turf Login</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <link rel="stylesheet" href="style.css">
</head>
<style>
    :root {
        --bg: #EDF2F0;
        --bg-main: #0A2647;
        --neu-1: #ecf0f3;
        --neu-2: #d1d9e6;
        --white: #f9f9f9;
        --gray: #a0a5a8;
        --black: #181818;
        --purple: #4B70E2;
        --transition: 1.25s;
    }

    *,
    *::after,
    *::before {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        user-select: none;
    }

    body {
        width: 100%;
        height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
        font-family: 'Montserrat', sans-serif;
        font-size: 12px;
        background-color: var(--bg-main);
        color: var(--gray);
    }

    .main {
        position: relative;
        width: 600px;
        min-width: 400px;
        min-height: 600px;
        height: 600px;
        background-color: var(--neu-1);
        border-radius: 12px;
        overflow: hidden;
    }

    @media (max-width: 1200px) {
        .main {
            transform: scale(0.8);
        }
    }

    @media (max-width: 1000px) {
        .main {
            transform: scale(0.7);
        }
    }

    @media (max-width: 800px) {
        .main {
            transform: scale(0.6);
        }
    }

    @media (max-width: 600px) {
        .main {
            transform: scale(0.5);
        }
    }

    .container {
        display: flex;
        justify-content: center;
        align-items: center;
        position: absolute;
        top: 0;
        width: 100%;
        height: 100%;
        padding: 25px;
        background-color: var(--neu-2);
        transition: var(--transition);
    }

    .form {
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
        width: 100%;
        height: 100%;
    }


    .form__icons i {
        font-size: 2rem;
        cursor: pointer;
        margin: 0 10px;
    }

    .form__input {
        width: 350px;
        height: 40px;
        margin: 4px 0;
        padding-left: 25px;
        font-size: 16px;
        letter-spacing: 0.15px;
        border: none;
        outline: none;
        font-family: 'Montserrat', sans-serif;
        background-color: var(--neu-1);
        transition: 0.25s ease;
        border-radius: 8px;
        box-shadow: inset 2px 2px 4px var(--neu-2), inset -2px -2px 4px var(--white);
    }

    .form__input:focus {
        box-shadow: inset 4px 4px 4px var(--neu-2), inset -4px -4px 4px var(--white);
    }

    .form__span {
        margin-top: 30px;
        margin-bottom: 12px;
        font-size: 18px;
    }

    .form__link {
        color: var(--black);
        font-size: 15px;
        margin-top: 25px;
        border-bottom: 1px solid var(--gray);
        line-height: 2;
        cursor: pointer;
    }

    .title {
        font-size: 34px;
        font-weight: 700;
        line-height: 3;
        color: var(--black);
    }

    .description {
        font-size: 14px;
        letter-spacing: 0.25px;
        text-align: center;
        line-height: 1.6;
    }

    .button {
        width: 180px;
        height: 50px;
        border-radius: 25px;
        margin-top: 50px;
        font-weight: 700;
        font-size: 14px;
        letter-spacing: 1.15px;
        background-color: var(--purple);
        color: var(--white);
        box-shadow: 8px 8px 16px var(--neu-2), -8px -8px 16px var(--white);
        border: none;
        outline: none;
        cursor: pointer;
    }

    .button:active,
    .button:focus {
        box-shadow:
            2px 2px 6px --neu-2,
            -2px -2px 6px var(--white);
        transform: scale(.97);
        transition: .25s;
    }

    /**/
    .is-txr {
        left: calc(100% - 400px);
        transition: var(--transition);
        transform-origin: left;
    }

    .is-txl {
        left: 0;
        transition: var(--transition);
        transform-origin: right;
    }

    .is-z200 {
        z-index: 200;
        transition: var(--transition);
    }

    .is-hidden {
        visibility: hidden;
        opacity: 0;
        position: absolute;
        transition: var(--transition);
    }

    .is-gx {
        animation: is-gx var(--transition);
    }

    @keyframes is-gx {

        0%,
        10%,
        100% {
            width: 400px;
        }

        30%,
        50% {
            width: 500px;
        }
    }

    /* Add styles for the modal */
    .modal {
        display: none;
        position: fixed;
        z-index: 1;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgb(0, 0, 0);
        background-color: rgba(0, 0, 0, 0.4);
        padding-top: 60px;
    }

    .modal-content {
        background-color: #fefefe;
        margin: 5% auto;
        padding: 20px;
        border: 1px solid #888;
        width: 50%;
    }

    .close {
        color: #aaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
    }

    .close:hover,
    .close:focus {
        color: black;
        text-decoration: none;
        cursor: pointer;
    }
</style>

<body>
    <div class="main">
        <div class="container b-container" id="b-container">
            <form class="form" id="b-form" method="post" action="login.php">
                <h2 class="form_title title">Sign in to Website</h2>
                <div class="form__icons">
                    <i class='bx bxl-facebook-circle'></i>
                    <i class='bx bxl-instagram-alt'></i>
                    <i class='bx bxl-twitter'></i>
                </div>
                <span class="form__span">or use your email account</span>
                <input class="form__input" type="email" name="email" placeholder="Email">
                <input class="form__input" type="password" name="password" placeholder="Password">
                <a class="form__link" href="#">Forgot your password?</a>
                <button type="submit" name="submit" value="submit" class="form__button button submit">SIGN IN</button>
            </form>
        </div>
    </div>
</body>

</html>
</body>

</html>