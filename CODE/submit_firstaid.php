<?php
header('Content-Type: application/json');

// --- Configuration ---
$host = "localhost";
$user = "root";
$pass = "";
$db   = "savepaws";
$upload_dir = __DIR__ . "/upload_first_aid_image/"; 

// Create mysqli connection
$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => 'DB_CONNECTION_FAILED', 'message' => "Database Connection Failed: " . $conn->connect_error]);
    exit();
}
$conn->set_charset("utf8mb4");

// 1. File Upload Handling (Multiple Files)
$photo_paths = [];
$files_uploaded_successfully = 0;

if (!empty($_FILES['injury_photo'])) {
    if (!is_dir($upload_dir)) {
        if (!mkdir($upload_dir, 0777, true)) {
             // Directory creation failed, proceed without saving files
        }
    }

    if (is_dir($upload_dir)) {
        $file_names = $_FILES['injury_photo']['name'];
        $file_tmp_names = $_FILES['injury_photo']['tmp_name'];
        $file_errors = $_FILES['injury_photo']['error'];
        
        $file_count = count($file_names);
        
        for ($i = 0; $i < $file_count; $i++) {
            // Check if file was actually uploaded and had no errors
            if ($file_errors[$i] === UPLOAD_ERR_OK && is_uploaded_file($file_tmp_names[$i])) {
                $file_ext = pathinfo($file_names[$i], PATHINFO_EXTENSION);
                $new_file_name = uniqid('firstaid_') . '.' . $file_ext;
                $target_file = $upload_dir . $new_file_name;

                if (move_uploaded_file($file_tmp_names[$i], $target_file)) {
                    $photo_paths[] = "upload_first_aid_image/" . $new_file_name; // Store relative path
                    $files_uploaded_successfully++;
                }
            }
        }
    }
}
// Convert the array of paths to a JSON string for database insertion
$photo_paths_json = json_encode($photo_paths); 


// 2. Extract Data from $_POST (Text fields)
$pet_type = $_POST['pet_type'] ?? '';
$pet_name = $_POST['pet_name'] ?? '';
$urgency_level = $_POST['urgency_level'] ?? '';
$owner_full_name = $_POST['owner_full_name'] ?? '';
$owner_phone_number = $_POST['owner_phone_number'] ?? '';
$owner_email = $_POST['owner_email'] ?? '';
$situation_description = $_POST['situation_description'] ?? '';

// Handle symptoms array from the POST request
$symptoms_array = $_POST['symptoms'] ?? [];
$symptoms_json = json_encode($symptoms_array);

// Simple validation for required fields
if (empty($pet_type) || empty($urgency_level) || empty($owner_full_name) || empty($owner_phone_number) || empty($situation_description)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'MISSING_FIELDS', 'message' => 'Required pet and owner details are missing.']);
    exit();
}

// 3. Prepare and Execute SQL statement
$sql = "INSERT INTO first_aid_requests (pet_type, pet_name, urgency_level, owner_full_name, owner_phone_number, owner_email, situation_description, symptoms, injury_photo_path) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);

if ($stmt === false) {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => 'SQL_PREPARE_FAILED', 'message' => 'SQL prepare failed: ' . $conn->error]);
    $conn->close();
    exit();
}

// Bind parameters
$stmt->bind_param("sssssssss", 
    $pet_type, 
    $pet_name, 
    $urgency_level, 
    $owner_full_name, 
    $owner_phone_number, 
    $owner_email, 
    $situation_description, 
    $symptoms_json,
    $photo_paths_json // <-- JSON string of multiple paths
);

if ($stmt->execute()) {
    // Send back the status of the file upload attempt
    echo json_encode(['success' => true, 'message' => 'First aid request saved!', 'request_id' => $conn->insert_id, 'file_uploaded' => ($files_uploaded_successfully > 0)]);
} else {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => 'SQL_EXECUTION_FAILED', 'message' => 'Error saving request: ' . $stmt->error]);
}

$stmt->close();
$conn->close();
?>