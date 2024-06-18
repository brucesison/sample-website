<?php
@include "includes/db_connect.php";
require "includes/functions.php";

if (isset($_GET['appointment_id'])) {
    $upcoming = $functions->getThisUpcomingAppointment($_GET['appointment_id']);
} else {
// redirect
} 

session_start();

// Check if user is logged in
if (!isset($_SESSION['loggedin'])) {
    header("Location: access_denied.php");
    exit;
} else {
    $admin_id = $_SESSION["admin_id"];
    $admin_name = $_SESSION["admin_name"];
    $stmt = $pdo->prepare("SELECT * FROM admin_tbl WHERE admin_id = $admin_id");
    $stmt->execute();
    $admin_info = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>View Upcoming Appointment</title>
    <link rel="icon" href="../includes/icon/favicon.ico">
    <?php include './libraries/libraries.php'; ?>
</head>

<body id="page-top">

    <!-- page loader -->
    <?php include './includes/page_loader.php';?>

    <!-- Page Wrapper -->
    <div id="wrapper">

        <?php include './includes/sidebar.php';?>

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <?php include './includes/topbar.php';?>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb bg-light small shadow">
                            <li class="breadcrumb-item"><a class="text-main" href="app_upcoming.php">Upcoming Appointment</a></li>
                            <li class="breadcrumb-item active" aria-current="page">View Upcoming Appointment</li>
                        </ol>
                    </nav>

                    <!-- Content Row -->
                    <div class="row my-5 d-flex justify-content-between align-items-center h-100">
                        <div class="col-md-12 mb-4">
                            <div class="card shadow">
                                <div class="card-body text-center">
                                    <div class="row px-4 d-flex justify-content-between align-items-center">
                                        <div class="col-md-6">
                                            <p class="text-secondary text-left"><span class="font-weight-bold">Appointment Date</span> : 
                                                <?php 
                                                    // Format the date to include the name of the month
                                                    $f_date = date("l, F j, Y", strtotime($upcoming['appointment_date']));
                                                    echo $f_date;
                                                ?>
                                            </p>
                                            <p class="text-secondary text-left"><span class="font-weight-bold">Appointment Time</span> : <?php echo $upcoming['appointment_time'];?> </p>
                                            <p class="text-secondary text-left"><span class="font-weight-bold">Guardian's Name</span> : <?php echo $upcoming['guardian_name'];?> </p>
                                            <p class="text-secondary text-left"><span class="font-weight-bold">Child's Name</span> : <?php echo $upcoming['child_name'];?> </p>
                                            <p class="text-secondary text-left"><span class="font-weight-bold">Reason for visit</span> : <?php echo $upcoming['reason_for_visit'];?> </p>
                                            <button type="submit" class="btn btn-main float-left mr-2" data-toggle="modal" data-target="#mark_done">
                                                <i class="fas fa-fw fa-check mr-1"></i>Done
                                            </button>
                                            <button type="submit" class="btn btn-info float-left text-light" data-toggle="modal" data-target="#re_schedule">
                                                <i class="fas fa-fw fa-calendar mr-1"></i>Re Schedule
                                            </button>
                                            <!-- mark as done modal-->
                                            <?php include './modals/mark_done_modal.php';?>
                                            <!-- re schedule modal-->
                                            <?php include './modals/re_schedule_modal.php';?>
                                        </div>
                                        <div class="col-md-6" id="view-app-calendar">
                                            <?php include './img/calendar.svg';?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                  </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <?php include './includes/footer.php';?>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Custom scripts for sidebar and scrolling-->
    <script src="js/sb-admin-2.min.js"></script>

</body>
</html>