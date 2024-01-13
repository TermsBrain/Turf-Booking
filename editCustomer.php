<?php
session_start();

if (!isset($_SESSION['name']) || !isset($_SESSION['role'])) {
    header('Location: login.php');
    exit;
}
include 'connection.php';
include_once('includes/header.php');
?>
<?php
$id = $_REQUEST['id'];
$str = "SELECT * FROM users WHERE id=$id";
$result = mysqli_query($conn, $str);
$customer = mysqli_fetch_array($result);
?>
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Edit Customer</h1>
        </div>
    </div>
    <div class="row">
        <div class="container">
            <div class="col-md-8">
                <form method="post" action="">
                    <div class="form-group">
                        <label for="">ID</label>
                        <input type="text" value="<?php echo $customer['id'] ?>" class="form-control" name="id" id="" disabled>
                    </div>
                    <div class="form-group">
                        <label for="">Name</label>
                        <input type="text" value="<?php echo $customer['name'] ?>" class="form-control" name="name" id="">
                    </div>
                    <div class="form-group">
                        <label for="">Phone</label>
                        <input type="phone" value="<?php echo $customer['phone'] ?>" class="form-control" name="phone" id="">
                    </div>
                    <div class="form-group">
                        <input class="btn btn-primary" type="submit" name="submit" value="Update Customer">
                        <a class="btn btn-info" href="customers.php">List All Customer</a>
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
    $phone = $_POST['phone'];
    $str = "UPDATE users SET name='" . $name . "', phone='" . $phone . "' WHERE id= $id";
    if (mysqli_query($conn, $str)) {
        echo "<script> window.location.replace('customers.php'); </script>";
    }
}
?>