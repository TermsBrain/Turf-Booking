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
$id = $_REQUEST['id'];
$str = "SELECT * FROM authentication WHERE id=$id";
$result = mysqli_query($conn, $str);
$staff = mysqli_fetch_array($result);
?>
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Edit Staff</h1>
        </div>
    </div>
    <div class="row">
        <div class="container">
            <div class="col-md-8">
                <form method="post" action="">
                    <div class="form-group">
                        <label for="">Name</label>
                        <input type="text" value="<?php echo $staff['name'] ?>" class="form-control" name="name" id="">
                    </div>
                    <div class="form-group">
                        <label for="">Email</label>
                        <input type="email" value="<?php echo $staff['email'] ?>" class="form-control" name="email" id="">
                    </div>
                    <div class="form-group">
                        <label for="">Password</label>
                        <input type="text" value="<?php echo $staff['password'] ?>" class="form-control" name="password" id="">
                    </div>
                    <div class="form-group">
                        <label for="role">Role</label>
                        <select class="form-control" name="role" id="role">
                            <option value="admin" <?php echo $staff['role'] == 'admin' ? 'selected' : ''; ?>>Admin</option>
                            <option value="manager" <?php echo $staff['role'] == 'manager' ? 'selected' : ''; ?>>Manager</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <input class="btn btn-primary" type="submit" name="submit" value="Update Staff">
                        <a class="btn btn-info" href="staff.php">List All Staff</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
include_once('includes/footer.php');

if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    $str = "UPDATE authentication SET name='" . $name . "', email='" . $email . "', password='" . $password . "', role='" . $role . "' WHERE id= $id";
    if (mysqli_query($conn, $str)) {
        echo "<script> window.location.replace('staff.php'); </script>";
    }
}
?>