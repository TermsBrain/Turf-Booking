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
$str = "SELECT transaction.*, customers.name as user_name, customers.phone as phone FROM transaction LEFT JOIN customers ON transaction.user_id = customers.id WHERE transaction.id = $id";
$result = mysqli_query($conn, $str);
$transaction = mysqli_fetch_array($result);

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
                    <!-- <div class="form-group">
                        <label for="">ID</label>
                        <input type="text" value="<?php echo $transaction['id'] ?>" class="form-control" name="id" id="" disabled>
                    </div> -->
                    <div class="form-group">
                        <label for="">Name</label>
                        <input type="text" value="<?php echo $transaction['user_name'] ?>" class="form-control" name="name" id="" disabled>
                    </div>
                    <div class="form-group">
                        <label for="">Contact</label>
                        <input type="text" value="<?php echo $transaction['phone'] ?>" class="form-control" name="name" id="" disabled>
                    </div>
                    <div class="form-group">
                        <label for="">Advance</label>
                        <input type="number" value="<?php echo $transaction['advance'] ?>" class="form-control" name="advance" id="">
                    </div>
                    <div class="form-group">
                        <label for="">Due</label>
                        <input type="number" value="<?php echo $transaction['due'] ?>" class="form-control" name="due" id="">
                    </div>
                    <div class="form-group">
                        <label for="">Method</label>
                        <input type="text" value="<?php echo $transaction['method'] ?>" class="form-control" name="method" id="">
                    </div>
                    <div class="form-group">
                        <label for="">Total</label>
                        <input type="number" value="<?php echo $transaction['total'] ?>" class="form-control" name="total" id="" disabled>
                    </div>
                    <div class="form-group">
                        <input class="btn btn-primary" type="submit" name="submit" value="Update Transaction">
                        <a class="btn btn-info" href="transaction.php">List All Transaction</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
include_once('includes/footer.php');

if (isset($_POST['submit'])) {
    $advance = $_POST['advance'];
    $due = $_POST['due'];
    $method = $_POST['method'];
    $str = "UPDATE transaction SET advance='" . $advance . "', due='" . $due . "', method='" . $method . "' WHERE id= $id";
    if (mysqli_query($conn, $str)) {
        echo "<script> window.location.replace('transaction.php'); </script>";
    }
}
?>