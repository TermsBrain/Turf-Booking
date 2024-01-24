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
$str = "SELECT * FROM customers WHERE id=$id";
$result = mysqli_query($conn, $str);
$customer = mysqli_fetch_array($result);
?>
<style>
    .container-center {
        display: flex;
        justify-content: center;
        align-items: center;
    }
</style>
<div id="page-wrapper">
    <div class="row ">
        <div class="col-lg-12">
            <h1 class="page-header text-center">Update Customer</h1>
        </div>
    </div>
    <div class="row ">
        <div class="container-center">
            <div class="col-md-8">
                <form method="post" action="">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <h3 class="panel-title text-center " style="font-weight: bold;">Update Information</h3>
                        </div>
                        <div class="panel-body">
                            <div class="from-row">
                                <div class="form-group col-md-12">
                                    <label for="">Customer ID</label>
                                    <input type="text" value="<?php echo $customer['id'] ?>" class="form-control" name="id" id="" disabled>
                                </div>
                            </div>
                            <div class="from-row">
                                <div class="form-group col-md-6">
                                    <label for="">Name</label>
                                    <input type="text" value="<?php echo $customer['name'] ?>" class="form-control" name="name" id="">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="">Phone</label>
                                    <input type="phone" value="<?php echo $customer['phone'] ?>" class="form-control" name="phone" id="">
                                </div>
                            </div>
                            <div class="form-group text-center">
                                <input class="btn btn-primary" type="submit" name="submit" value="Update Customer">
                                <a class="btn btn-info" href="customers.php">List All Customer</a>
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

if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $str = "UPDATE customers SET name='" . $name . "', phone='" . $phone . "' WHERE id= $id";
    if (mysqli_query($conn, $str)) {
        echo "<script> window.location.replace('customers.php'); </script>";
    }
}
?>