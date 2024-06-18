<?php 

@include '../includes/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

  $admin_id = $_POST['admin_id'];
  $pass = md5($_POST["pass"]);

  try {
      $stmt = $pdo->prepare("UPDATE admin_tbl SET pass = :pass WHERE admin_id = :admin_id");
      $stmt->bindParam(':pass', $pass);
      $stmt->bindParam(':admin_id', $admin_id);
      $stmt->execute();
      header("Location: ../view_admin.php");
      exit();
    } catch (PDOException $e) {
      header("Location: ../view_admin.php");
      exit();
  }
}

?>