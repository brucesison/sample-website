<?php

@include "../includes/db_connect.php";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Retrieve form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $pass = md5($_POST['pass']);
    $contact_no = $_POST['contact_no'];
    $barangay = $_POST['barangay'];
    $street = $_POST['street'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $zipcode = $_POST['zipcode'];

    // Handle file upload
    if (isset($_FILES['doctor_pic']) && $_FILES['doctor_pic']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['doctor_pic']['tmp_name'];
        $fileName = $_FILES['doctor_pic']['name'];
        $fileSize = $_FILES['doctor_pic']['size'];
        $fileType = $_FILES['doctor_pic']['type'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));
        
        // Sanitize file name
        $newFileName = md5(time() . $fileName) . '.' . $fileExtension;

        // Directory where uploaded files will be saved
        $uploadFileDir = '../uploads/';
        $dest_path = $uploadFileDir . $newFileName;

    if (move_uploaded_file($fileTmpPath, $dest_path)) {
        $profileImagePath = $dest_path;
        $profile_name = 'uploads/' . $newFileName;
    } else {
        // Handle the error
        header("Location: ../list_doctor.php?status=error_upload");
        exit();
    }
    } else {
        // Handle the error
        header("Location: ../list_doctor.php?status=error_upload");
        exit();
    }

    try {
        // Prepare the SQL statement
        $stmt = $pdo->prepare("INSERT INTO doctor_tbl (name, email, pass, contact_no, barangay, street, city, state, zipcode, doctor_pic) VALUES (:name, :email, :pass, :contact_no, :barangay, :street, :city, :state, :zipcode, :doctor_pic)");

        // Bind parameters
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':pass', $pass);        
        $stmt->bindParam(':contact_no', $contact_no);        
        $stmt->bindParam(':barangay', $barangay);        
        $stmt->bindParam(':street', $street);        
        $stmt->bindParam(':city', $city);        
        $stmt->bindParam(':state', $state);        
        $stmt->bindParam(':zipcode', $zipcode);        
        $stmt->bindParam(':doctor_pic', $profile_name);        
        $stmt->execute();
        
        header("Location: ../list_doctor.php?status=success");
        exit();
    } catch (PDOException $e) {
        // Handle database errors
        header("Location: ../list_doctor.php?status=error");
    }
} 
?>