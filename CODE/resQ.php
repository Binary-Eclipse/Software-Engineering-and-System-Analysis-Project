<?php
$conn = new mysqli("localhost", "root", "", "rescue_db");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$name   = $_POST['name'] ?? '';
$email  = $_POST['email'] ?? '';
$animal = $_POST['animal_t'] ?? '';
$desc   = $_POST['des'] ?? '';
$loc    = $_POST['loc'] ?? '';

$imagePath = "";
if (!empty($_FILES['image']['name'])) {
    $targetDir = "uploads/";
    if (!is_dir($targetDir)) mkdir($targetDir, 0777, true);
    $imagePath = $targetDir . basename($_FILES["image"]["name"]);
    move_uploaded_file($_FILES["image"]["tmp_name"], $imagePath);
}

// ✅ Use prepared statement
$stmt = $conn->prepare("INSERT INTO rescue_requests (name, email, animal_type, description, location, image_path) VALUES (?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssssss", $name, $email, $animal, $desc, $loc, $imagePath);

if ($stmt->execute()) {
    echo "<script>alert('✅ Rescue Request Submitted Successfully!'); window.location.href='report.html';</script>";
} else {
    echo "❌ Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
