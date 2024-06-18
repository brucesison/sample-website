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
    $status = 'verified';
    $user_type = 'user';

    // Handle file upload
    if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['profile_image']['tmp_name'];
        $fileName = $_FILES['profile_image']['name'];
        $fileSize = $_FILES['profile_image']['size'];
        $fileType = $_FILES['profile_image']['type'];
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
            header("Location: ../list_parent.php?status=error_upload");
            exit();
        }
    } else {
        // Handle the error
        header("Location: ../list_parent.php?status=error_upload");
        exit();
    }

    try {
        // Prepare the SQL statement
        $stmt = $pdo->prepare("INSERT INTO user_tbl (name, email, pass, user_type, contact_no, barangay, street, city, state, zipcode, status, profile_image) VALUES (:name, :email, :pass, :user_type, :contact_no, :barangay, :street, :city, :state, :zipcode, :status, :profile_image)");

        // Bind parameters
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':pass', $pass);
        $stmt->bindParam(':user_type', $user_type);
        $stmt->bindParam(':contact_no', $contact_no);
        $stmt->bindParam(':barangay', $barangay);
        $stmt->bindParam(':street', $street);
        $stmt->bindParam(':city', $city);
        $stmt->bindParam(':state', $state);
        $stmt->bindParam(':zipcode', $zipcode);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':profile_image', $profile_name);

        // Execute the statement
        if ($stmt->execute()) {
            header("Location: ../list_parent.php?status=success");
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
