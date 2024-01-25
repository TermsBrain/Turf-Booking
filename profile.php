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
            header('Location: profile.php');
            exit;
        } else {
            $passwordMatchError = "New password and confirm password do not match.";
        }
    } else {
        $passwordError = "Old password is incorrect.";
    }
}

?>

<style>
    .container-center {
        display: flex;
        justify-content: center;
        align-items: center;
    }

    form {
        margin-top: 20px;
    }

    label {
        display: block;
        margin-bottom: 8px;
    }

    .card {
        border: none;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        transition: transform 0.2s;
    }

    .card:hover {
        transform: scale(1.05);
    }

    .card-header {
        background-color: #2d70aa;
        color: #fff;
        text-align: center;
        font-size: 1.5rem;
    }

    .user-info {
        padding: 20px;
    }

    .info-item {
        margin-bottom: 15px;
    }

    .label {
        font-weight: bold;
        color: red;
        margin-bottom: 5px;
    }

    .value {
        color: #555;
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
            <h1 class="page-header  text-center">Profile</h1>
        </div>
    </div>

    <div class="row">
        <div class="container-center">
            <div class="card  col-lg-6">
                <div class="card-header">
                    User Information
                </div>
                <div class="user-info container-center">
                    <div class="info-item">
                        <span class="label">Name:</span>
                        <span class="value"><?php echo $userData['name']; ?></span>
                    </div>
                    <div class="info-item">
                        <span class="label">Email:</span>
                        <span class="value"><?php echo $userData['email']; ?></span>
                    </div>
                    <div class="info-item">
                        <span class="label">Role:</span>
                        <span class="value"><?php echo $userData['role']; ?></span>
                    </div>
                </div>
            </div>
        </div>


        <div class="row">
            <div class="container-center">
                <div class="col-lg-8">
                    <form id="password-form" method="post" action="profile.php">
                        <div class="panel panel-info">
                            <div class="panel-heading">
                                <h3 class="panel-title text-center " style="font-weight: bold;">Update Password</h3>
                            </div>
                            <div class="panel-body">
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

                                <div class="form-group text-center">
                                    <button type="submit" name="change_password" class="btn btn-primary">Change Password</button>
                                </div>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
    <?php
    include_once('includes/footer.php');
    ?>