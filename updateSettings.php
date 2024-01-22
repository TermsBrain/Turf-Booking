<?php
session_start();

if (!isset($_SESSION['id']) || !isset($_SESSION['role'])) {
    header('Location: login.php');
    exit;
}
include 'connection.php';
include_once('includes/header.php');
?>

<?php
// Retrieve existing settings data
$strSettings = "SELECT * FROM `setting`";
$resultSettings = mysqli_query($conn, $strSettings);
$settings = mysqli_fetch_array($resultSettings);
?>

<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Edit Settings</h1>
        </div>
    </div>
    <div class="row">
        <div class="container">
            <div class="col-md-8">
                <form method="post" action="" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="brand">Brand</label>
                        <input type="text" value="<?php echo $settings['brand'] ?>" class="form-control" name="brand" id="brand">
                    </div>
                    <div class="form-group">
                        <label for="logo">Logo</label>
                        <input type="file" class="form-control-file" name="logo" id="logo">
                        <?php if (!empty($settings['logo'])) : ?>
                            <img src="<?php echo $settings['logo']; ?>" alt="Logo" width="100">
                        <?php endif; ?>
                    </div>
                    <div class="form-group">
                        <label for="favicon">Favicon</label>
                        <input type="file" class="form-control-file" name="favicon" id="favicon">
                        <?php if (!empty($settings['favicon'])) : ?>
                            <img src="<?php echo $settings['favicon']; ?>" alt="Favicon" width="50">
                        <?php endif; ?>
                    </div>
                    <div class="form-group">
                        <label for="phone">Phone</label>
                        <input type="text" value="<?php echo $settings['phone'] ?>" class="form-control" name="phone" id="phone">
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" value="<?php echo $settings['email'] ?>" class="form-control" name="email" id="email">
                    </div>
                    <div class="form-group">
                        <label for="social">Social</label>
                        <input type="text" value="<?php echo $settings['social'] ?>" class="form-control" name="social" id="social">
                    </div>
                    <div class="form-group">
                        <label for="location">Location</label>
                        <input type="text" value="<?php echo $settings['location'] ?>" class="form-control" name="location" id="location">
                    </div>


                    <div class="form-group">
                        <input class="btn btn-primary" type="submit" name="submit" value="Update Settings">
                        <a class="btn btn-info" href="settings.php">Back to Settings</a>
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
    if ($_FILES['logo']['tmp_name'] != "") {
        $logoFileName = $_FILES['logo']['name'];
        $logoPath = "assets/uploads/" . $logoFileName; // Use forward slash here
        move_uploaded_file($_FILES['logo']['tmp_name'], $logoPath);
    }

    // Handle favicon upload
    $faviconPath = $settings['favicon'];
    if ($_FILES['favicon']['tmp_name'] != "") {
        $faviconFileName = $_FILES['favicon']['name'];
        $faviconPath = "assets/uploads/" . $faviconFileName; // Use forward slash here
        move_uploaded_file($_FILES['favicon']['tmp_name'], $faviconPath);
    }

    // Update settings in the database
    $strUpdateSettings = "UPDATE `setting` SET brand='$brand', logo='$logoPath', favicon='$faviconPath' WHERE id=1";

    if (mysqli_query($conn, $strUpdateSettings)) {
        echo "<script> window.location.replace('settings.php'); </script>";
    }
}
?>