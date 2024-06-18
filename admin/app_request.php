<?php

@include "includes/db_connect.php";
require "includes/functions.php";
$request = $functions->getAppointmentRequest();

$no_req_svg = 'd-none';
$no_request = '';
if (empty($request)){
    $no_request = 'd-none';
    $no_req_svg = 'd-flex';
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
    <title>Appointment Requests</title>
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

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Appointment Request List</h1>
                        <a href="#" class="<?php echo $no_request;?> btn btn-sm btn-main shadow-sm">
                            <i class="fas fa-download fa-sm text-white-50"></i> Generate Report
                        </a>
                    </div>

                    <div class="row my-5 <?php echo $no_req_svg;?> align-items-center justify-content-center h-100">
                        <div class="col-md-4 d-flex align-items-center justify-content-center">
                            <?php include '../admin/img/no_appointment.svg';?>
                        </div>
                        <div class="col-md-12">
                            <h5 class="text-center">No appointment request yet.</h5>
                        </div>
                    </div>

                    <!-- Data table Row -->
                    <div class="card shadow mb-4 <?php echo $no_request;?>">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Time</th>
                                            <th>Child's Name</th>
                                            <th>Guardian's Name</th>
                                            <th>Reason for visit</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Date</th>
                                            <th>Time</th>
                                            <th>Child's Name</th>
                                            <th>Guardian's Name</th>
                                            <th>Reason for visit</th>
                                            <th>Action</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        <?php foreach ($request as $row) { ?>
                                            <tr>
                                                <td>
                                                  <?php // Format the date to include the name of the month
                                                    $f_date = date("l, F j, Y", strtotime($row['appointment_date']));
                                                    echo $f_date;
                                                  ?>
                                                </td>
                                                <td><?php echo($row['appointment_time']);?></td>
                                                <td>
                                                  <?php 
                                                  $child_id = $row['child_id'];
                                                  // Fetch child
                                                  $stmt = $pdo->prepare("SELECT * FROM child_tbl WHERE child_id = :child_id");
                                                  $stmt->execute(['child_id' => $child_id]);
                                                  $child = $stmt->fetch(PDO::FETCH_ASSOC);
                                                  echo $child['child_name'];
                                                  ?>
                                                </td>
                                                <td><?php echo($row['guardian_name']);?></td>
                                                <td><?php echo($row['reason_for_visit']);?></td>
                                                <td>
                                                    <?php echo '
                                                        <a href="view_request.php?appointment_req_id='.$row['appointment_req_id'].'" class="btn btn-sm btn-main">
                                                        <i class="fas fa-fw fa-eye mr-1"></i>View</a>'
                                                    ?>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
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