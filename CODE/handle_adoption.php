<?php
// Set header first. Ensure no output precedes this.
header('Content-Type: application/json');
$error_flag = false;
$error_message = '';

// --- 1. Include Configuration Safely ---
// Use require_once to stop script execution with a recoverable error 
// if config.php is missing, then handle the error flag.
if (!@require_once "config.php") {
    $error_flag = true;
    $error_message = "Configuration Error: config.php not found or inaccessible.";
}

// --- 2. Check Connection Health ---
if (!$error_flag && (!isset($conn) || $conn->connect_error)) {
    $error_flag = true;
    $error_message = "Database connection failed. Details: " . ($conn->connect_error ?? 'Unknown connection error.');
}

// --- 3. Handle Error Flag Immediately ---
if ($error_flag) {
    http_response_code(500); // Set HTTP status code to internal server error
    echo json_encode(['success' => false, 'message' => $error_message]);
    exit();
}

// --- 4. Process Data (Only proceeds if no error) ---
$pet_id = $_POST['pet_id'] ?? null;
$name = trim($_POST['adopter_name'] ?? '');
$email = trim($_POST['adopter_email'] ?? '');
$address = trim($_POST['adopter_address'] ?? '');
$nid = trim($_POST['adopter_nid'] ?? '');
$contact = trim($_POST['adopter_contact'] ?? '');

$agree_care = isset($_POST['agree_care']) ? 1 : 0;
$agree_visit = isset($_POST['agree_visit']) ? 1 : 0;
$agree_return = isset($_POST['agree_return']) ? 1 : 0;

// Basic validation
if (empty($pet_id) || empty($name) || empty($email) || empty($contact)) {
    http_response_code(400); // Bad request status
    echo json_encode(['success' => false, 'message' => 'Required fields missing.']);
    $conn->close();
    exit();
}

// --- 5. Database Operation ---
try {
    $sql = "INSERT INTO adoption_applications (pet_id, adopter_name, adopter_email, adopter_address, adopter_nid, adopter_contact, agree_care, agree_visit, agree_return, application_date) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())";

    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        throw new Exception("SQL Prepare failed: " . $conn->error);
    }

    // Bind parameters: issssssiii (1 int, 6 strings, 3 ints)
    $stmt->bind_param("issssssiii", $pet_id, $name, $email, $address, $nid, $contact, $agree_care, $agree_visit, $agree_return);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Application submitted successfully!']);
    } else {
        throw new Exception("Error executing statement: " . $stmt->error);
    }

    $stmt->close();

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => "Application submission failed. " . $e->getMessage()]);
}

$conn->close();