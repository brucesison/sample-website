<?php

@include "includes/db_connect.php";
require "includes/functions.php";

$parents = $functions->getAllParents();

// Pagination variables
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$items_per_page = 6;
$offset = ($page - 1) * $items_per_page;

$search_query = "";
if (isset($_GET['search']) && !empty($_GET['search'])) {
    $search_query = trim($_GET['search']);
    $child = $functions->searchChild($search_query);
    $total_items = count($child);
} else {
    $child = $functions->getChild($offset, $items_per_page);
    $total_items = $functions->getChildCount();
}

$total_pages = ceil($total_items / $items_per_page);

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
    <title>Child List</title>
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
                        <h1 class="h3 mb-0 text-gray-800">Child List</h1>
                        <form class="d-flex" method="get" action="">
                            <input type="text" class="search-input form-control border-main rounded-0" name="search" placeholder="Search Child..." value="<?php echo htmlspecialchars($search_query); ?>">
                            <a href="list_child.php" class="clear-search btn btn-sm rounded-0 mr-2 btn-main d-flex align-items-center">
                                x
                            </a>
                            <button type="submit" class="btn btn-sm btn-main d-flex align-items-center">
                                <i class="fas fa-fw fa-search mr-1"></i>Search
                            </button>
                        </form>
                    </div>

                    <button type="button" class="btn btn-sm btn-main d-flex align-items-center" data-toggle="modal" data-target="#add_child">
                        <i class="fas fa-fw fa-plus mr-1"></i>Add Child
                    </button>

                    <!-- add parent modal-->
                    <?php include './modals/add_child_modal.php';?>

                    <!-- Content Row -->
                    <div class="row my-5 d-flex align-items-center h-100">
                        <?php
                        foreach ($child as $row) {
                        ?>
                        <div class="col-md-4 mb-4">
                            <div class="card shadow">
                            <div class="card-body text-center">
                                <div class="mt-3 mb-4">
                                    <!-- image profile -->
                                    <img src="<?php echo htmlspecialchars($row['child_pic']); ?>"
                                    class="rounded-circle img-fluid border p-2" style="width: 100px; height: 100px" />
                                </div>
                                <h5 class="mb-2 text-dark"><?php echo htmlspecialchars($row['child_name']); ?></h5>
                                <div class="col-md-12 border rounded mb-3 pt-3">
                                    <p class="text-main mb-2">Parent</p>
                                    <p class="text-secondary small mb-3"><?php echo $row['father_name'];?> <span class="mx-2">|</span><?php echo $row['mother_name'];?></p>
                                </div>
                                <button type="button" class="btn btn-main btn-rounded btn-md px-4 mb-4">View</button>
                            </div>
                            </div>
                        </div>
                        <?php
                        }
                        ?>
                    </div>

                    <!-- Pagination -->
                    <ul class="pagination justify-content-center">
                        <?php for ($i = 1; $i <= $total_pages; $i++) : ?>
                            <li class="page-item <?php if ($i === $page) echo 'active'; ?>">
                                <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                            </li>
                        <?php endfor; ?>
                    </ul>

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