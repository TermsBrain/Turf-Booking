<?php
session_start();

if (!isset($_SESSION['id']) || !isset($_SESSION['role'])) {
    header('Location: login.php');
    exit;
}

include 'connection.php';
include_once('includes/header.php');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT `id`, `name`, `email`, `password`, `role` FROM `authentication` WHERE `id` = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $_SESSION['id']);
$stmt->execute();
$result = $stmt->get_result();
$userData = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['change_password'])) {
    $oldPassword = $_POST['old_password'];
    $newPassword = $_POST['new_password'];
    $confirmPassword = $_POST['confirm_password'];

    // Validate old password
    if ($oldPassword === $userData['password']) {
        // Check if new password and confirm password match
        if ($newPassword === $confirmPassword) {
            // New password and confirm password match, proceed with password change
            $updateSql = "UPDATE `authentication` SET `password` = ? WHERE `id` = ?";
            $updateStmt = $conn->prepare($updateSql);

            // Bind the new password directly
            $updateStmt->bind_param("si", $newPassword, $userData['id']);
            $updateStmt->execute();

            $passwordChanged = true;
        } else {
            $passwordMatchError = "New password and confirm password do not match.";
        }
    } else {
        $passwordError = "Old password is incorrect.";
    }
}

?>

    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;

        }

        table,
        th,
        td {
            border: 1px solid #ddd;
        }

        th,
        td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        form {
            margin-top: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
        }

        input {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            box-sizing: border-box;
        }

        button {
            background-color: #007bff;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }

        .success-message {
            color: green;
            margin-top: 10px;
        }
    </style>


    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Profile</h1>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-6">
                <table>
                    <tr>
                        <td>Name:</td>
                        <td><?php echo $userData['name']; ?></td>
                    </tr>
                    <tr>
                        <td>Email:</td>
                        <td><?php echo $userData['email']; ?></td>
                    </tr>
                    <tr>
                        <td>Role:</td>
                        <td><?php echo $userData['role']; ?></td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-6">
                <form id="password-form" method="post" action="profile.php">
                    <h2>Change Password</h2>
                    <?php
                    if (isset($passwordChanged) && $passwordChanged) {
                        echo '<p class="success-message">Password changed successfully!</p>';
                    }
                    ?>

                    <?php
                    if (isset($passwordError)) {
                        echo '<p class="error-message" style="color: red; font-weight: bold;">' . $passwordError . '</p>';
                    }
                    ?>

                    <?php
                    if (isset($passwordMatchError)) {
                        echo '<p class="error-message" style="color: red; font-weight: bold;">' . $passwordMatchError . '</p>';
                    }
                    ?>

                    <div class="form-group">
                        <label for="old_password">Old Password:</label>
                        <input type="password" name="old_password" id="old_password" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="new_password">New Password:</label>
                        <input type="password" name="new_password" id="new_password" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="confirm_password">Confirm Password:</label>
                        <input type="password" name="confirm_password" id="confirm_password" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <button type="submit" name="change_password" class="btn btn-primary">Change Password</button>
                    </div>
                </form>


            </div>
        </div>
    </div>
<?php
include_once('includes/footer.php');
?>