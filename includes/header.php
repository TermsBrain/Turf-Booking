<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Turf Booking Administrator</title>

    <link rel="shortcut icon" href="home\assets\img\logo.png" type="image/x-icon">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css" />
    <link href="assets/js/metisMenu/metisMenu.min.css" rel="stylesheet">
    <link href="assets/css/booking.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
    <link href="assets/css/sb-admin-2.css" rel="stylesheet">
    <!-- Custom Fonts -->
    <link href="assets/fonts/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.css">
    <script src="assets/js/jquery.min.js" type="text/javascript"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

</head>

<body>

    <div id="wrapper">
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="">Turf Management</a>
            </div>
            <!-- /.navbar-header -->

            <ul class="nav navbar-top-links navbar-right">
                <!-- /.dropdown -->

                <!-- /.dropdown -->
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="profile.php"><i class="fa fa-user fa-fw"></i> User Profile</a>
                        </li>
                        <li><a href="settings.php"><i class="fa fa-gear fa-fw"></i> Settings</a>
                        </li>
                        <li class="divider"></li>
                        <li><a href="logout.php"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                        </li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>
            <!-- /.navbar-top-links -->

            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <li>
                            <a href="index.php"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-ticket fa-fw"></i> Booking <span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="bookingManagement.php"><i class="fa fa-plus fa-fw"></i>Add New Booking</a>
                                </li>
                                <li>
                                    <a href="bookingList.php"><i class="fa fa-list fa-fw"></i>Booking List</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="transaction.php"><i class="fa fa-money fa-fw"></i> Transaction</a>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-user-circle fa-fw"></i> Customers<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="customers.php"><i class="fa fa-list fa-fw"></i>List all</a>
                                </li>
                                <!-- <li>
                                        <a href="add_customer.php"><i class="fa fa-plus fa-fw"></i>Add New</a>
                                    </li> -->
                            </ul>
                        </li>
                        <li>
                            <a href="report.php"><i class="fa fa-file fa-fw"></i> Report</a>
                        </li>

                        <li>
                            <a href="#"><i class="fa fa-users fa-fw"></i> Staff<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <?php
                                if ($_SESSION['role'] == 'admin' && $_SESSION['status'] == 1) { ?>
                                    <li>
                                        <a href="addStaff.php"><i class="fa fa-plus fa-fw"></i>Add New Staff</a>
                                    </li>
                                <?php
                                }
                                ?>
                                <li>
                                    <a href="staff.php"><i class="fa fa-list fa-fw"></i>List all</a>
                                </li>

                            </ul>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-gear fa-fw"></i> Settings<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="profile.php"><i class="fa fa-user fa-fw"></i> Profile</a>
                                </li>
                                <?php
                                if ($_SESSION['role'] == 'admin' && $_SESSION['status'] == 1) { ?>
                                    <li>
                                        <a href="settings.php"><i class="fa fa-gear fa-fw"></i>Update Settings</a>
                                    </li>
                                <?php
                                }
                                ?>
                            </ul>
                        </li>
                    </ul>
                    <div class="text-center" style="margin-top: 20px;">
                        <a class="btn btn-info" href="bookingManagement.php"><i class="fa fa-plus fa-fw"></i> Booking Now</a>
                    </div>
                </div>

                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>
        <!-- The End of the Header -->

    </div>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>