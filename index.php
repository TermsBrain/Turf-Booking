<?php
session_start();
include 'connection.php';

if (!isset($_SESSION['id']) || !isset($_SESSION['role']) || !isset($_SESSION['status'])) {
    
            header('Location: login.php');
            exit;
} 

include_once('includes/header.php');


// Fetch the number of customers
$sqlCustomers = "SELECT COUNT(*) as numCustomers FROM customers";
$resultCustomers = mysqli_query($conn, $sqlCustomers);
$rowCustomers = mysqli_fetch_assoc($resultCustomers);
$numCustomers = $rowCustomers['numCustomers'];

// Fetch the number of staff members
$sqlStaff = "SELECT COUNT(*) as numStaff FROM authentication";
$resultStaff = mysqli_query($conn, $sqlStaff);
$rowStaff = mysqli_fetch_assoc($resultStaff);
$numStaff = $rowStaff['numStaff'];

// Fetch the total transactions from the transaction table
$sqlBooking = "SELECT COUNT(*) as numBooking FROM booking";
$resultBooking = mysqli_query($conn, $sqlBooking);
$rowBooking = mysqli_fetch_assoc($resultBooking);
$numBooking = $rowBooking['numBooking'];

// Fetch the total transactions from the transaction table
$sqlTransactions = "SELECT SUM(total) as totalTransactions FROM transaction";
$resultTransactions = mysqli_query($conn, $sqlTransactions);
$rowTransactions = mysqli_fetch_assoc($resultTransactions);
$totalTransactions = $rowTransactions['totalTransactions'];

// Include necessary files
include_once('includes/header.php');
?>
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Dashboard</h1>
        </div>
    </div>

    <div class="row">
    <div class="col-lg-3 col-md-6">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-user fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge"><?php echo $numCustomers; ?></div>
                        <div>Customers</div>
                    </div>
                </div>
            </div>
            <a href="customers.php">
                <div class="panel-footer">
                    <span class="pull-left">View Details</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="panel panel-green">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-tasks fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge"><?php echo $numStaff; ?></div>
                        <div>Staff</div>
                    </div>
                </div>
            </div>
            <a href="staff.php">
                <div class="panel-footer">
                    <span class="pull-left">View Details</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="panel panel-yellow">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-shopping-cart fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge"><?php echo $numBooking; ?></div>
                        <div>Booking</div>
                    </div>
                </div>
            </div>
            <a href="bookingManagement.php">
                <div class="panel-footer">
                    <span class="pull-left">View Details</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="panel panel-red">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-money fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge">৳ <?php echo $totalTransactions; ?></div>
                        <div>Report</div>
                    </div>
                </div>
            </div>
            <a href="report.php">
                <div class="panel-footer">
                    <span class="pull-left">View Details</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <!-- Additional content goes here -->
        <!-- Example: <div class="panel panel-info">...</div> -->
    </div>
    <div class="col-lg-4">
        <!-- Additional content goes here -->
        <!-- Example: <div class="panel panel-danger">...</div> -->
    </div>
</div>


</div>


<?php include_once('includes/footer.php'); ?>
