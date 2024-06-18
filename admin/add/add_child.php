<?php

@include "../includes/db_connect.php";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Retrieve form data
    $parent_id = $_POST["parent_id"];
    $child_name = $_POST["child_name"];
    $birth_date = $_POST["birth_date"];
    $birth_time = $_POST["birth_time"];
    $gender = $_POST["gender"];
    $mother_name = $_POST["mother_name"];
    $father_name = $_POST["father_name"];
    $guardian_name = $_POST["guardian_name"];
    $mother_contact = $_POST["mother_contact"];
    $father_contact = $_POST["father_contact"];
    $guardian_contact = $_POST["guardian_contact"];
    $hospital = $_POST["hospital"];
    $obstretician = $_POST["obstretician"];
    $pediatrician = $_POST["pediatrician"];    
    
    $type_of_delivery = $_POST["type_of_delivery"];    
    $weight = $_POST["weight"];    
    $height = $_POST["height"];    
    $age_in_weeks = $_POST["age_in_weeks"];    
    $head = $_POST["head"];    
    $chest = $_POST["chest"];    
    $apgar = $_POST["apgar"];    
    $blood_type = $_POST["blood_type"];    
    $eye_color = $_POST["eye_color"];    
    $hair_color = $_POST["hair_color"];    
    $marks = $_POST["marks"];

    // Handle file upload
    if (isset($_FILES['child_pic']) && $_FILES['child_pic']['error'] === UPLOAD_ERR_OK) {
      $fileTmpPath = $_FILES['child_pic']['tmp_name'];
      $fileName = $_FILES['child_pic']['name'];
      $fileSize = $_FILES['child_pic']['size'];
      $fileType = $_FILES['child_pic']['type'];
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
          header("Location: ../list_child.php?status=error_upload");
          exit();
      }
    } else {
        // Handle the error
        header("Location: ../list_child.php?status=error_upload");
        exit();
    }

    try {
        // Prepare the SQL statement
        $stmt = $pdo->prepare("INSERT INTO child_tbl (parent_id, child_name, birth_date, birth_time,gender, mother_name, father_name, guardian_name, mother_contact, father_contact, guardian_contact, hospital, obstretician, pediatrician, type_of_delivery, weight, height, age_in_weeks, head, chest, apgar, blood_type, eye_color, hair_color, marks, child_pic) VALUES (:parent_id, :child_name, :birth_date, :birth_time, :gender, :mother_name, :father_name, :guardian_name, :mother_contact, :father_contact, :guardian_contact, :hospital, :obstretician, :pediatrician, :type_of_delivery, :weight, :height, :age_in_weeks, :head, :chest, :apgar, :blood_type, :eye_color, :hair_color, :marks, :child_pic)");


        // Bind parameters
        $stmt->bindParam(':parent_id', $parent_id);
        $stmt->bindParam(':child_name', $child_name);
        $stmt->bindParam(':birth_date', $birth_date);        
        $stmt->bindParam(':birth_time', $birth_time);        
        $stmt->bindParam(':gender', $gender);        
        $stmt->bindParam(':mother_name', $mother_name);        
        $stmt->bindParam(':father_name', $father_name);        
        $stmt->bindParam(':guardian_name', $guardian_name);        
        $stmt->bindParam(':mother_contact', $mother_contact);        
        $stmt->bindParam(':father_contact', $father_contact);        
        $stmt->bindParam(':guardian_contact', $guardian_contact);        
        $stmt->bindParam(':hospital', $hospital);        
        $stmt->bindParam(':obstretician', $obstretician);        
        $stmt->bindParam(':pediatrician', $pediatrician);        
        
        $stmt->bindParam(':type_of_delivery', $type_of_delivery);      
        $stmt->bindParam(':weight', $weight);      
        $stmt->bindParam(':height', $height);      
        $stmt->bindParam(':age_in_weeks', $age_in_weeks);      
        $stmt->bindParam(':head', $head);      
        $stmt->bindParam(':chest', $chest);      
        $stmt->bindParam(':apgar', $apgar);      
        $stmt->bindParam(':blood_type', $blood_type);      
        $stmt->bindParam(':eye_color', $eye_color);      
        $stmt->bindParam(':hair_color', $hair_color);      
        $stmt->bindParam(':marks', $marks);        
        $stmt->bindParam(':child_pic', $profile_name);        
        $stmt->execute();
        
        header("Location: ../list_child.php?status=success");
        exit();
      } catch (PDOException $e) {
        // Handle database errors
        header("Location: ../list_child.php?status=error");
    }
} 
?>