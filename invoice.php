<style>
    body {
        font-family: 'Arial', sans-serif;
    }

    #page-wrapper {
        max-width: 800px;
        margin: 0 auto;
    }

    .invoice-container {
        background: #fff;
        border: 1px solid #ddd;
        border-radius: 5px;
        padding: 20px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        margin-top: 50px;
        margin-bottom: 50px;
    }

    .invoice-header {
        background-color: #333;
        color: #fff;
        padding: 20px;
        text-align: center;
        border-top-left-radius: 5px;
        border-top-right-radius: 5px;
    }

    .invoice-header img {
        max-width: 150px;
        margin-bottom: 10px;
    }

    .invoice-header h1 {
        margin: 0;
        font-size: 24px;
    }

    .invoice-header h4 {
        margin: 5px 0;
        font-size: 14px;
    }

    .invoice-details {
        margin-top: 20px;
    }

    .table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    .table th,
    .table td {
        border: 1px solid #ddd;
        padding: 15px;
        text-align: left;
    }

    .table th {
        background-color: #f5f5f5;
    }

    .invoice-footer {
        background-color: #333;
        color: #fff;
        padding: 20px;
        text-align: center;
        border-bottom-left-radius: 5px;
        border-bottom-right-radius: 5px;
    }

    .invoice-footer p {
        margin: 5px 0;
        font-size: 16px;
    }

    .invoice-footer button {
        padding: 10px 20px;
        background-color: #007bff;
        color: #fff;
        border: none;
        cursor: pointer;
    }
</style>

<?php
    session_start();
    if (!isset($_SESSION['id']) || !isset($_SESSION['role'])) {
        header('Location: login.php');
        exit;
    }
    include 'connection.php';
    include_once('includes/header.php');

    // Assuming $id is the desired transaction ID
    $id = $_REQUEST['id'];
    $query = "SELECT transaction.*, customers.name as customer_name, customers.phone as customer_phone
              FROM transaction 
              LEFT JOIN customers ON transaction.user_id = customers.id
              WHERE transaction.id = $id";
    $sql = mysqli_query($conn, $query);

    if ($row = mysqli_fetch_array($sql)) { ?>
        <div id="page-wrapper">
            <div class="invoice-container">
                <div class="invoice">
                    <div class="invoice-header">
                        <div class="col-lg-12">
                            <img src="home\assets\img\logo.png" alt="Company Logo">
                            <h1 class="page-header">TermsBrain TURF</h1>
                            <h4>Highway Society Road, Lal Khan Bazaar, Chattogram</h4>
                        </div>
                        <h2>Invoice #<?php echo $row['id']; ?></h2><br>
                        <p>Date: <?php echo $row['created_at']; ?></p>
                        <p>Name: <?php echo $row['customer_name']; ?></p>
                        <p>Contact: <?php echo $row['customer_phone']; ?></p>
                    </div>

                    <div class="invoice-details">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Description</th>
                                    <th>Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Advance</td>
                                    <td>৳ <?php echo $row['advance']; ?>/-</td>
                                </tr>
                                <tr>
                                    <td>Due</td>
                                    <td>৳ -<?php echo $row['due']; ?>/-</td>
                                </tr>
                                <tr>
                                    <td>Cash</td>
                                    <td>৳ <?php echo $row['cash']; ?>/-</td>
                                </tr>
                                <tr>
                                    <td>Total</td>
                                    <td>৳ <?php echo $row['total']; ?>/-</td>
                                </tr>
                                <!-- Add other rows as needed -->
                            </tbody>
                        </table>
                    </div>

                    <div class="invoice-footer">
                        <p>Thank you</p>
                        <p>Come again</p>
                        <p>Powered By <a href="https://TermsBrain.com">Terms Brain</a></p>
                    </div>
                </div>
            </div>
            <button class="btn btn-primary" style="display: block; margin: 0 auto;" onclick="printInvoice()">Print Invoice</button><br>
        </div>
    <?php } ?>
    <?php include_once('includes/footer.php'); ?>
    <script>
        function printInvoice() {
            var printContents = document.querySelector('.invoice-container').innerHTML;
            var originalContents = document.body.innerHTML;

            document.body.innerHTML = printContents;

            window.print();

            document.body.innerHTML = originalContents;
        }
    </script>
