<?php
// Check if config.php exists and include it
if (file_exists('config.php')) {
    require_once 'config.php';
} else {
    // If config.php doesn't exist, create empty functions to prevent errors
    function getAllProducts() { return []; }
    function getAllShopOrders() { return []; }
    function getAllRescueCases() { return []; }
    function getAllDonations() { return []; }
    function getAllAdoptions() { return []; }
    function getAllUsers() { return []; }
    function getAllClinicAppointments() { return []; }
    function getAllAbuseReports() { return []; }
    function getAllUserFeedback() { return []; }
    function getAllPayments() { return []; }
    function getSalesStatistics() { return []; }
    function getProfitStatistics() { return []; }
    function getFinanceStats() { return []; }
    function getDashboardStats() { 
        return [
            'total_products' => 0,
            'total_orders' => 0,
            'total_users' => 0,
            'monthly_revenue' => 0
        ];
    }
}

// Simple router logic
$page = isset($_GET['page']) ? $_GET['page'] : 'overview';

// Initialize empty data arrays
$products = [];
$orders = [];
$rescueCases = [];
$donations = [];
$adoptions = [];
$users = [];
$clinicAppointments = [];
$abuseReports = [];
$feedback = [];
$payments = [];
$salesStats = [];
$profitStats = [];
$financeStats = [];
$dashboardStats = getDashboardStats();

// Whitelist of allowed pages to prevent security issues
$allowed_pages = [
    'overview', 'shop', 'rescue', 'donation', 'adoption',
    'users', 'clinic', 'abuse', 'finance', 'feedback',
    'payment', 'settings'
];

$page_path = "pages/{$page}.php";

if (!in_array($page, $allowed_pages) || !file_exists($page_path)) {
    $page = 'overview';
    $page_path = 'pages/overview.php';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    
    <style>
        /* General Styling */
        :root {
            --primary-color: #4a69bd;
            --secondary-color: #1e3799;
            --bg-color: #f4f7fa;
            --text-color: #333;
            --sidebar-bg: #fff;
            --sidebar-text: #555;
            --sidebar-active: #e8f0fe;
            --sidebar-active-text: #1e3799;
            --card-bg: #fff;
            --shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            --border-color: #e1e1e1;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background-color: var(--bg-color);
            color: var(--text-color);
            line-height: 1.6;
        }

        .container { display: flex; min-height: 100vh; }
        .sidebar { width: 260px; background-color: var(--sidebar-bg); box-shadow: var(--shadow); display: flex; flex-direction: column; transition: transform 0.3s ease-in-out; }
        .sidebar-header { padding: 20px; border-bottom: 1px solid var(--border-color); display: flex; justify-content: space-between; align-items: center; }
        .sidebar-header h2 { color: var(--secondary-color); }
        .sidebar-nav { flex-grow: 1; }
        .sidebar-nav ul { list-style: none; padding-top: 15px; }
        .sidebar-nav a { display: flex; align-items: center; padding: 12px 20px; text-decoration: none; color: var(--sidebar-text); font-weight: 500; transition: background-color 0.2s, color 0.2s; }
        .sidebar-nav a i { margin-right: 15px; width: 20px; text-align: center; }
        .sidebar-nav a:hover { background-color: var(--sidebar-active); }
        .sidebar-nav a.active { background-color: var(--sidebar-active); color: var(--sidebar-active-text); border-left: 3px solid var(--primary-color); }
        .sidebar-footer { padding: 20px; border-top: 1px solid var(--border-color); }
        .sidebar-footer a { display: block; text-decoration: none; color: var(--sidebar-text); margin-bottom: 10px; }
        .sidebar-footer a:hover { color: var(--primary-color); }
        .main-content { flex: 1; overflow-x: hidden; }
        .main-header { background-color: #fff; padding: 15px 30px; box-shadow: var(--shadow); display: flex; align-items: center; }
        .main-header h1 { font-size: 1.5rem; color: var(--secondary-color); }
        .content-wrapper { padding: 30px; }
        .menu-toggle { background: none; border: none; font-size: 1.5rem; cursor: pointer; color: var(--secondary-color); display: none; }
        #menu-toggle-open { margin-right: 20px; }
        #menu-toggle-close { display: none; }
        .card-container { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; }
        .card { background-color: var(--card-bg); padding: 25px; border-radius: 8px; box-shadow: var(--shadow); display: flex; align-items: center; }
        .card i { font-size: 2.5rem; margin-right: 20px; padding: 15px; border-radius: 50%; color: #fff; }
        .card .info h4 { font-size: 1.5rem; margin: 0; }
        .card .info p { color: #777; margin: 0; }
        .card.sales i { background-color: #2ecc71; }
        .card.profit i { background-color: #3498db; }
        .card.orders i { background-color: #e67e22; }
        .card.users i { background-color: #9b59b6; }
        .section { background-color: #fff; padding: 20px; border-radius: 8px; box-shadow: var(--shadow); margin-bottom: 30px; }
        .section-header { display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid var(--border-color); padding-bottom: 10px; margin-bottom: 20px; }
        .section-header h3 { color: var(--secondary-color); }
        .chart-container { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 30px; }
        .table-container { overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 12px 15px; border: 1px solid var(--border-color); text-align: left; font-size: 0.9rem; }
        th { background-color: #f2f2f2; font-weight: 600; }
        tbody tr:nth-child(even) { background-color: #f9f9f9; }
        .actions button { border: none; padding: 8px; margin-right: 5px; cursor: pointer; border-radius: 4px; color: #fff; line-height: 1; }
        .btn-edit { background-color: #3498db; }
        .btn-save { background-color: #2ecc71; }
        .btn-delete { background-color: #e74c3c; }
        td input[type="text"], td input[type="date"], td input[type="number"], td input[type="email"] { width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px; }
        
        /* NEW: Styling for the Add New button */
        .btn-add-new {
            background-color: var(--primary-color);
            color: #fff;
            border: none;
            padding: 8px 15px;
            border-radius: 5px;
            cursor: pointer;
            font-weight: 500;
            transition: background-color 0.2s;
        }
        .btn-add-new:hover { background-color: var(--secondary-color); }
        .btn-add-new i { margin-right: 5px; }

        @media (max-width: 992px) {
            .sidebar { position: fixed; left: 0; top: 0; height: 100%; transform: translateX(-100%); z-index: 1000; }
            .sidebar.show { transform: translateX(0); }
            .menu-toggle { display: block; }
            #menu-toggle-close { display: block; }
            .chart-container { grid-template-columns: 1fr; }
        }
        @media (max-width: 576px) {
            .content-wrapper { padding: 15px; }
            .main-header { padding: 15px; }
            th, td { padding: 8px 10px; font-size: 0.8rem; }
            .actions button { padding: 6px; }
        }
    </style>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <div class="container">
        <aside class="sidebar">
            <div class="sidebar-header">
                <h2>Admin Panel</h2>
                <button class="menu-toggle" id="menu-toggle-close">&times;</button>
            </div>
            <nav class="sidebar-nav">
                <ul>
                    <li><a href="index.php?page=overview" class="<?= $page == 'overview' ? 'active' : '' ?>"><i class="fas fa-tachometer-alt"></i> Overview</a></li>
                    <li><a href="index.php?page=shop" class="<?= $page == 'shop' ? 'active' : '' ?>"><i class="fas fa-store"></i> Shop</a></li>
                    <li><a href="index.php?page=rescue" class="<?= $page == 'rescue' ? 'active' : '' ?>"><i class="fas fa-paw"></i> Rescue Statistic</a></li>
                    <li><a href="index.php?page=donation" class="<?= $page == 'donation' ? 'active' : '' ?>"><i class="fas fa-hand-holding-heart"></i> Donatted pets</a></li>
                    <li><a href="index.php?page=adoption" class="<?= $page == 'adoption' ? 'active' : '' ?>"><i class="fas fa-heart"></i> Adoption Statistic</a></li>
                    <li><a href="index.php?page=users" class="<?= $page == 'users' ? 'active' : '' ?>"><i class="fas fa-users"></i> Users Statistic</a></li>
                    <li><a href="index.php?page=clinic" class="<?= $page == 'clinic' ? 'active' : '' ?>"><i class="fas fa-clinic-medical"></i> Clinic Statistic</a></li>
                    <li><a href="index.php?page=abuse" class="<?= $page == 'abuse' ? 'active' : '' ?>"><i class="fas fa-flag"></i> Abuse Report</a></li>
                    <li><a href="index.php?page=finance" class="<?= $page == 'finance' ? 'active' : '' ?>"><i class="fas fa-chart-line"></i> Finance Statistic</a></li>
                    <li><a href="index.php?page=feedback" class="<?= $page == 'feedback' ? 'active' : '' ?>"><i class="fas fa-comment-dots"></i> Users Feedback</a></li>
                    <li><a href="index.php?page=payment" class="<?= $page == 'payment' ? 'active' : '' ?>"><i class="fas fa-credit-card"></i> Users Payment</a></li>
                </ul>
            </nav>
            <div class="sidebar-footer">
                <a href="index.php?page=settings"><i class="fas fa-cog"></i> Settings</a>
                <a href="#"><i class="fas fa-sign-out-alt"></i> Logout</a>
            </div>
        </aside>

        <main class="main-content">
            <header class="main-header">
                <button class="menu-toggle" id="menu-toggle-open"><i class="fas fa-bars"></i></button>
                <h1><?php echo ucwords(str_replace('-', ' ', $page)); ?></h1>
            </header>
            
            <div class="content-wrapper">
                <?php include $page_path; ?>
            </div>
        </main>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // --- Sidebar Toggle for Mobile ---
            const menuToggleOpen = document.getElementById('menu-toggle-open');
            const menuToggleClose = document.getElementById('menu-toggle-close');
            const sidebar = document.querySelector('.sidebar');
            if (menuToggleOpen) menuToggleOpen.addEventListener('click', () => sidebar.classList.add('show'));
            if (menuToggleClose) menuToggleClose.addEventListener('click', () => sidebar.classList.remove('show'));
            document.addEventListener('click', (e) => {
                if (sidebar.classList.contains('show') && !sidebar.contains(e.target) && !menuToggleOpen.contains(e.target)) {
                    sidebar.classList.remove('show');
                }
            });

            // --- Chart.js Initialization ---
            const salesCtx = document.getElementById('salesChart');
            if (salesCtx) {
                new Chart(salesCtx, { type: 'line', data: { labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul'], datasets: [{ label: 'Products Sold', data: [65, 59, 80, 81, 56, 55, 40], fill: false, borderColor: '#4a69bd', tension: 0.1 }] } });
            }
            const profitCtx = document.getElementById('profitChart');
            if (profitCtx) {
                new Chart(profitCtx, { type: 'bar', data: { labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul'], datasets: [{ label: 'Profit ($)', data: [1200, 1900, 3000, 5000, 2300, 2900, 4100], backgroundColor: '#1e3799' }] }, options: { scales: { y: { beginAtZero: true } } } });
            }

            // --- Unified Event Listener for All Table Actions ---
            const contentWrapper = document.querySelector('.content-wrapper');

            contentWrapper.addEventListener('click', function(e) {
                const target = e.target;
                
                // Handle "Add New" button click
                if (target.matches('.btn-add-new, .btn-add-new *')) {
                    const addButton = target.closest('.btn-add-new');
                    const table = addButton.closest('.section').querySelector('table.editable-table');
                    const thead = table.querySelector('thead');
                    const tbody = table.querySelector('tbody');
                    const newRow = tbody.insertRow(0); // Add row at the top

                    Array.from(thead.querySelectorAll('th')).forEach((th, index) => {
                        const cell = newRow.insertCell(index);
                        if (th.textContent.toLowerCase() === 'actions') {
                            cell.classList.add('actions');
                            cell.innerHTML = `<button class="btn-save"><i class="fas fa-save"></i></button><button class="btn-delete"><i class="fas fa-trash-alt"></i></button>`;
                        } else {
                            const templateCell = tbody.querySelector('tr:nth-of-type(2) td:nth-child(' + (index + 1) + ')');
                            let fieldType = 'text';
                            if (templateCell && templateCell.dataset.type) fieldType = templateCell.dataset.type;
                            if (templateCell && templateCell.dataset.field) cell.dataset.field = templateCell.dataset.field;
                            cell.innerHTML = `<input type="${fieldType}" placeholder="${th.textContent}">`;
                        }
                    });
                    return;
                }

                // Handle clicks inside a table (Edit, Save, Delete)
                const row = target.closest('tr');
                if (!row) return;

                if (target.matches('.btn-edit, .btn-edit *')) {
                    const editButton = target.closest('.btn-edit');
                    row.querySelectorAll('td[data-field]').forEach(cell => {
                        const fieldType = cell.dataset.type || 'text';
                        const value = cell.textContent.trim();
                        cell.innerHTML = `<input type="${fieldType}" value="${value}">`;
                    });
                    editButton.innerHTML = '<i class="fas fa-save"></i>';
                    editButton.classList.replace('btn-edit', 'btn-save');
                } else if (target.matches('.btn-save, .btn-save *')) {
                    const saveButton = target.closest('.btn-save');
                    row.querySelectorAll('td[data-field]').forEach(cell => {
                        cell.textContent = cell.querySelector('input').value;
                    });
                    saveButton.innerHTML = '<i class="fas fa-edit"></i>';
                    saveButton.classList.replace('btn-save', 'btn-edit');
                    console.log('Row saved (simulated).');
                } else if (target.matches('.btn-delete, .btn-delete *')) {
                    if (confirm('Are you sure you want to delete this row?')) {
                        row.remove();
                        console.log('Row deleted (simulated).');
                    }
                }
            });
        });
    </script>
</body>
</html>