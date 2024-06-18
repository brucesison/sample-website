<?php 

@include "includes/db_connect.php";
require "includes/functions.php";
$request = $functions->getRequestCount();
$upcoming = $functions->getUpcomingCount();
$today_appointment = $functions->getTodayUpcomingCount();
$child = $functions->getCountChild();
$parent = $functions->getCountParent();
$doctor = $functions->getCountDoctor();
$not_verified = $functions->getPendingParentCount();


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
    <title>Admin Dashboard</title>
    <link rel="icon" href="../includes/icon/favicon.ico">
    <?php include './libraries/libraries.php'; ?>
</head>

<body id="page-top">

    <!-- page loader -->
    <?php include './includes/page_loader.php';?>

    <!-- logout loader -->
    <?php include './includes/logout_loader.php';?>

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
                        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
                        <!-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-main shadow-sm"><i
                                class="fas fa-download fa-sm text-white-50"></i> Generate Report</a> -->
                    </div>

                    <!-- Content Row -->
                    <?php include './includes/dashboard_contents.php';?>

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