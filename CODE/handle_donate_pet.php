<?php
header('Content-Type: application/json');

// Include database configuration
include_once "config.php"; 

// --- Configuration ---
if (!isset($conn) || $conn->connect_error) {
    echo json_encode(['success' => false, 'message' => 'Database connection error.']);
    exit();
}

// Directory setup for file uploads
$upload_base_dir = __DIR__ . "/uploads_donated_pet/"; 

// 1. File Upload Handling
$photo_path = null;

if (!empty($_FILES['pet_photo']) && $_FILES['pet_photo']['error'] === UPLOAD_ERR_OK) {
    // Ensure directory exists
    if (!is_dir($upload_base_dir)) {
        if (!mkdir($upload_base_dir, 0777, true)) {
            // Log this error, but we proceed with text data if possible
        }
    }

    if (is_dir($upload_base_dir)) {
        $file_tmp_name = $_FILES['pet_photo']['tmp_name'];
        $file_ext = pathinfo($_FILES['pet_photo']['name'], PATHINFO_EXTENSION);
        $new_file_name = uniqid('pet_') . '.' . $file_ext;
        $target_file = $upload_base_dir . $new_file_name;

        if (move_uploaded_file($file_tmp_name, $target_file)) {
            $photo_path = "uploads_donated_pet" . $new_file_name; // Path stored in DB
        }
    }
}

// 2. Extract and Sanitize Data
$pet_name = trim($_POST['pet_name'] ?? '');
$species = trim($_POST['species'] ?? '');
$breed = trim($_POST['breed'] ?? '');
$age = trim($_POST['age'] ?? '');
$gender = trim($_POST['gender'] ?? '');
$description = trim($_POST['description'] ?? '');
$owner_name = trim($_POST['owner_name'] ?? '');
$owner_email = trim($_POST['owner_email'] ?? '');
$owner_phone = trim($_POST['owner_phone'] ?? '');
$reason = trim($_POST['reason'] ?? '');
// Agreement checkboxes are not saved to DB but can be logged if needed.

// Basic validation (required fields from Step 1 and 2)
if (empty($pet_name) || empty($species) || empty($age) || empty($gender) || empty($description) || empty($owner_name) || empty($owner_email) || empty($owner_phone) || empty($photo_path)) {
    // If the file upload failed or required text fields are missing, return an error.
    echo json_encode(['success' => false, 'message' => 'Required fields or pet photo missing/failed to upload.']);
    $conn->close();
    exit();
}

// 3. Prepare and Execute SQL statement
$sql = "INSERT INTO donated_pets (pet_name, species, breed, age, gender, description, owner_name, owner_email, owner_phone, rehoming_reason, photo_path, submission_date) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())";

$stmt = $conn->prepare($sql);

if ($stmt === false) {
    echo json_encode(['success' => false, 'message' => "Prepare failed: " . $conn->error]);
    $conn->close();
    exit();
}

// Bind parameters: ssssssssss
$stmt->bind_param("sssssssssss", $pet_name, $species, $breed, $age, $gender, $description, $owner_name, $owner_email, $owner_phone, $reason, $photo_path);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Pet donation submitted successfully!']);
} else {
    echo json_encode(['success' => false, 'message' => "Error executing statement: " . $stmt->error]);
}

$stmt->close();
$conn->close();
?>