<?php
session_start();

// Redirect logged-in users based on their role
if (isset($_SESSION['user'])) {
    if ($_SESSION['user']['role'] === 'admin') {
        header("Location: admin.php");
        exit;
    } elseif ($_SESSION['user']['role'] === 'driver') {
        header("Location: book.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Welcome to QLess</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
            padding-top: 100px;
        }
        .centered-box {
            text-align: center;
            max-width: 500px;
            margin: auto;
        }
        h1 {
            font-weight: bold;
        }
        .btn-group {
            margin-top: 20px;
        }
        .register-note {
            margin-top: 15px;
            font-size: 14px;
            color: #555;
        }
    </style>
</head>
<body>

<div class="centered-box">
    <h1>Welcome to QLess</h1>
    <p class="lead">Queue-free Truck Appointment & Slot Booking System</p>
    
    <div class="btn-group">
        <a href="login.php" class="btn btn-primary">Login</a>
    </div>

    <div class="register-note">
        <p>Not registered yet?</p>
        <a href="register.php" class="btn btn-outline-secondary">Register</a>
    </div>
</div>

</body>
</html>
