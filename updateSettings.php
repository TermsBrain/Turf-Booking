<?php
session_start();

if (!isset($_SESSION['id']) || !isset($_SESSION['role'])) {
    header('Location: login.php');
    exit;
}

include 'connection.php';
include_once('includes/header.php');

// Retrieve existing settings data
$strSettings = "SELECT * FROM `setting` WHERE id=1";
$resultSettings = mysqli_query($conn, $strSettings);
$settings = mysqli_fetch_array($resultSettings);
?>

<style>
    .container-center {
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .form-group {
        margin-bottom: 20px;
    }

    img {
        margin-top: 10px;
    }

    .custom-file {
        margin-top: 10px;
    }

    .image-preview {
        margin-top: 10px;
        border: 1px solid #ddd; /* Add border style */
        padding: 10px; /* Add padding for better appearance */
        text-align: center; /* Center the image within the border */
    }

    .image-preview img {
        width: 100px;
        height: 100px;
        border: 2px solid #ddd; /* Add border around the image */
        border-radius: 8px; /* Add border-radius for rounded corners */
    }
</style>

<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header text-center">Edit Settings</h1>
        </div>
    </div>

    <div class="row">
        <div class="container-center">
            <div class="col-md-8">
                <form method="post" action="" enctype="multipart/form-data">
                    <!-- Brand Information Panel -->
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <h3 class="panel-title text-center" style="font-weight: bold;">Update Brand Information</h3>
                        </div>
                        <div class="panel-body">
                            <!-- Form fields for brand information -->
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="brand">Brand</label>
                                    <input type="text" value="<?php echo $settings['brand'] ?>" class="form-control" name="brand" id="brand">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="phone">Phone</label>
                                    <input type="text" value="<?php echo $settings['phone'] ?>" class="form-control" name="phone" id="phone">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="email">Email</label>
                                    <input type="email" value="<?php echo $settings['email'] ?>" class="form-control" name="email" id="email">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="social">Social</label>
                                    <input type="text" value="<?php echo $settings['social'] ?>" class="form-control" name="social" id="social">
                                </div>
                            </div>
                            <div class="from-row">
                                <div class="form-group col-md-12">
                                    <label for="location">Location</label>
                                    <textarea rows="5" style="height:100%;" type="text" class="form-control" name="location" id="location"><?php echo $settings['location'] ?></textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Logo and Favicon Panel -->
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <h3 class="panel-title text-center" style="font-weight: bold;">Logo and Favicon</h3>
                        </div>
                        <div class="panel-body">
                            <!-- Form fields for logo and favicon -->
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="logo">Logo</label>
                                    <div class="custom-file">
                                        <input type="file" class="form-control" name="logo" id="formFile">
                                    </div>
                                    <?php if (!empty($settings['logo'])) : ?>
                                        <div class="image-preview">
                                            <img src="<?php echo "assets/uploads/" . $settings['logo']; ?>" alt="Logo" width="100">
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="favicon">Favicon</label>
                                    <div class="custom-file">
                                        <input type="file" class="form-control" name="favicon" id="formFileFavicon">
                                    </div>
                                    <?php if (!empty($settings['favicon'])) : ?>
                                        <div class="image-preview">
                                            <img src="<?php echo "assets/uploads/" . $settings['favicon']; ?>" alt="Favicon" width="50">
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="form-group text-center">
                            <input class="btn btn-primary" type="submit" name="submit" value="Update Settings">
                            <!-- <a class="btn btn-info" href="settings.php">Back to Settings</a> -->
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
include_once('includes/footer.php');

if (isset($_POST['submit'])) {
    // Retrieve form data
    $brand = $_POST['brand'];
    $phone = $_POST['phone'];
    $social = $_POST['social'];
    $location = $_POST['location'];

    // Handle logo upload
    $logoPath = $settings['logo'];
    if (!empty($_FILES['logo']['tmp_name'])) {
        $logoFileName = $_FILES['logo']['name'];
        $logoPath = "assets/uploads/" . $logoFileName;

        if (move_uploaded_file($_FILES['logo']['tmp_name'], $logoPath)) {
            echo 'Logo upload success!';
        } else {
            echo 'Logo upload failed.';
        }
    }

    // Handle favicon upload
    $faviconPath = $settings['favicon'];
    if (!empty($_FILES['favicon']['tmp_name'])) {
        $faviconFileName = $_FILES['favicon']['name'];
        $faviconPath = "assets/uploads/" . $faviconFileName;

        if (move_uploaded_file($_FILES['favicon']['tmp_name'], $faviconPath)) {
            echo 'Favicon upload success!';
        } else {
            echo 'Favicon upload failed.';
        }
    }

    // Update settings in the database using prepared statements
    $strUpdateSettings = "UPDATE `setting` SET brand=?, logo=?, favicon=?, phone=?, email=?, social=?, location=? WHERE id=1";
    $stmtUpdateSettings = mysqli_prepare($conn, $strUpdateSettings);
    mysqli_stmt_bind_param($stmtUpdateSettings, 'sssssss', $brand, $logoPath, $faviconPath, $phone, $_POST['email'], $social, $location);

    if (mysqli_stmt_execute($stmtUpdateSettings)) {
        echo "<script>window.location.replace('settings.php');</script>";
    } else {
        echo 'Failed to update settings: ' . mysqli_error($conn);
    }

    mysqli_stmt_close($stmtUpdateSettings);
}
?>
