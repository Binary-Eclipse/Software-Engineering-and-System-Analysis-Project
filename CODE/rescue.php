<?php
session_start();
include_once "config.php";

$name = $_POST['name'] ?? '';
$phn  = $_POST['phn'] ?? '';
$loc  = $_POST['loc'] ?? '';
$type= $_POST['animal_t'] ?? '';
$description=$_POST['des'] ?? '';

if (!empty($name) && !empty($phn) && !empty($loc) && !empty($type) && !empty($description)) {
  $stmt = $conn->prepare("INSERT INTO res (name, phn, loc, type, des) VALUES (?, ?, ?, ?, ?)");
  $stmt->bind_param("sssss", $name, $phn, $loc, $type, $description);
  $stmt->execute();
  $stmt->close();
  
  // Show alert and redirect using JS
  echo '<script>
          alert("Info Inserted Successfully");
          window.location.href = "rescue.html";
        </script>';
  exit();
} else {
  echo '<script>
          alert(" Missing some data (location or input fields)");
          window.location.href = "rescue.html";
        </script>';
}

$conn->close();
?>
