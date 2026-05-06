<?php
require 'config.php'; // Ensure this file contains the database connection

// Check if tracking number is provided
if (!isset($_GET['tracking_number']) || empty($_GET['tracking_number'])) {
    echo "<div class='tracking-container'><p class='error'>No tracking number provided.</p>";
    echo "<a href='customer_dashboard.php' class='btn'>Go Back to Home</a></div>";
    exit;
}

$tracking_number = $_GET['tracking_number'];

// Prepare SQL query to fetch order details
$sql = "SELECT * FROM orders WHERE tracking_number = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $tracking_number);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Track Your Shipment</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .tracking-container {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 400px;
            text-align: center;
        }
        h2 {
            color: #4756DB;
        }
        .tracking-info {
            text-align: left;
            margin-top: 15px;
        }
        .tracking-info p {
            font-size: 16px;
            margin: 8px 0;
        }
        .error {
            color: red;
            font-size: 18px;
        }
        .btn {
            display: inline-block;
            padding: 10px 15px;
            background-color: #4756DB;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 15px;
        }
    </style>
</head>
<body>
    <div class="tracking-container">
        <?php if ($result->num_rows > 0) {
            $order = $result->fetch_assoc(); ?>
            <h2>Tracking Details</h2>
            <div class="tracking-info">
                <p><strong>Tracking Number:</strong> <?php echo htmlspecialchars($order['tracking_number']); ?></p>
                <p><strong>Service Type:</strong> <?php echo htmlspecialchars($order['service_type']); ?></p>
                <p><strong>Package Details:</strong> <?php echo htmlspecialchars($order['package_details']); ?></p>
                <p><strong>Destination:</strong> <?php echo htmlspecialchars($order['destination']); ?></p>
                <p><strong>Status:</strong> <?php echo htmlspecialchars($order['status']); ?></p>
                <p><strong>Current Location:</strong> <?php echo htmlspecialchars($order['location']); ?></p>
                <p><strong>Estimated Delivery:</strong> <?php echo htmlspecialchars($order['estimated_delivery']); ?></p>
                <p><strong>Booking Date:</strong> <?php echo htmlspecialchars($order['booking_date']); ?></p>
            </div>
        <?php } else { ?>
            <p class='error'>No order found with this tracking number.</p>
        <?php } ?>
        <a href='customer_dashboard.php' class='btn'>Go Back to Home</a>
    </div>
</body>
</html>
<?php
$stmt->close();
$conn->close();
?>
