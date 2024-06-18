<?php 

@include "includes/db_connect.php";
require "includes/functions.php";

if (isset($_GET['user_id'])) {
    $parent = $functions->getThisParent($_GET['user_id']);
    $parent_id = $parent['user_id'];

    $stmt = $pdo->prepare("SELECT * FROM child_tbl WHERE parent_id = $parent_id");
    $stmt->execute();
    $child = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $stmt = $pdo->prepare("SELECT * FROM done_appointment_tbl WHERE parent_id = $parent_id");
    $stmt->execute();
    $done = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $no_child_svg = 'd-none';
    $no_child_text = 'd-none';
    if (empty($child)){
        $no_child_svg = 'd-flex';
        $no_child_text = 'd-block';
    }

    $done_tbl = 'd-flex';
    $no_done_svg = 'd-none';
    $no_done_text = 'd-none';
    if (empty($done)){
        $done_tbl = 'd-none';
        $no_done_svg = 'd-block';
        $no_done_text = 'd-block';
    }

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
    <title><?php echo $parent['name']."'s Profile";?></title>
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
                            <li class="breadcrumb-item"><a class="text-main" href="list_parent.php">Parent list</a></li>
                            <li class="breadcrumb-item active" aria-current="page">View parent</li>
                        </ol>
                    </nav>

                    <!-- Content Row -->
                    <div class="row my-5 d-flex h-100">
                        <div class="col-md-4 mb-4">
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <div class="card shadow">
                                        <div class="card-header">
                                            <div class="float-right dropdown no-arrow">
                                                <a class="dropdown-toggle" role="button" id="dropdownMenuLink"
                                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                                                    aria-labelledby="dropdownMenuLink">
                                                    <div class="dropdown-header">Action:</div>
                                                    <button class="dropdown-item" data-toggle="modal" data-target="#edit_parent">Edit</button>
                                                    <button class="dropdown-item" data-toggle="modal" data-target="#edit_security">Security</button>
                                                    <div class="dropdown-divider"></div>
                                                    <button class="dropdown-item-delete" data-toggle="modal" data-target="#delete_parent">Delete</button>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- change photo modal -->
                                        <?php include 'modals/change_photo_modal.php';?>

                                        <!-- edit parent modal -->
                                        <?php include 'modals/edit_parent_modal.php';?>

                                        <!-- edit parent security modal -->
                                        <?php include 'modals/edit_parent_security_modal.php';?>

                                        <!-- delete parent modal -->
                                        <?php include 'modals/delete_parent_modal.php';?>

                                        <div class="card-body text-center">
                                            <div class="mt-3 mb-1">
                                                <!-- image profile -->
                                                <img src="<?php echo htmlspecialchars($parent['profile_image']); ?>" class="rounded-circle img-fluid border p-2 parent-pic" style="width: 100px; height: 100px" data-toggle="modal" data-target="#view_parent_pic"/>
                                            </div>
                                            <p class="text-xs text-main change-photo font-weight-bold mb-3" data-toggle="modal" data-target="#change_photo">Change Photo</p>
                                            <h5 class="mb-2 text-dark"><?php echo $parent['name']; ?></h5>
                                            <p class="text-main mb-2 small"><?php echo $parent['email']; ?></p>
                                            <p class="text-secondary mb-4 small">0<?php echo $parent['contact_no']; ?></p>
                                            <hr class="sidebar-divider">
                                            <p class="text-secondary mb-2">Address</p>
                                            <p class="text-secondary small mb-3">
                                                <?php echo $parent['street'].', ' . $parent['barangay'].', ' . $parent['city'].', ' . $parent['state'].', ' . $parent['zipcode'];?>
                                            </p>
                                        </div>

                                        <!-- view parent profile modal -->
                                        <?php include 'modals/view_profile_modal.php';?>

                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="card shadow">
                                        <div class="card-header text-center">Registered Child</div>
                                        <div class="card-body">
                                            <?php
                                                foreach ($child as $row) {
                                            ?>
                                            <div class="col-md-12 mb-3 d-flex align-items-center bg-light p-3 rounded">
                                                <img src="<?php echo htmlspecialchars($row['child_pic']); ?>" alt="child profile" class="child-profile rounded-circle mr-3">
                                                <div class="text-secondary">
                                                    <a href="view_child.php?child_id=<?php echo $row['child_id'];?>" class="text-dark">
                                                        <?php echo $row['child_name'];?>
                                                    </a>
                                                </div>
                                            </div>
                                            <?php
                                                }
                                            ?>
                                            <div class="col-md-12 <?php echo $no_child_svg;?>">
                                                <?php include '../admin/img/no_data.svg';?>
                                            </div>
                                            <div class="col-md-12 <?php echo $no_child_text;?>">
                                                <h5 class="text-center small">No registered child yet.</h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="card shadow">
                                <div class="card-header text-main text-center">Appointment History</div>
                                <div class="card-body">
                                    <div class="table table-responsive table-striped <?php echo $done_tbl;?> align-items-center justify-content-center small">
                                        <table>
                                            <thead>
                                                <tr>
                                                    <th>Date</th>
                                                    <th>Time</th>
                                                    <th>Child's Name</th>
                                                    <th>Guardian's Name</th>
                                                    <th>Reason for visit</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                    foreach ($done as $row) {
                                                ?>
                                                    <tr>
                                                        <td>
                                                        <?php // Format the date to include the name of the month
                                                            $f_date = date("F j, Y", strtotime($row['appointment_date']));
                                                            echo $f_date;
                                                        ?>
                                                        </td>
                                                        <td>
                                                        <?php // Convert the time to 12-hour format with AM/PM
                                                        $f_time = date('h:i A', strtotime($row['appointment_time']));
                                                        echo $f_time;
                                                        ?>
                                                        </td>
                                                        <td><?php echo($row['child_name']);?></td>
                                                        <td><?php echo($row['guardian_name']);?></td>
                                                        <td><?php echo($row['reason_for_visit']);?></td>
                                                    </tr>
                                                <?php
                                                    }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="col-md-12 <?php echo $no_done_svg;?>">
                                        <div class="row align-items-center justify-content-center">
                                            <div class="col-md-7">
                                                <?php include '../admin/img/no_data.svg';?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 <?php echo $no_done_text;?>">
                                        <h5 class="text-center small">No appointment history found.</h5>
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

    <!-- file input -->
    <script>
        // Get references to the elements
        const fileInput = document.getElementById('file-input');
        const uploadButton = document.getElementById('upload-button');
        const fileNameSpan = document.getElementById('file-name');
        var uploadBtn = document.getElementById('upload-btn');

        // Add event listener to the button
        uploadButton.addEventListener('click', function() {
        fileInput.click();
        });

        // Add event listener to the file input
        fileInput.addEventListener('change', function() {
        if (fileInput.files.length > 0) {
            fileNameSpan.textContent = fileInput.files[0].name;
            uploadBtn.disabled = false;
        } else {
            fileNameSpan.textContent = 'No file chosen';
            uploadBtn.disabled = true;
        }
        });
    </script>

</body>
</html>