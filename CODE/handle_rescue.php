<?php
// Set header to ensure the response is treated as JSON
header('Content-Type: application/json');

// --- Configuration ---
$host = "localhost";
$user = "root";
$pass = ""; 
$db_name = "savepaws"; 

// --- Database Connection ---
$conn = new mysqli($host, $user, $pass, $db_name);
if ($conn->connect_error) {
    // Return connection error as JSON
    echo json_encode(['success' => false, 'message' => "Database Connection failed: " . $conn->connect_error]);
    exit();
}

// --- Input Sanitation and Fetching POST data ---
// Using real_escape_string for safety, even with prepared statements
$name = $conn->real_escape_string($_POST['name'] ?? '');
$email = $conn->real_escape_string($_POST['email'] ?? '');
$animal_type = $conn->real_escape_string($_POST['animal_t'] ?? '');
$description = $conn->real_escape_string($_POST['des'] ?? '');
// This will contain the full Google Maps URL
$location_link = $conn->real_escape_string($_POST['loc'] ?? '');


// --- Handle optional image upload ---
$image_path = null;
if(isset($_FILES['image']) && $_FILES['image']['error'] === 0){
    $target_dir = "uploads/";
    
    // Check/create uploads directory (Ensure permissions are set to 0777 on server)
    if(!is_dir($target_dir)) {
        if (!mkdir($target_dir, 0777, true)) {
            error_log("Failed to create upload directory.");
        }
    }
    
    $file_extension = pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION);
    $image_path = $target_dir . time() . "_" . uniqid() . "." . $file_extension;
    
    // Attempt to move the file
    if(is_dir($target_dir) && !move_uploaded_file($_FILES["image"]["tmp_name"], $image_path)){
        error_log("Failed to move uploaded file. Check directory permissions (0777).");
        $image_path = null; // Don't save path if move failed
    }
}


// --- Prepared Statement Execution ---
$sql = "INSERT INTO rescue_reports (name, email, animal_type, description, image, location) VALUES (?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);

if ($stmt === false) {
    echo json_encode(['success' => false, 'message' => "Prepare failed: " . $conn->error . ". Check table structure."]);
    $conn->close();
    exit();
}

// Bind parameters: Six strings (ssssss)
$stmt->bind_param("ssssss", $name, $email, $animal_type, $description, $image_path, $location_link);

if($stmt->execute()){
    echo json_encode(['success' => true, 'message' => 'Report submitted successfully!']);
} else {
    echo json_encode(['success' => false, 'message' => "Error executing statement: " . $stmt->error]);
}

$stmt->close();
$conn->close();
?>