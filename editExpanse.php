<?php
session_start();

if (!isset($_SESSION['id']) || !isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header('Location: login.php');
    mysqli_close($conn);
}

include 'connection.php';
include_once('includes/header.php');
?>
<?php
$id = $_REQUEST['id'];
$str = "SELECT * FROM expanse WHERE id=$id";
$result = mysqli_query($conn, $str);
$expanse = mysqli_fetch_array($result);
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
            <h1 class="page-header text-center">Edit Expanse</h1>
        </div>
    </div>
    <div class="row">
        <div class="container-center">
            <div class="col-md-8">
                <form method="post" action="">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <h3 class="panel-title text-center " style="font-weight: bold;">Update Information</h3>
                        </div>
                        <div class="panel-body">
                            <div class="form-group">
                                <label for="">Description</label>
                                <input type="text" value="<?php echo $expanse['description'] ?>" class="form-control" name="description" id="">
                            </div>
                            <div class="form-group">
                                <label for="">Amount</label>
                                <input type="text" value="<?php echo $expanse['amount'] ?>" class="form-control" name="amount" id="">
                            </div>
                            <div class="form-group">
                                <label for="">Note</label>
                                <input type="text" value="<?php echo $expanse['note'] ?>" class="form-control" name="note" id="">
                            </div>
                            <div class="form-group text-center">
                                <input class="btn btn-primary" type="submit" name="submit" value="Update Expanse">
                                <a class="btn btn-info" href="expanse.php">List All Expanses</a>
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
    $description = $_POST['description'];
    $amount = $_POST['amount'];
    $note = $_POST['note'];

    $str = "UPDATE expanse SET description='" . $description . "', amount='" . $amount . "', note='" . $note . "' WHERE id= $id";
    if (mysqli_query($conn, $str)) {
        echo "<script> window.location.replace('allExpanse.php'); </script>";
    }
}
?>
