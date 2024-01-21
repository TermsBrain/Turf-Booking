<style>
    body {
        font-family: 'Arial', sans-serif;
    }

    #page-wrapper {
        max-width: 800px;
        margin: 0 auto;
    }

    .invoice-container {
        justify-content: center;
        align-items: center;
        background-color: #ffffff;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
    }

    .invoice-header {
        background-color: #007bff;
        text-align: center;
        color: #ffffff;
        padding: 20px;
        border-radius: 8px 8px 0 0;
    }

    .invoice-header img {
        max-width: 150px;
    }

    .invoice-header h1 {
        margin: 0;
        font-size: 28px;
    }

    .invoice-header h4,
    .invoice-header p {
        margin-bottom: 0;
    }

    .invoice-details {
        margin-top: 20px;
        font-size: 18px;
    }

    .table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    .table th,
    .table td {
        border: 1px solid #ddd;
        padding: 12px;
        text-align: left;
        font-size: 18px;
    }

    .table th {
        background-color: #007bff;
        color: #ffffff;
    }

    .invoice-footer {
        text-align: center;
        font-weight: bold;
        margin-top: 20px;
        padding: 15px;
        border-radius: 0 0 8px 8px;
        background-color: #f5f5f5;
    }

    .invoice-footer p {
        margin-bottom: 0;
    }

    .invoice-footer button {
        padding: 12px 24px;
        background-color: #007bff;
        color: #ffffff;
        border: none;
        cursor: pointer;
        border-radius: 4px;
    }

    .signature-section {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .signature-box {
        width: 45%;
        border-top: 1px solid #ddd;
        padding-top: 20px;
    }

    .signature-box p {
        margin-bottom: 20px;
        color: #555;
    }

    .signature-box .signature-line {
        width: 80%;
        height: 1px;
        background-color: #ddd;
        margin: 0 auto;
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

$id = $_REQUEST['id'];
$query = "SELECT *, transaction.id as transaction_id,
              booking.id as booking_id,
              booking.date as booking_date,
              authentication.name as ref_name,
              transaction.status as transaction_status,
              customers.name as cus_name,
              customers.phone as cus_phone, 
              start_slot.start_time as start_time, 
              end_slot.end_time as end_time
          FROM transaction 
          LEFT JOIN customers ON transaction.user_id = customers.id
          LEFT JOIN booking ON transaction.id = booking.transaction_id
          LEFT JOIN authentication ON booking.reference_id = authentication.id
          LEFT JOIN slot_management AS start_slot ON booking.start_slot_id = start_slot.id
          LEFT JOIN slot_management AS end_slot ON booking.end_slot_id = end_slot.id
          WHERE transaction.id = $id";
$sql = mysqli_query($conn, $query);

if ($row = mysqli_fetch_array($sql)) { ?>
    <div id="page-wrapper">
        <div class="invoice-container">
            <div class="invoice">
                <div class="invoice-header">
                    <img src="home\assets\img\logo.png" alt="Company Logo">
                    <div>
                        <h1 class="page-header">TermsBrain TURF</h1>
                        <h4>Highway Society Road, Lal Khan Bazaar, Chattogram</h4>
                        <p>0123 XXXX XXXX || info@termsbrain.com</p>
                    </div>
                </div>

                <div class="invoice-details">
                    <h2>Invoice #<?php echo $row['transaction_id']; ?></h2>
                    <p>Booked By: <?php echo $row['ref_name']; ?></p>
                    <p>Date: <?php echo $row['booking_date']; ?></p>
                    <p>Slot: <?php echo $row['start_time'] . ' - ' . $row['end_time']; ?></p>
                    <p>Customer Name: <?php echo $row['cus_name']; ?></p>
                    <p>Customer Cantact: <?php echo $row['cus_phone']; ?></p>
                </div>

                <div class="table-container">
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
                        </tbody>
                    </table>
                </div><br><br>

                <div class="signature-section">
                    <div class="signature-box">
                        <p>Cashier's Signature</p>
                        <div class="signature-line"></div>
                    </div>

                    <div class="signature-box">
                        <p>Customer's Signature</p>
                        <div class="signature-line"></div>
                    </div>
                </div>
                <div class="invoice-footer">
                    <p>Thank You!</p>
                    <p>Come Again</p>
                    <p>Powered By Terms Brain</p>
                </div>
            </div>
        </div>
    </div> <?php }
            ?>
<button class="btn btn-primary" style="display: block; margin: 0 auto;" onclick="printInvoice()">Print Invoice</button>

<script>
    function printInvoice() {
        var printContents = document.querySelector('.invoice-container').innerHTML;
        var originalContents = document.body.innerHTML;

        document.body.innerHTML = printContents;

        window.print();

        document.body.innerHTML = originalContents;
    }
</script>