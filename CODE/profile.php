<?php
// PHP router logic for the user profile
session_start(); // Start the session to access user data

// The 'config.php' file is assumed to contain your database connection logic ($conn).
// !!! IMPORTANT: Ensure 'config.php' exists and defines $conn !!!
include_once "config.php"; // <-- Database connection included here

// Get user data from session, or set defaults if not logged in
$user_name = $_SESSION['user_name'] ?? '[Guest User]';
$user_email = $_SESSION['email'] ?? 'guest.email@example.com';
$user_initial = strtoupper(substr($user_name, 0, 1));

// Router logic
$page = isset($_GET['page']) ? $_GET['page'] : 'dashboard';
$page_path = "{$page}.php";

// Whitelist of allowed pages for security
$allowed_pages = [
    'dashboard', 'my_profile', 'order_history', 'my_rescues', 'clinic_visits', 'rewards', 
    // ADDED new pages from your navigation list for completeness
    'adopted_donated_pets', 'donation_history'
];

if (!in_array($page, $allowed_pages) || !file_exists($page_path)) {
    // Default to the dashboard if the page is not found or not allowed
    $page = 'dashboard';
    $page_path = 'dashboard.php';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Save Paws Profile | <?php echo ucwords(str_replace('_', ' ', $page)); ?></title>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <style>
        :root {
            --primary-blue: #3B82F6; --primary-green: #10B981; --primary-orange: #F97316;
            --bg-light: #F3F4F6; --bg-white: #FFFFFF; --text-dark: #1F2937; --text-gray: #6B7280;
            --border-color: #E5E7EB; --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            font-family: 'Segoe UI', 'Roboto', 'Helvetica Neue', sans-serif;
        }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { background-color: var(--bg-light); color: var(--text-dark); }
        .profile-container { display: flex; min-height: 100vh; }
        .profile-sidebar { width: 260px; background-color: var(--bg-white); border-right: 1px solid var(--border-color); padding: 24px; display: flex; flex-direction: column; flex-shrink: 0; }
        .user-info { text-align: center; margin-bottom: 32px; }
        .user-info .avatar { width: 80px; height: 80px; background-color: var(--primary-blue); color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 2rem; margin: 0 auto 12px; }
        .user-info h3 { font-size: 1.1rem; font-weight: 600; }
        .user-info p { font-size: 0.9rem; color: var(--text-gray); }
        .profile-nav ul { list-style: none; }
        .profile-nav a { display: flex; align-items: center; padding: 12px; text-decoration: none; color: var(--text-dark); font-weight: 500; border-radius: 6px; transition: background-color 0.2s; margin-bottom: 8px; }
        .profile-nav a:hover { background-color: var(--bg-light); }
        .profile-nav a.active { background-color: var(--primary-blue); color: white; }
        .profile-nav a.active:hover { background-color: #2563EB; } /* Added hover for active state */
        .profile-nav i { width: 20px; margin-right: 12px; text-align: center; }
        .profile-content { flex-grow: 1; padding: 32px; overflow-y: auto; }
        .profile-content h1 { font-size: 1.8rem; font-weight: 700; margin-bottom: 24px; }
        .summary-cards { display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 24px; margin-bottom: 32px; }
        .card { background-color: var(--bg-white); padding: 20px; border-radius: 8px; box-shadow: var(--shadow-sm); display: flex; align-items: center; }
        .card .icon { font-size: 1.5rem; padding: 12px; border-radius: 50%; margin-right: 16px; color: white; }
        .card.rescue .icon { background-color: var(--primary-orange); }
        .card.points .icon { background-color: #FBBF24; }
        .card.donation .icon { background-color: var(--primary-green); }
        .card.pets .icon { background-color: #6366F1; }
        .card .info h2 { font-size: 1.5rem; font-weight: 700; }
        .card .info p { color: var(--text-gray); font-size: 0.9rem; }
        .section-card { background-color: var(--bg-white); padding: 24px; border-radius: 8px; box-shadow: var(--shadow-sm); margin-bottom: 24px; }
        .section-card h3 { font-size: 1.2rem; font-weight: 600; margin-bottom: 20px; border-bottom: 1px solid var(--border-color); padding-bottom: 12px; }
        .table { width: 100%; border-collapse: collapse; }
        .table th, .table td { padding: 12px; text-align: left; border-bottom: 1px solid var(--border-color); }
        .table th { font-weight: 600; color: var(--text-gray); font-size: 0.85rem; text-transform: uppercase; }
        
        /* Status Badge Styles (Crucial for Order History) */
        .status-badge { padding: 4px 10px; border-radius: 999px; font-weight: 600; font-size: 0.8rem; }
        .status-delivered { background-color: #D1FAE5; color: #065F46; } /* Green */
        .status-pending { background-color: #FEF3C7; color: #92400E; } /* Amber/Orange (For Processing/Pending) */
        .status-paid { background-color: #DBEAFE; color: #1E40AF; } /* Blue (For Paid/Completed) */

        .btn { display: inline-block; padding: 8px 16px; background-color: var(--primary-blue); color: white; text-decoration: none; border-radius: 6px; font-weight: 500; transition: background-color 0.2s; border: none; cursor: pointer; }
        .btn:hover { background-color: #2563EB; }
        
        /* --- Back Button Styles Added/Modified --- */
        .back-btn-container { margin-bottom: 24px; }
        .back-btn { 
            background-color: var(--text-gray); /* Starting color (Gray) */
            /* Inherits default .btn transition for smooth hover */
        }
        .back-btn:hover { 
            background-color: #555; /* Darker gray on hover */
        }
        /* --- End Back Button Styles --- */
    </style>
</head>
<body>
    <div class="profile-container">
        <aside class="profile-sidebar">
            <div class="user-info">
                <div class="avatar"><?php echo htmlspecialchars($user_initial); ?></div>
                <h3><?php echo htmlspecialchars($user_name); ?></h3>
                <p><?php echo htmlspecialchars($user_email); ?></p>
            </div>
            <nav class="profile-nav">
                <ul>
                    <li><a href="profile.php?page=dashboard" class="<?= $page == 'dashboard' ? 'active' : '' ?>"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                    <li><a href="profile.php?page=my_profile" class="<?= $page == 'my_profile' ? 'active' : '' ?>"><i class="fas fa-user-circle"></i> My Profile</a></li>
                    <li><a href="profile.php?page=order_history" class="<?= $page == 'order_history' ? 'active' : '' ?>"><i class="fas fa-box"></i> Order History</a></li>
                    <li><a href="profile.php?page=donation_history" class="<?= $page == 'donation_history' ? 'active' : '' ?>"><i class="fas fa-hand-holding-heart"></i> Donation History</a></li>
                    <li><a href="profile.php?page=rewards" class="<?= $page == 'rewards' ? 'active' : '' ?>"><i class="fas fa-star"></i> Rewards & Badges</a></li>
                </ul>
            </nav>
        </aside>

        <main class="profile-content">
            <div class="back-btn-container">
                <a href="gst.php" class="btn back-btn"><i class="fas fa-arrow-left"></i> Back to Main App</a>
            </div>
            <?php 
            // This line dynamically includes the content file (e.g., order_history.php)
            // The database connection $conn established above is available to the included file.
            include $page_path; 
            ?>
        </main>
    </div>
</body>
</html>