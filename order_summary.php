<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

require 'config.php'; // Database connection

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['confirm_booking'])) {
    $customer_id = $_SESSION['user_id'];
    $package_details = $_POST['package_details'];
    $destination = $_POST['destination'];
    $service_type = $_POST['service_type'];
    $tracking_number = uniqid(strtoupper(substr($service_type, 0, 3))); // Generate tracking number dynamically
    $status = "Order Placed";
    $location = ($service_type == "AceAir") ? "Airport Hub" : (($service_type == "AceMovers") ? "Movers Hub" : "Truck Depot");
    $estimated_delivery = ($service_type == "AceAir") ? date('Y-m-d', strtotime('+3 days')) : (($service_type == "AceMovers") ? date('Y-m-d', strtotime('+10 days')) : date('Y-m-d', strtotime('+7 days')));

    // Save in database
    $stmt = $conn->prepare("INSERT INTO orders (tracking_number, customer_id, service_type, package_details, destination, status, location, estimated_delivery) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sissssss", $tracking_number, $customer_id, $service_type, $package_details, $destination, $status, $location, $estimated_delivery);
    
    if ($stmt->execute()) {
        echo "<p>Booking successful! Your tracking number is $tracking_number.</p>";
    } else {
        echo "<p>Booking failed. Please try again.</p>";
    }
    $stmt->close();
    $conn->close();
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $_SESSION['package_details'] = $_POST['package_details'];
    $_SESSION['destination'] = $_POST['destination'];
    $_SESSION['service_type'] = $_POST['service_type'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirm Booking</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f4; text-align: center; padding: 20px; }
        .summary-container { background: white; padding: 20px; border-radius: 8px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); display: inline-block; }
        .btn { display: inline-block; padding: 10px 15px; background-color: #4756DB; color: white; text-decoration: none; border-radius: 5px; margin: 10px; }
    </style>
</head>
<body>
    <div class="summary-container">
        <h2>Order Summary</h2>
        <p><strong>Service Type:</strong> <?php echo htmlspecialchars($_SESSION['service_type']); ?></p>
        <p><strong>Package Details:</strong> <?php echo htmlspecialchars($_SESSION['package_details']); ?></p>
        <p><strong>Destination:</strong> <?php echo htmlspecialchars($_SESSION['destination']); ?></p>
        <form method="post" action="">
            <input type="hidden" name="package_details" value="<?php echo htmlspecialchars($_SESSION['package_details']); ?>">
            <input type="hidden" name="destination" value="<?php echo htmlspecialchars($_SESSION['destination']); ?>">
            <input type="hidden" name="service_type" value="<?php echo htmlspecialchars($_SESSION['service_type']); ?>">
            <button type="submit" name="confirm_booking" class="btn">Confirm Booking</button>
        </form>
        <a href="customer_dashboard.php" class="btn">Cancel</a>
    </div>
</body>
</html>
