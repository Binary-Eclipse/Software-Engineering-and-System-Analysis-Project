<?php
// dashboard.php - Included within profile.php
// Ensures $conn, $user_name, and $user_email are available from the parent file.

// Prepare email for use in SQL queries
$user_email_safe = $user_email;

// =========================================================
// 1. Fetch Total Reward Points (Simplified version of rewards.php logic)
//    We will reuse the functions if available, or define them here for simplicity.
//    NOTE: For production, you should load these functions from a common utility file.
// =========================================================

// --- BEGIN Point Calculation Logic (copied/adapted from rewards.php) ---

function calculate_order_points_summary($conn, $email) {
    $points = 0;
    // Note: order_status IN ('Paid', 'Delivered', 'Completed', 'Processing') from rewards.php
    $sql_orders = "SELECT total_amount FROM orders 
                   WHERE customer_email = ? 
                   AND order_status IN ('Paid', 'Delivered', 'Completed', 'Processing')"; 
                   
    $stmt = $conn->prepare($sql_orders);
    if (!$stmt) return 0;
    
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result_orders = $stmt->get_result();
    $orders = $result_orders->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
    
    foreach ($orders as $order) {
        $amount = (float)$order['total_amount'];
        if ($amount > 0) {
            if ($amount > 1500) { $points += 20; }
            elseif ($amount > 500) { $points += 10; }
            else { $points += 5; }
        }
    }
    return $points;
}

function calculate_donation_points_summary($conn, $email) {
    $points = 0;
    // REQUIRES 'donor_email' column from rewards.php
    $sql_donations = "SELECT amount FROM donation 
                      WHERE donor_email = ?"; 
    
    $stmt = $conn->prepare($sql_donations);
    if (!$stmt) return 0;
    
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result_donations = $stmt->get_result();
    $donations = $result_donations->fetch_all(MYSQLI_ASSOC);
    $stmt->close();

    foreach ($donations as $donation) {
        $amount = (float)$donation['amount'];
        if ($amount >= 1000) { $points += 10; } 
        elseif ($amount >= 500) { $points += 5; } 
        elseif ($amount >= 100) { $points += 1; }
    }
    return $points;
}

// Calculate Total Points
$total_points = calculate_order_points_summary($conn, $user_email_safe) + 
                calculate_donation_points_summary($conn, $user_email_safe);

// --- END Point Calculation Logic ---


// =========================================================
// 2. Fetch Total Orders Count (Adapted from order_history.php)
// =========================================================
$total_orders = 0;
// Note: We count ALL orders for a summary card
$sql_count_orders = "SELECT COUNT(order_id) AS total FROM orders WHERE customer_email = ?";

$stmt_orders = $conn->prepare($sql_count_orders);
if ($stmt_orders) {
    $stmt_orders->bind_param("s", $user_email_safe); 
    if ($stmt_orders->execute()) {
        $result_count = $stmt_orders->get_result();
        $total_orders = $result_count->fetch_assoc()['total'] ?? 0;
        $stmt_orders->close();
    }
}


// =========================================================
// 3. Fetch Total Donations Count (Requires 'donor_email' link from rewards.php)
//    NOTE: donation_history.php was NOT secure, this uses the secure query from rewards.php.
// =========================================================
$total_donations = 0;
$sql_count_donations = "SELECT COUNT(donation_id) AS total FROM donation WHERE donor_email = ?";

$stmt_donations = $conn->prepare($sql_count_donations);
if ($stmt_donations) {
    $stmt_donations->bind_param("s", $user_email_safe);
    if ($stmt_donations->execute()) {
        $result_count = $stmt_donations->get_result();
        $total_donations = $result_count->fetch_assoc()['total'] ?? 0;
        $stmt_donations->close();
    }
}
?>

<div class="dashboard-header">
    <h1>Welcome back, <?php echo htmlspecialchars($user_name); ?>!</h1>
    <p style="color: var(--text-gray); font-size: 1.1rem; margin-top: 5px;">A quick overview of your Save Paws activity.</p>
</div>

<div class="summary-cards" style="margin-top: 30px;">
    <div class="card points">
        <div class="icon" style="background-color: #FBBF24;"><i class="fas fa-star"></i></div>
        <div class="info">
            <h2><?php echo number_format($total_points); ?></h2>
            <p>Total Reward Points</p>
        </div>
    </div>
    
    <div class="card rescue">
        <div class="icon" style="background-color: var(--primary-orange);"><i class="fas fa-box-open"></i></div>
        <div class="info">
            <h2><?php echo number_format($total_orders); ?></h2>
            <p>Total Orders Placed</p>
        </div>
    </div>

    <div class="card donation">
        <div class="icon" style="background-color: var(--primary-green);"><i class="fas fa-hand-holding-heart"></i></div>
        <div class="info">
            <h2><?php echo number_format($total_donations); ?></h2>
            <p>Total Donations Made</p>
        </div>
    </div>
</div>

<div class="section-card">
    <h3><i class="fas fa-link"></i> Quick Links</h3>
    <div style="display: flex; flex-wrap: wrap; gap: 15px;">
        <a href="profile.php?page=order_history" class="btn" style="background-color: var(--primary-blue);"><i class="fas fa-box"></i> Order History</a>
        <a href="profile.php?page=donation_history" class="btn" style="background-color: var(--primary-green);"><i class="fas fa-hand-holding-heart"></i> Donation History</a>
        <a href="profile.php?page=rewards" class="btn" style="background-color: #FBBF24;"><i class="fas fa-star"></i> View Rewards</a>
        <a href="profile.php?page=my_profile" class="btn" style="background-color: var(--text-gray);"><i class="fas fa-user-circle"></i> Update Profile</a>
    </div>
</div>