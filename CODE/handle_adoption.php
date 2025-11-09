<?php
// handle_adoption.php

// 1. Configuration and Session Setup
session_start();
// Include the database connection and configuration
include_once "config.php"; 

// Set the response header to JSON
header('Content-Type: application/json');

// --- Basic Security Check ---
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
    exit;
}

// 2. Data Validation and Sanitization
// Filter and retrieve form data
$pet_id         = filter_input(INPUT_POST, 'pet_id', FILTER_VALIDATE_INT);
$adopter_name   = filter_input(INPUT_POST, 'adopter_name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$adopter_email  = filter_input(INPUT_POST, 'adopter_email', FILTER_VALIDATE_EMAIL);
$adopter_address = filter_input(INPUT_POST, 'adopter_address', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$adopter_nid    = filter_input(INPUT_POST, 'adopter_nid', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$adopter_contact = filter_input(INPUT_POST, 'adopter_contact', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$agree_care     = isset($_POST['agree_care']) ? 1 : 0;
$agree_visit    = isset($_POST['agree_visit']) ? 1 : 0;
$agree_return   = isset($_POST['agree_return']) ? 1 : 0;

// Simple check for required fields
if (!$pet_id || !$adopter_name || !$adopter_email || !$adopter_address || !$adopter_contact) {
    echo json_encode(['success' => false, 'message' => 'Please fill all required fields.']);
    exit;
}

// 3. Database Insertion using Prepared Statement (Security!)

// SQL statement to insert application data. 
// You should have a table like 'adoption_applications'.
$sql = "INSERT INTO adoption_applications 
        (pet_id, adopter_name, adopter_email, adopter_address, adopter_nid, adopter_contact, agree_care, agree_visit, agree_return, application_date) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())";

try {
    // Prepare the statement
    $stmt = $conn->prepare($sql);
    
    // Bind parameters (s=string, i=integer)
    $stmt->bind_param("isssssiii", 
        $pet_id, 
        $adopter_name, 
        $adopter_email, 
        $adopter_address, 
        $adopter_nid, 
        $adopter_contact, 
        $agree_care, 
        $agree_visit, 
        $agree_return
    );
    
    // Execute the statement
    if ($stmt->execute()) {
        // Success: Send a positive JSON response
        echo json_encode(['success' => true, 'message' => 'Application successfully submitted.']);
    } else {
        // Failure: Send an error JSON response
        error_log("Database error: " . $stmt->error);
        echo json_encode(['success' => false, 'message' => 'Database error: Could not save application.']);
    }

    // Close statement
    $stmt->close();

} catch (Exception $e) {
    // Handle exceptions (e.g., connection lost)
    error_log("General error: " . $e->getMessage());
    echo json_encode(['success' => false, 'message' => 'An unexpected server error occurred.']);
}

// Close the database connection (assuming $conn is your connection object)
$conn->close();

?>