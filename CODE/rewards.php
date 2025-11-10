<?php
// rewards.php - This file is included within the main profile.php

// Ensure $conn and $user_email are available from the main file
// IMPORTANT: $conn (mysqli connection) and $user_email (string) must be defined in the parent file.
$user_email_safe = $user_email ?? ''; // Use null coalescing for safety if run standalone
$total_points = 0;

// =========================================================
// FUNCTION TO CALCULATE POINTS FROM ORDERS (Purchases) - **FIXED**
// Rules: 0-500 Taka = 5 pts | 501-1500 Taka = 10 pts | >1500 Taka = 20 pts
// =========================================================
function calculate_order_points($conn, $email) {
    $points = 0;

    // 1. Fetch all completed/processed orders for the user
    // FIX: Added 'Processing' to the list of qualifying order statuses.
    $sql_orders = "SELECT total_amount FROM orders 
                   WHERE customer_email = ? 
                   AND order_status IN ('Paid', 'Delivered', 'Completed', 'Processing')"; 
                   
    $stmt = $conn->prepare($sql_orders);

    if (!$stmt) {
        error_log("Rewards SQL Error (Orders): " . $conn->error);
        return 0;
    }

    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result_orders = $stmt->get_result();
    $orders = $result_orders->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
    
    // *** DIAGNOSTIC ADDITION: Check if any orders were found ***
    if (empty($orders)) {
        // You can uncomment this for debug if you still see 0 points
        // echo ""; 
        return 0; 
    }
    // **********************************************************
    
    // 2. Apply Point Rules to each order (Logic is okay)
    foreach ($orders as $order) {
        $amount = (float)$order['total_amount'];
        
        if ($amount > 0) {
            if ($amount > 1500) {
                $points += 20; // Above Taka 1500: 20 points
            } elseif ($amount > 500) {
                $points += 10; // Taka 501-1500: 10 points
            } else { // Covers 0.01 to 500
                $points += 5; // Taka 0-500: 5 points
            }
        }
    }
    
    return $points;
}
// =========================================================
// FUNCTION TO CALCULATE POINTS FROM DONATIONS
// Rules: 100+ Taka = 1 pt | 500+ Taka = 5 pts | 1000+ Taka = 10 pts
// NOTE: Donation logic is kept as is, as the user reported it was working.
// =========================================================
function calculate_donation_points($conn, $email) {
    $points = 0;

    // 1. Fetch all donations for the user
    $sql_donations = "SELECT amount FROM donation 
                      WHERE donor_email = ?"; // REQUIRES 'donor_email' column
    
    $stmt = $conn->prepare($sql_donations);
    
    if (!$stmt) {
        // If this error occurs, ensure you ran the DB update SQL!
        error_log("Rewards SQL Error (Donations - Check if 'donor_email' exists!): " . $conn->error);
        return 0;
    }

    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result_donations = $stmt->get_result();
    $donations = $result_donations->fetch_all(MYSQLI_ASSOC);
    $stmt->close();

    // 2. Apply Donation Point Rules
    foreach ($donations as $donation) {
        $amount = (float)$donation['amount'];
        
        // Use greater-than-or-equal checks for donation tiers (Highest tier first)
        if ($amount >= 1000) {
            $points += 10; // 1000+ Taka: 10 points
        } elseif ($amount >= 500) {
            $points += 5;  // 500-999.99 Taka: 5 points
        } elseif ($amount >= 100) {
            $points += 1;  // 100-499.99 Taka: 1 point
        }
    }

    return $points;
}

// =========================================================
// TOTAL CALCULATION AND DISPLAY
// =========================================================
$order_points = calculate_order_points($conn, $user_email_safe);
$donation_points = calculate_donation_points($conn, $user_email_safe);
$total_points = $order_points + $donation_points;
?>

<style>
    /* Custom CSS Variables (optional, for aesthetics) */
    :root {
        --primary-blue: #3B82F6;
        --primary-green: #10B981;
        --primary-orange: #F59E0B;
        --bg-light: #F9FAFB;
    }
    .rewards-container {
        font-family: Arial, sans-serif;
        padding: 20px;
        background-color: var(--bg-light);
        border-radius: 12px;
    }
    .summary-cards {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }
    .card {
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        display: flex;
        align-items: center;
        transition: transform 0.2s;
    }
    .card:hover {
        transform: translateY(-2px);
    }
    .card.points {
        background-color: #FEF3C7; /* Light Yellow */
        color: #78350F; /* Dark Brown Text */
        text-align: center;
        flex-direction: column;
        justify-content: center;
    }
    .card .icon {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        color: white;
        margin-right: 15px;
    }
    .card.points .icon {
        background-color: var(--primary-orange);
        margin: 0 auto 12px;
        color: #FFF;
    }
    .card.points h2 {
        font-size: 2.5rem;
        font-weight: 800;
        margin: 0;
    }
    .card .info h2 {
        font-size: 1.8rem;
        font-weight: 700;
        margin: 0;
    }
    .card .info p {
        margin: 0;
        color: #6B7280;
    }
    .section-card {
        background-color: white;
        padding: 25px;
        border-radius: 8px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        margin-top: 20px;
    }
    .section-card h3 {
        border-bottom: 2px solid var(--bg-light);
        padding-bottom: 10px;
        margin-top: 0;
        color: #1F2937;
    }
    .section-card ul {
        list-style: none;
        padding-left: 0;
    }
    .section-card li {
        margin-bottom: 15px;
        padding-left: 15px;
        border-left: 3px solid var(--primary-blue);
    }
    .section-card li strong {
        display: block;
        margin-bottom: 5px;
        font-size: 1.1em;
    }
</style>
<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script> <div class="rewards-container">
    <h1><i class="fas fa-trophy" style="color: var(--primary-orange);"></i> Your Rewards Center</h1>

    <div class="summary-cards">
        <div class="card points">
            <i class="fas fa-star icon"></i>
            <h2 style="font-size: 3rem;"><?php echo number_format($total_points); ?></h2>
            <p style="color: #78350F; font-weight: 600;">TOTAL REWARD POINTS</p>
        </div>

        <div class="card" style="background-color: white;">
            <div class="icon" style="background-color: var(--primary-blue);"><i class="fas fa-shopping-cart"></i></div>
            <div class="info">
                <h2 style="color: var(--primary-blue);"><?php echo number_format($order_points); ?></h2>
                <p>Points from Purchases</p>
            </div>
        </div>

        <div class="card" style="background-color: white;">
            <div class="icon" style="background-color: var(--primary-green);"><i class="fas fa-heart"></i></div>
            <div class="info">
                <h2 style="color: var(--primary-green);"><?php echo number_format($donation_points); ?></h2>
                <p>Points from Donations</p>
            </div>
        </div>
    </div>


    <div class="section-card">
        <h3><i class="fas fa-list-alt"></i> Point Earning Rules (Taka)</h3>
        <ul style="border-left: none;">
            <li style="border-color: var(--primary-blue);">
                <i class="fas fa-shopping-bag" style="color: var(--primary-blue);"></i> <strong>Purchase Rewards:</strong>
                <ul>
                    <li>Taka 0 - 500: <strong>5 Points</strong></li>
                    <li>Taka 501 - 1500: <strong>10 Points</strong></li>
                    <li>Above Taka 1500: <strong>20 Points</strong></li>
                </ul>
            </li>
            <li style="border-color: var(--primary-green);">
                <i class="fas fa-hands-helping" style="color: var(--primary-green);"></i> <strong>Donation Rewards:</strong>
                <ul>
                    <li>Donation >= Taka 100: <strong>1 Point</strong></li>
                    <li>Donation >= Taka 500: <strong>5 Points</strong></li>
                    <li>Donation >= Taka 1000: <strong>10 Points</strong></li>
                </ul>
            </li>
        </ul>
    </div>
</div>