<?php
// handle_donation_ajax.php - Handles the actual database insertion for donations
session_start();

include_once "config.php"; // Assumes $conn is established here

// Initialize session status variables
$_SESSION['donation_status'] = 'error_validation';
$_SESSION['donation_message'] = 'An unknown error occurred during submission.';

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    $_SESSION['donation_message'] = 'Invalid request method.';
    header("Location: donation.php");
    exit();
}

// --- 1. Collect and Sanitize Donation Data ---
$final_amount = filter_input(INPUT_POST, 'amount_final', FILTER_VALIDATE_FLOAT);
$donation_type = filter_input(INPUT_POST, 'type', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$reason = filter_input(INPUT_POST, 'reason', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

// --- 2. Collect and Sanitize Payment Data (SIMULATED from POST) ---
// IMPORTANT: In a real app, this data would come from the payment modal 
// fields and passed via hidden inputs or AJAX. We simulate them here.

// We need a mechanism to know which payment method was selected in the modal.
// Assuming a hidden field 'payment_method' is passed (e.g., 'Card', 'Mobile', 'Bank')
$payment_method = filter_input(INPUT_POST, 'payment_method', FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?: 'Card';

// Simulation of Payment Gateway Interaction: A successful transaction generates an ID.
$transaction_id = 'SP' . time() . rand(1000, 9999); 

// Cardholder Name (assuming passed in POST request)
$cardholder_name = filter_input(INPUT_POST, 'cardholder_name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$cardholder_name = $cardholder_name ?: 'Anonymous Donor';

// Card Number (Only capture last 4 digits for security. Full number is NOT stored.)
$card_full_number = filter_input(INPUT_POST, 'card_number', FILTER_SANITIZE_NUMBER_INT); 
$card_last_four = substr($card_full_number, -4) ?: NULL;


// --- 3. Basic Validation Checks ---
if ($final_amount === false || $final_amount <= 0) {
    $_SESSION['donation_message'] = 'Invalid or missing donation amount.';
    header("Location: donation.php");
    exit();
}

// --- 4. Database Insertion Logic ---
if ($conn->connect_error) {
    $_SESSION['donation_status'] = 'error_connection';
    $_SESSION['donation_message'] = 'Database connection failed: ' . $conn->connect_error;
    header("Location: donation.php");
    exit();
}

// Updated SQL statement with new fields
$sql = "INSERT INTO donation (amount, type, reason, payment_method, transaction_id, cardholder_name, card_number_last_four) 
        VALUES (?, ?, ?, ?, ?, ?, ?)";

if ($stmt = $conn->prepare($sql)) {
    // Bind parameters: d=decimal, s=string
    $stmt->bind_param("dssssss", 
        $final_amount, 
        $donation_type, 
        $reason, 
        $payment_method, 
        $transaction_id, 
        $cardholder_name, 
        $card_last_four
    );

    if ($stmt->execute()) {
        // Success
        $_SESSION['donation_status'] = 'success';
        $_SESSION['donation_message'] = 'Thank you! Your donation of ৳' . number_format($final_amount, 2) . ' (Txn ID: ' . $transaction_id . ') was recorded.';
    } else {
        // Database execution error
        $_SESSION['donation_status'] = 'error_db_execute';
        $_SESSION['donation_message'] = 'Database error: Could not execute the statement. Error: ' . $stmt->error;
    }

    $stmt->close();
} else {
    // Statement preparation error
    $_SESSION['donation_status'] = 'error_prepare';
    $_SESSION['donation_message'] = 'Database error: Could not prepare the statement. Error: ' . $conn->error;
}

$conn->close();

// Redirect back to donation.php to display the result (toast)
header("Location: donation.php");
exit();
?>