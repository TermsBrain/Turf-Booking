<?php
session_start();
include 'connection.php';

if (isset($_POST['submit'])) {
    $email = $_POST['email'];

    // Check if the email exists in the database
    $query = "SELECT * FROM authentication WHERE email = '$email'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        $user = mysqli_fetch_assoc($result);

        // Check if the email was found in the database
        if ($user) {
            // Set a session variable to remember the email for password change
            $_SESSION['reset_email'] = $email;

            // Redirect to a page where the user can change their password
            header('Location: changePassword.php');
            exit;
        } else {
            // Display an error message
            echo "<p class='error-message'>Email not found. Please check the entered email address.</p>";
        }
    } else {
        // Display an error message
        echo "<p class='erro-message'>Error checking email. Please try again.</p>";
    }
}
?>
<style>

nav {
    background-color: #0a2647;
    padding: 10px;
    margin-top: 0;
}

ul {
    list-style-type: none;
    margin: 0;
    padding-left: 30px;
    text-align: center;
    text-align: left;
}

li {
    display: inline;
    margin-right: 20px;
}

a {
    text-decoration: none;
    color: white;
    font-weight: bold;
}
    /* General styling */
body {
    font-family: sans-serif;
    margin: 40px;
    text-align: center;
}

.container {
    width: 500px;
    margin: 0 auto; /* Center the container */
    padding: 20px;
    margin-top: 50px;
    border: 1px solid #ccc;
    border-radius: 5px;
}

h1 {
    text-align: center;
}

/* Form styling */
.form-group {
    margin-bottom: 20px;
}

label {
    display: block;
    margin-bottom: 5px;
}

input[type="email"] {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
}

button {
    background-color: #4CAF50;
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

.error-message {
    color: red;
    font-weight: bold;
    margin-bottom: 10px;
}


</style>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <link rel="stylesheet" href="styles.css"> </head>
<body>
<nav>
    <ul>
        <li><a href="login.php">LOGIN</a></li>

    </ul>
</nav>
    <div class="container"> <h1>Forgot Password</h1>
        <p>Enter your email address to reset your password.</p>
        <form method="post" action="forgotPassword.php">
            <div class="form-group">
                <label for="email">Email Address:</label>
                <input type="email" name="email" id="email" required>
            </div>
            <button type="submit" name="submit">Reset Password</button>
        </form>
    </div>
</body>
</html>

