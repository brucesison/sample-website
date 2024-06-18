<link href="../admin/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
<link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
<link href="../admin/css/sb-admin-2.min.css" rel="stylesheet">
<link href="../admin/css/images.css" rel="stylesheet">
<link href="../admin/css/main-theme.css" rel="stylesheet">
<link href="../admin/css/secondary-theme.css" rel="stylesheet">
<link href="../admin/css/loadings.css" rel="stylesheet">

<!-- Bootstrap core JavaScript-->
<script src="../admin/vendor/jquery/jquery.min.js"></script>
<script src="../admin/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Core plugin JavaScript-->
<script src="../admin/vendor/jquery-easing/jquery.easing.min.js"></script>

<!-- Custom scripts for all pages-->
<script src="../admin/js/sb-admin-2.min.js"></script>

<!-- Custom styles for data tables -->
<link href="../admin/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

<!-- Page level plugins -->
<script src="../admin/vendor/datatables/jquery.dataTables.min.js"></script>
<script src="../admin/vendor/datatables/dataTables.bootstrap4.min.js"></script>

<!-- Page level custom scripts -->
<script src="../admin/js/demo/datatables-demo.js"></script>

<!-- loading script -->
<script>
    $(document).ready(function() {
        // Show the loading animation
        $('#loading').fadeIn('fast');

        // Set a timeout to fade out the loading animation after 2 seconds
        setTimeout(function() {
            $('#loading').fadeOut('slow');
        }, 1000); // 1000 milliseconds = 1seconds
    });
</script>

<!-- loading after logout clicked -->
<script>
  $(document).ready(function() {
    // When logout button is clicked
    $('#logoutButton').click(function() {
      // Show the loader
      $('#loading-logout').fadeIn('fast');

      // Wait for 1 second before redirecting
      setTimeout(function() {
        window.location.href = '../includes/admin_login.php';
      }, 1000); // 1000 milliseconds = 1 second
    });
  });
</script>
