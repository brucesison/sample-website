<?php 

@include '../includes/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

  $doctor_id = $_POST['doctor_id'];
  $name = $_POST['name'];
  $contact_no = $_POST['contact_no'];
  $email = $_POST['email'];
  $barangay = $_POST['barangay'];
  $street = $_POST['street'];
  $state = $_POST['state'];
  $zipcode = $_POST['zipcode'];

  try {
      $stmt = $pdo->prepare("UPDATE doctor_tbl SET name = :name, contact_no = :contact_no, email = :email, barangay = :barangay, street = :street, state = :state, zipcode = :zipcode WHERE doctor_id = :doctor_id");
      
      $stmt->bindParam(':doctor_id', $doctor_id);
      $stmt->bindParam(':name', $name);
      $stmt->bindParam(':contact_no', $contact_no);
      $stmt->bindParam(':email', $email);
      $stmt->bindParam(':barangay', $barangay);
      $stmt->bindParam(':street', $street);
      $stmt->bindParam(':state', $state);
      $stmt->bindParam(':zipcode', $zipcode);
      $stmt->execute();

      header("Location: ../view_doctor.php?doctor_id=$doctor_id");
      exit();
    } catch (PDOException $e) {
      header("Location: ../view_doctor.php?doctor_id=$doctor_id");
      exit();
  }
}

?>