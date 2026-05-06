<?php
session_start();
include 'config.php'; // Database connection

$message = ""; // Message placeholder

// REGISTER USER
if (isset($_POST['register'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $role = $_POST['role'];

    // Check if email already exists
    $check_email = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
    if (mysqli_num_rows($check_email) > 0) {
        $message = "Email already registered.";
    } else {
        // Insert user into DB
        $query = "INSERT INTO users (name, email, password, role) VALUES ('$name', '$email', '$password', '$role')";
        if (mysqli_query($conn, $query)) {
            $message = "Registration successful!";
        } else {
            $message = "Error: " . mysqli_error($conn);
        }
    }
}

// LOGIN USER
if (isset($_POST['login'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];

    $query = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
    if (mysqli_num_rows($query) == 1) {
        $row = mysqli_fetch_assoc($query);
        if (password_verify($password, $row['password'])) {
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['role'] = $row['role'];

            // Redirect based on role
            if ($row['role'] == 'admin') {
                header("Location: admin_dashboard.php");
            } else {
                header("Location: customer_dashboard.php");
            }
            exit();
        } else {
            $message = "Incorrect password.";
        }
    } else {
        $message = "User not found.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login & Register - ACE LOGISTICS</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: url('background.jpg') no-repeat center center/cover;
        }
        .container {
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            width: 90%;
            max-width: 380px;
            text-align: center;
        }
        .container h2 {
            color: #4756DB;
            margin-bottom: 20px;
            font-size: 22px;
        }
        .message {
            color: green;
            margin-bottom: 10px;
        }
        input, select {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 16px;
        }
        button {
            width: 100%;
            background: #4756DB;
            color: white;
            padding: 12px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 16px;
            transition: 0.3s;
        }
        button:hover {
            background: #3745C5;
        }
        .toggle {
            margin-top: 15px;
            color: #555;
            font-size: 14px;
            cursor: pointer;
        }
        .toggle a {
            text-decoration: none;
            color: #4756DB;
            font-weight: bold;
            cursor: pointer;
        }
    </style>
    <script>
        function toggleForm(type) {
            document.getElementById('registerForm').style.display = type === 'register' ? 'block' : 'none';
            document.getElementById('loginForm').style.display = type === 'login' ? 'block' : 'none';
        }
    </script>
</head>
<body>
    <div class="container">
        <h2>Welcome to ACE LOGISTICS</h2>
        <?php if ($message) echo "<p class='message'>$message</p>"; ?>
        
        <div id="registerForm">
            <h3>Create an account</h3>
            <form method="POST">
                <input type="text" name="name" placeholder="Full Name" required>
                <input type="email" name="email" placeholder="Email Address" required>
                <input type="password" name="password" placeholder="Password" required>
                <select name="role">
                    <option value="customer">Customer</option>
                    <option value="admin">Admin</option>
                </select>
                <button type="submit" name="register">Sign Up</button>
            </form>
            <p class="toggle">Already have an account? <a href="#" onclick="toggleForm('login')">Sign in</a></p>
        </div>
        
        <div id="loginForm" style="display: none;">
            <h3>Sign In</h3>
            <form method="POST">
                <input type="email" name="email" placeholder="Email Address" required>
                <input type="password" name="password" placeholder="Password" required>
                <button type="submit" name="login">Login</button>
            </form>
            <p class="toggle">Don't have an account? <a href="#" onclick="toggleForm('register')">Register</a></p>
        </div>
    </div>
</body>
</html>
