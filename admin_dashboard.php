<?php
session_start();
include 'config.php';

// Check if admin is logged in
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Fetch user and order counts
$user_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM users"))['count'];
$order_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM orders"))['count'];
$pending_orders = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM orders WHERE status='Pending'"))['count'];

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - ACE LOGISTICS</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            height: 100vh;
            margin: 0;
        }
        .sidebar {
            width: 250px;
            background: #4756DB;
            color: white;
            padding: 20px;
        }
        .sidebar h2 { text-align: center; }
        .sidebar a {
            display: block;
            color: white;
            text-decoration: none;
            padding: 10px;
            margin: 10px 0;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 5px;
        }
        .sidebar a:hover { background: rgba(255, 255, 255, 0.4); }
        .content {
            flex: 1;
            padding: 20px;
        }
        .dashboard-cards {
            display: flex;
            gap: 20px;
        }
        .card {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            flex: 1;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <h2>Admin Panel</h2>
        <a href="#">Dashboard</a>
        <a href="#">Manage Users</a>
        <a href="#">Manage Orders</a>
        <a href="logout.php">Logout</a>
    </div>
    <div class="content">
        <h1>Welcome, Admin</h1>
        <div class="dashboard-cards">
            <div class="card">
                <h3>Total Users</h3>
                <p><?php echo $user_count; ?></p>
            </div>
            <div class="card">
                <h3>Total Orders</h3>
                <p><?php echo $order_count; ?></p>
            </div>
            <div class="card">
                <h3>Pending Orders</h3>
                <p><?php echo $pending_orders; ?></p>
            </div>
        </div>
    </div>
</body>
</html>
