<?php 

@include 'includes/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $appointment_date = $_POST["appointment_date"];
  $appointment_id = $_POST["appointment_id"];

  // Update data 
  try {
      $stmt = $pdo->prepare("UPDATE appointment_tbl SET appointment_date = :appointment_date WHERE appointment_id = :appointment_id");
      $stmt->bindParam(':appointment_date', $appointment_date);
      $stmt->bindParam(':appointment_id', $appointment_id);
      $stmt->execute();
      header("Location: view_upcoming.php?appointment_id=$appointment_id");
      exit();
  } catch (PDOException $e) {
      header("Location: view_upcoming.php?appointment_id=$appointment_id");
      exit();
  }
}
?>