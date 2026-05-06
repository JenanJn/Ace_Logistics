<?php
    session_start();
    if (!isset($_SESSION['user_id'])) {
        header("Location: login.php");
        exit();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Dashboard</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }
        .container {
            width: 80%;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
        }
        .track-order {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-bottom: 20px;
        }
        input {
            padding: 10px;
            width: 300px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            background: #4756DB;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background: #3744b1;
        }
        .section {
            margin: 20px 0;
        }
        .services {
            display: flex;
            justify-content: center;
            gap: 50px;
            margin-top: 20px;
        }
        .service-item {
            text-align: center;
            cursor: pointer;
        }
        .service-item i {
            font-size: 30px;
            color: #4756DB;
        }
        .news {
            display: flex;
            flex-direction: column;
            gap: 10px;
            margin-top: 20px;
        }
        .news-item {
            background: #ebedff;
            padding: 10px;
            border-radius: 5px;
        }
        canvas {
            width: 100% !important;
            max-height: 300px;
        }
    </style>
</head>
<body>
    <div class="container">
        <form action="tracking.php" method="GET" class="track-order">
            <input type="text" name="tracking_number" placeholder="Enter tracking number" required>
            <button type="submit">Track Order</button>
        </form>

        <div class="section">
            <h3>Customer Satisfaction Rate</h3>
            <canvas id="satisfactionChart"></canvas>
        </div>

        <div class="section">
    <h3>Services</h3>
    <div class="services">
        <div class="service-item" onclick="window.location.href='book_aceair.php'">
            <i class="fas fa-plane"></i><br>AceAir
        </div>
        <div class="service-item" onclick="window.location.href='book_acetruck.php'">
            <i class="fas fa-truck"></i><br>AceTruck
        </div>
        <div class="service-item" onclick="window.location.href='book_acemovers.php'">
            <i class="fas fa-home"></i><br>AceMovers
        </div>
    </div>
</div>


        <div class="section">
            <h3>News About Us</h3>
            <div class="news">
                <div class="news-item">New routes available with AceGlobal to Europe.</div>
                <div class="news-item">Introducing eco-friendly packaging options.</div>
                <div class="news-item">AceShip expands logistics services to Asia.</div>
                <div class="news-item">Faster shipping options now available.</div>
            </div>
        </div>
    </div>

    <script>
        const ctx = document.getElementById('satisfactionChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                datasets: [{
                    label: 'Satisfaction Rate',
                    data: [50, 60, 75, 68, 80, 76],
                    borderColor: '#4756DB',
                    borderWidth: 2,
                    fill: false,
                    tension: 0.3,
                    pointBackgroundColor: '#4756DB'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 100
                    }
                }
            }
        });
    </script>
</body>
</html>
