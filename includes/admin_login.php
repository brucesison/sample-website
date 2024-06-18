<?php

@include 'connection.php';

$error = '';

session_start();

// Check if user is logged in
if (!isset($_SESSION['loggedin'])) {

    if(isset($_POST['submit'])){

        $email = mysqli_real_escape_string($connection, $_POST['email']);
        $pass = md5($_POST['pass']);
     
        $select = " SELECT * FROM admin_tbl WHERE email = '$email' && pass = '$pass' ";
     
        $result = mysqli_query($connection, $select);
     
        
     
        if((mysqli_num_rows($result) > 0)){
            $row = mysqli_fetch_array($result);
            $_SESSION['loggedin'] = true;
            $_SESSION['admin_id'] = $row['admin_id'];
            $_SESSION['admin_name'] = $row['name'];
            header('location: ../admin/index.php');   
        }else{
           
           $error = '
             <div class="alert alert-danger alert-dismissible fade show" role="alert">
                 <strong>Wrong email or password</strong>
                 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                 </button>
             </div>
           ';
        }
     
     };

} else {
    
    header("Location: ../admin/index.php");
    exit;
    
}



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link rel="icon" href="../includes/icon/favicon.ico">
    <?php include 'libraries.php';?>
</head>
<body id="page-top">
    <div class="container-fluid px-4 py-2">
        <div class="row h-100 border rounded p-3 shadow align-items-center">
            <div class="col-md-6 d-flex align-items-center justify-content-center">
            <?php include '../admin/img/Secure login-pana.svg';?>
            </div>
            <div class="col-md-6 bg-light pt-5 border border-5 rounded d-flex align-items-center justify-content-center h-50">
            <form method="post" action="" class="m-0">
                <div class="d-flex justify-content-center mb-4">
                    <img class="rounded-circle logo-signin" src="../admin/img/Clinic logo.png" alt="...">
                </div>
                <p class="col-md-12 text-center text-dark text-uppercase fs-3 font-weight-bold">SIGN IN to start your session</p>
                <?php echo $error;?>
                <div class="form-label-group">
                    <input type="text"  class="form-control border border-main" placeholder="Email" name="email" required autofocus>
                </div>
                <br>
                <div class="input-group mb-5">
                    <input class="form-control border border-main" id="pass" name="pass" type="password" placeholder="Password" autocomplete="off" required>
                    <div class="input-group-append border border-main rounded-right">
                        <span class="input-group-text">
                            <i class="fas fa-eye text-main" id="pass-toggle"></i>
                        </span>
                    </div>
                </div>
                <div class="d-flex justify-content-center mb-3">
                    <button type="submit" class="col-md-7 btn btn-outline-main btn-block font-weight-bold" name="submit" value="Log in" title="Sign In">Sign In</button>
                </div>
                <div class="d-flex justify-content-center">
                    <a href="./index.php" class="col-md-7 btn btn-main btn-block font-weight-bold">Cancel</a>
                </div>
                <br>
            </form>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('pass-toggle').addEventListener('click', togglePasswordVisibility);

        function togglePasswordVisibility() {
            var passwordField = this.parentElement.parentElement.previousElementSibling;
            if (passwordField.type === "password") {
                passwordField.type = "text";
            } else {
                passwordField.type = "password";
            }
        }
    </script>
</body>
</html>

