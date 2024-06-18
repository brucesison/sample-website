<?php 
@include '../includes/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET'){
  $done_appointment_id = $_GET["done_appointment_id"];

  try {
    $stmt = $pdo->prepare("DELETE FROM done_appointment_tbl WHERE done_appointment_id = ?");
    $stmt->execute([$done_appointment_id]);
    
    // Redirect back to appointment list
    header("Location: ../app_done.php?status=success");
    exit();
  } catch (PDOException $e) {
    // Handle database errors
    header("Location: ../app_done.php?status=error");
    exit();
  }
}
?>
