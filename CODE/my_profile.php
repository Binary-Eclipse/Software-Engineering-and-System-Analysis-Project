<?php
// my_profile.php
// Assumes session is started and $conn is available from the parent file (profile.php)

// 1. --- Security and Data Retrieval ---

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    echo "<p style='color: red;'>Error: You must be logged in to view this page.</p>";
    exit;
}

global $conn; // Ensure $conn is accessible within this scope (if needed)
$user_id = $_SESSION['user_id'];
$message = ''; // Message to display success or error
$current_user = ['name' => 'Unknown', 'email' => 'error@example.com', 'contact_number' => ''];


// Check for database connection success
if (!isset($conn) || $conn->connect_error) { 
    $message = '<p style="color: red;">Database connection error. Cannot retrieve/update profile data.</p>';
} else {
    // --- 2. Form Submission (UPDATE) Logic ---
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_profile'])) {
        $new_name    = trim($_POST['name'] ?? '');
        $new_email   = trim($_POST['email'] ?? '');
        $new_contact = trim($_POST['contact_number'] ?? '');

        if ($new_name === '' || $new_email === '' || $new_contact === '') {
            $message = '<p style="color: orange;">Warning: All fields are required!</p>';
        } 
        else if (!filter_var($new_email, FILTER_VALIDATE_EMAIL)) {
            $message = '<p style="color: orange;">Warning: Invalid email format.</p>';
        }
        else {
            // Check for duplicate email or contact number (excluding current user)
            $check_duplicate = $conn->prepare("SELECT id FROM users WHERE (email = ? OR contact_number = ?) AND id != ?");
            $check_duplicate->bind_param("ssi", $new_email, $new_contact, $user_id);
            $check_duplicate->execute();
            $duplicate_result = $check_duplicate->get_result();

            if ($duplicate_result->num_rows > 0) {
                $message = '<p style="color: red;">Error: That email or contact number is already taken by another user.</p>';
            } else {
                // Use a prepared statement to update the user data
                $update_stmt = $conn->prepare("UPDATE users SET name = ?, email = ?, contact_number = ? WHERE id = ?");
                if ($update_stmt) {
                    $update_stmt->bind_param("sssi", $new_name, $new_email, $new_contact, $user_id);

                    if ($update_stmt->execute()) {
                        // Update successful! Refresh session data
                        $_SESSION['user_name'] = $new_name;
                        $_SESSION['email']     = $new_email;
                        $message = '<p style="color: var(--primary-green); font-weight: 600;">Profile updated successfully!</p>';
                    } else {
                        $message = '<p style="color: red;">Error updating profile: ' . $conn->error . '</p>';
                    }
                    $update_stmt->close();
                } else {
                    $message = '<p style="color: red;">Database preparation error during update.</p>';
                }
            }
            $check_duplicate->close();
        }
    }
    
    // --- Retrieve current user data (updated if POST was successful) ---
    $stmt = $conn->prepare("SELECT name, email, contact_number FROM users WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 1) {
        $current_user = $result->fetch_assoc();
    }
    $stmt->close();
}
?>

<h1><i class="fas fa-user-circle"></i> My Profile</h1>

<div class="section-card">
    <h3>Personal Information</h3>
    <?php echo $message; // Display any status messages ?>
    
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) . '?page=my_profile'; ?>">
        
        <div style="margin-bottom: 1rem;">
            <label for="name" style="font-weight: 500;">Full Name</label>
            <input type="text" id="name" name="name" 
                   value="<?php echo htmlspecialchars($current_user['name']); ?>" 
                   required
                   style="width: 100%; padding: 8px; border: 1px solid var(--border-color); border-radius: 6px; margin-top: 4px;">
        </div>
        
        <div style="margin-bottom: 1rem;">
            <label for="email" style="font-weight: 500;">Email Address</label>
            <input type="email" id="email" name="email" 
                   value="<?php echo htmlspecialchars($current_user['email']); ?>" 
                   required
                   style="width: 100%; padding: 8px; border: 1px solid var(--border-color); border-radius: 6px; margin-top: 4px;">
        </div>

        <div style="margin-bottom: 1rem;">
            <label for="contact_number" style="font-weight: 500;">Contact Number</label>
            <input type="tel" id="contact_number" name="contact_number" 
                   value="<?php echo htmlspecialchars($current_user['contact_number'] ?? ''); ?>" 
                   required
                   style="width: 100%; padding: 8px; border: 1px solid var(--border-color); border-radius: 6px; margin-top: 4px;">
        </div>

        <button type="submit" name="update_profile" class="btn"><i class="fas fa-save"></i> Save Changes</button>
    </form>
</div>

