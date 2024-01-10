<?php
session_start();

if (!isset($_SESSION['name']) || !isset($_SESSION['role'])) {
    header('Location: login.php');
    exit;
}

include_once('includes/header.php');
?>
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Slot Management</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title mb-0">Create Slots</h5>
                <div class="form-group mt-3">
                    <label>
                        Start Time
                        <small class="text-muted">HH:MM</small></label>
                    <input type="time" class="form-control date-inputmask" name="stime" id="stime" placeholder="Enter Start Time" />
                </div>
                <div class="form-group mt-3">
                    <label>
                        Finish Time
                        <small class="text-muted">HH:MM</small></label>
                    <input type="time" class="form-control date-inputmask" name="ftime" id="ftime" placeholder="Enter Finish Time" />
                </div>
                <div class="form-group">
                    <label>Slot Interval
                        <small class="text-muted">Interval between slots</small></label>
                    <input type="number" class="form-control phone-inputmask" name="slotInterval" id="slotInterval" placeholder="Enter Time Interval" />
                </div>
                <div class="form-group">
                    <label>Number of Slots
                        <small class="text-muted">Number of slots can be generated</small></label>
                    <input type="number" disabled name="slotNumber" class="form-control purchase-inputmask" id="slotNumber" placeholder="Number of slots" />
                </div>
                <button type="submit" name="submit" class="btn btn-primary">
                    Proceed
                </button>
            </div>
        </div>

    </div>
</div>
<!-- /.row -->
</div>
<!-- /#page-wrapper -->

<?php include_once('includes/footer.php'); ?>