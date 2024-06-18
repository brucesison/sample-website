<?php

@include "../includes/db_connect.php";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $doctor_id = $_POST['doctor_id'];

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
        $stmt = $pdo->prepare("UPDATE doctor_tbl SET doctor_pic = :doctor_pic WHERE doctor_id = :doctor_id");


        // Bind parameters
        $stmt->bindParam(':doctor_id', $doctor_id);
        $stmt->bindParam(':doctor_pic', $profile_name);

        // Execute the statement
        if ($stmt->execute()) {
            header("Location: ../view_doctor.php?doctor_id=$doctor_id");
            exit();
        } else {
            // Output the error for debugging
            echo "Error: " . $stmt->errorInfo()[2];
        }
    } catch (PDOException $e) {
        // Handle database errors
        echo "Database error: " . $e->getMessage();
    }
} 
?>
