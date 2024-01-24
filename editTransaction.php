<?php
include 'connection.php';
session_start();

if (!isset($_SESSION['id']) || !isset($_SESSION['role'])) {
    header('Location: login.php');
    exit;
}

include_once('includes/header.php');

$id = $_REQUEST['id'];
$str = "SELECT transaction.*, customers.name as user_name, customers.phone as phone FROM transaction LEFT JOIN customers ON transaction.user_id = customers.id WHERE transaction.id = $id";
$result = mysqli_query($conn, $str);
$transaction = mysqli_fetch_assoc($result);

if (isset($_POST['submit'])) {
    $advance = $_POST['advance'];
    $total = $_POST['total'];
    $cash = $_POST['cash'];

    $method = $_POST['method'];

    // Calculate due based on the formula due = total - advance
    $due = $total - $advance;

    // Update the database with the new values
    // Update the database with the new values
    $str = "UPDATE transaction SET advance='" . $advance . "', total='" . $total . "', due='" . $due . "', cash='" . 0 . "', method='" . $method . "' WHERE id= $id";
    if (mysqli_query($conn, $str)) {
        echo "<script> window.location.replace('transaction.php'); </script>";
    }
}
?>
<style>
    .container-center {
    display: flex;
    justify-content: center;
    align-items: center;
  }
</style>

<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header text-center">Edit Customer</h1>
        </div>
    </div>
    <div class="row">
        <div class="container-center">
            <div class="col-md-8">
                <form method="post" action="">
                    <!-- <div class="form-group">
                        <label for="">ID</label>
                        <input type="text" value="<?php echo $transaction['id'] ?>" class="form-control" name="id" id="" disabled>
                    </div> -->
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="">Name</label>
                            <input type="text" value="<?php echo $transaction['user_name'] ?>" class="form-control" name="name" id="" disabled>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="">Contact</label>
                            <input type="text" value="<?php echo $transaction['phone'] ?>" class="form-control" name="name" id="" disabled>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="">Advance</label>
                            <input type="number" value="<?php echo $transaction['advance'] ?>" class="form-control" name="advance" id="">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="">Total</label>
                            <input type="number" value="<?php echo $transaction['total'] ?>" class="form-control" name="total" id="">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="">Cash</label>
                            <input type="number" value="<?php echo $transaction['cash'] ?>" class="form-control" name="total" id="" disabled>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="">Due</label>
                            <input type="number" value="<?php echo $transaction['due'] ?>" class="form-control" name="due" id="" disabled>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="method">Payment Method:</label>
                            <select class="form-control" id="method" name="method" required>
                                <option value="" <?php echo ($transaction['method'] == '') ? 'selected' : ''; ?>>--Select--</option>
                                <option value="bkash" <?php echo ($transaction['method'] == 'bkash') ? 'selected' : ''; ?>>BKash</option>
                                <option value="nagad" <?php echo ($transaction['method'] == 'nagad') ? 'selected' : ''; ?>>Nagad</option>
                                <option value="cash" <?php echo ($transaction['method'] == 'cash') ? 'selected' : ''; ?>>Cash</option>
                            </select>
                        </div>
                        <div class="form-group col-md-12 text-center">
                            <input class="btn btn-primary" type="submit" name="submit" value="Update Transaction">
                            <a class="btn btn-info" href="transaction.php">List All Transaction</a>
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