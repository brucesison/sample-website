<?php
require "../includes/functions.php";

if (isset($_POST['child_name']) || isset($_POST['father_name']) || isset($_POST['mother_name'])) {
    $response = 'none';
    $child_name = $_POST['child_name'] ?? '';
    $father_name = $_POST['father_name'] ?? '';
    $mother_name = $_POST['mother_name'] ?? '';

    $result = $functions->checkChildDetails($child_name, $father_name, $mother_name);

    $childExists = !empty($result);

    if ($childExists) {
      $response = 'exists';
    } else {
      $response = 'not_exists';
    }

    echo $response;
}
?>
