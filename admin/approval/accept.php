<?php 

// Database connection parameters
@include '../includes/db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST"){
  $child_name = $_POST["child_name"];
  $appointment_id = $_POST["appointment_req_id"];
  $parent_id = $_POST["parent_id"];
  $appointment_date = $_POST["appointment_date"];
  $appointment_time = $_POST["appointment_time"];
  $guardian_name = $_POST["guardian_name"];
  $reason_for = $_POST["reason_for_visit"];


  try{
    $stmt = $pdo->prepare("INSERT INTO appointment_tbl (parent_id, appointment_date, appointment_time, child_name, guardian_name, reason_for_visit) VALUES (:parent_id, :appointment_date, :appointment_time, :child_name, :guardian_name, :reason_for_visit)");
    $stmt->bindParam(':parent_id', $parent_id);
    $stmt->bindParam(':appointment_date', $appointment_date);
    $stmt->bindParam(':appointment_time', $appointment_time);
    $stmt->bindParam(':child_name', $child_name);
    $stmt->bindParam(':guardian_name', $guardian_name);
    $stmt->bindParam(':reason_for_visit', $reason_for);
    $stmt->execute();

    $stmt2 = $pdo->prepare("DELETE FROM appointment_req_tbl WHERE appointment_req_id = :appointment_req_id");
    $stmt2->bindParam(':appointment_req_id', $appointment_id);
    $stmt2->execute();


    

    header("Location: ../app_request.php?status=success");
    exit();
  } catch (PDOException $e) {
    // Handle database errors
    header("Location: ../app_request.php?status=error");
    exit();
  }
  
}

?>