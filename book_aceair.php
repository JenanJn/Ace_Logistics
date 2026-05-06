<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

require 'config.php'; // Database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $customer_id = $_SESSION['user_id'];
    $package_details = $_POST['package_details'];
    $destination = $_POST['destination'];
    $tracking_number = uniqid('AIR'); // Generate tracking number for AceAir
    $service_type = "AceAir";
    $status = "Order Placed";
    $location = "Airport Hub";
    $estimated_delivery = date('Y-m-d', strtotime('+3 days'));

    // Save in database
    $stmt = $conn->prepare("INSERT INTO orders (tracking_number, customer_id, service_type, package_details, destination, status, location, estimated_delivery) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sissssss", $tracking_number, $customer_id, $service_type, $package_details, $destination, $status, $location, $estimated_delivery);
    
    if ($stmt->execute()) {
        echo "<p>Booking successful! Your Tracking Number is: <strong>$tracking_number</strong></p>";
    } else {
        echo "<p>Error: Could not complete booking.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book AceAir</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f9; text-align: center; }
        .container { width: 50%; background: white; padding: 20px; margin: auto; border-radius: 8px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); }
        input, textarea { width: 80%; padding: 10px; margin: 10px; border: 1px solid #ccc; border-radius: 5px; }
        button { background: #4756DB; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; }
    </style>
</head>
<body>
    <div class="container">
        <h3>Book AceAir</h3>
        <form method="POST">
            <textarea name="package_details" placeholder="Enter package details" required></textarea><br>
            <input type="text" name="destination" placeholder="Destination" required><br>
            <button type="submit">Book Now</button>
        </form>
    </div>
</body>
</html>
