<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password</title>
    <style>
        /* Navbar styling */
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

        body {
            font-family: sans-serif;
            margin: 40px;
            text-align: center;
        }

        .container {
            width: 500px;
            margin: 0 auto;
            /* Center the container */
            padding: 20px;
            margin-top: 50px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        h1 {
            text-align: center;
        }

        /* Form styling */
        form {
            margin-top: 20px;
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        input[type="password"] {
            width: 80%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            padding-right: 8px;
        }

        button {
            background-color: #4b70e2;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        /* Error message styling */
        .error-message {
            color: red;
            font-weight: bold;
            margin-top: 10px;
        }
    </style>
</head>

<body>

    <nav>
        <ul>
            <li><a href="login.php">LOGIN</a></li>

        </ul>
    </nav>


    <div class="container">
        <h1>Change Password</h1>
        <form method="post" action="changePassword.php">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title text-center " style="font-weight: bold;">Update Password</h3>
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <label for="new_password">Enter your new password:</label>
                        <input type="password" name="new_password" required>
                    </div>
                    <button type="submit" name="submit" style="margin-top:20px">Reset Password</button>
                </div>
            </div>
        </form>
    </div>
</body>

</html>