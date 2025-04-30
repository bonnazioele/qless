<?php
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = $_POST['role'];

    $stmt = $pdo->prepare("INSERT INTO users (name, username, password, role) VALUES (?, ?, ?, ?)");
    if ($stmt->execute([$name, $username, $password, $role])) {
        echo "Account created successfully. <a href='login.php'>Login here</a>";
    } else {
        echo "Error creating account.";
    }
}
?>

<h2>Register - QLess</h2>
<form method="post">
    <input type="text" name="name" placeholder="Full Name" required><br>
    <input type="text" name="username" placeholder="Username" required><br>
    <input type="password" name="password" placeholder="Password" required><br>
    <select name="role" required>
        <option value="driver">Driver</option>
        <option value="admin">Admin</option>
    </select><br>
    <button type="submit">Register</button>
</form>
