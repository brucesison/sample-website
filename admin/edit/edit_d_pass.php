<?php 

@include '../includes/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

  $doctor_id = $_POST['doctor_id'];
  $pass = md5($_POST["pass"]);

  try {
      $stmt = $pdo->prepare("UPDATE doctor_tbl SET pass = :pass WHERE doctor_id = :doctor_id");
      $stmt->bindParam(':pass', $pass);
      $stmt->bindParam(':doctor_id', $doctor_id);
      $stmt->execute();
      header("Location: ../view_doctor.php?doctor_id=$doctor_id");
      exit();
    } catch (PDOException $e) {
      header("Location: ../view_doctor.php?doctor_id=$doctor_id");
      exit();
  }
}

?>