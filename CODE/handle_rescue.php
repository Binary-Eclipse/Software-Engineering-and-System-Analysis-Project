<?php
$conn = new mysqli("localhost", "root", "", "savepaws");
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

$name = $_POST['name'];
$email = $_POST['email'];
$animal_type = $_POST['animal_t'];
$description = $_POST['des'];
$location_link = $_POST['loc'];

// Handle optional image
$image_path = null;
if(isset($_FILES['image']) && $_FILES['image']['error'] === 0){
    $target_dir = "uploads/";
    if(!is_dir($target_dir)) mkdir($target_dir, 0777, true);
    $image_path = $target_dir . time() . "_" . basename($_FILES["image"]["name"]);
    move_uploaded_file($_FILES["image"]["tmp_name"], $image_path);
}

$stmt = $conn->prepare("INSERT INTO rescue_reports (name,email,animal_type,description,image,location_link) VALUES (?,?,?,?,?,?)");
$stmt->bind_param("ssssss", $name,$email,$animal_type,$description,$image_path,$location_link);

if($stmt->execute()){
    echo "<script>alert('Report submitted successfully!'); window.location.href='rescue.html';</script>";
}else{
    echo "Error: ".$stmt->error;
}

$stmt->close();
$conn->close();
?>
