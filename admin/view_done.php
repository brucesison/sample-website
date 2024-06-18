<?php
@include "includes/db_connect.php";
require "includes/functions.php";

if (isset($_GET['done_appointment_id'])) {
    $done = $functions->getThisDoneAppointment($_GET['done_appointment_id']);
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
    <title>View Done Appointment</title>
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
                            <li class="breadcrumb-item"><a class="text-main" href="app_done.php">Done Appointment</a></li>
                            <li class="breadcrumb-item active" aria-current="page">View Done Appointment</li>
                        </ol>
                    </nav>

                    <!-- Content Row -->
                    <div class="row my-5 d-flex justify-content-between align-items-center h-100">
                        <div class="col-md-12 mb-4">
                            <div class="card shadow">
                                <div class="card-header d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-main">Appointment details</h6>
                                    <div class="dropdown no-arrow">
                                        <a class="dropdown-toggle" role="button" id="dropdownMenuLink"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                                            aria-labelledby="dropdownMenuLink">
                                            <div class="dropdown-header">Action:</div>
                                            <!-- <a class="dropdown-item btn" data-toggle="modal" data-target="#delete_done">Delete</a> -->
                                            <button class="dropdown-item" data-toggle="modal" data-target="#del_done">Delete</button>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- delete done appointment modal-->
                                <?php include './modals/delete_done_modal.php';?>

                                <div class="card-body text-center">
                                    <div class="row px-4 d-flex justify-content-between align-items-center">
                                        <div class="col-md-6">
                                            <p class="text-secondary text-left"><span class="font-weight-bold">Appointment Date</span> : 
                                                <?php 
                                                    // Format the date to include the name of the month
                                                    $f_date = date("l, F j, Y", strtotime($done['appointment_date']));
                                                    echo $f_date;
                                                ?>
                                            </p>
                                            <p class="text-secondary text-left"><span class="font-weight-bold">Appointment Time</span> : 
                                                <?php 
                                                    // Convert the time to 12-hour format with AM/PM
                                                    $formatted_time = date('h:i A', strtotime($done['appointment_time']));
                                                    echo $formatted_time;
                                                ?>  
                                            </p>
                                            <p class="text-secondary text-left"><span class="font-weight-bold">Guardian's Name</span> : <?php echo $done['guardian_name'];?> </p>
                                            <p class="text-secondary text-left"><span class="font-weight-bold">Child's Name</span> : <?php echo $done['child_name'];?> </p>
                                            <p class="text-secondary text-left"><span class="font-weight-bold">Reason for visit</span> : <?php echo $done['reason_for_visit'];?> </p>
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