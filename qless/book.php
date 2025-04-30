<?php
session_start();
require 'config.php';

function estimateUnloadingTime($container_type) {
    switch ($container_type) {
        case '20GP': return '30–45 minutes';
        case '40GP': return '45–90 minutes';
        case '40HC': return '60–100 minutes';
        case '45HC': return '75–120 minutes';
        default: return 'Unknown – please specify container type';
    }
}

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'driver') {
    echo "Access denied. Please login as a driver.";
    exit;
}

$slots = $pdo->query("SELECT * FROM slots WHERE is_booked = 0")->fetchAll();

$estimate = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $slot_id = $_POST['slot_id'];
    $user_id = $_SESSION['user']['id'];
    $container_type = $_POST['container_type'];
    $estimate = estimateUnloadingTime($container_type);

    if (isset($_POST['confirm_booking'])) {
        $pdo->prepare("UPDATE slots SET is_booked = 1 WHERE id = ?")->execute([$slot_id]);
        $stmt = $pdo->prepare("INSERT INTO bookings (user_id, slot_id, container_type) VALUES (?, ?, ?)");
        $stmt->execute([$user_id, $slot_id, $container_type]);
        echo "<script>alert('Slot booked successfully!'); window.location.href='book.php';</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>QLess Slot Booking</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #f4f4f4; padding: 40px; font-family: Arial; }
        form {
            background: #fff;
            padding: 25px;
            max-width: 500px;
            margin: auto;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .estimate {
            font-weight: bold;
            margin-top: 10px;
            color: #333;
        }
    </style>
</head>
<body>

<h2 class="text-center mb-4">Book a Slot - QLess</h2>

<form method="post">
    <label>Select Slot:</label>
    <select name="slot_id" class="form-select mb-3" required>
        <option value="">-- Choose Time Slot --</option>
        <?php foreach ($slots as $slot): ?>
            <option value="<?= $slot['id'] ?>"><?= date('h:i A', strtotime($slot['slot_time'])) ?></option>
        <?php endforeach; ?>
    </select>

    <label>Select Container Type:</label>
    <select name="container_type" class="form-select mb-3" onchange="this.form.submit()" required>
        <option value="">-- Choose Container Type --</option>
        <option value="20GP" <?= isset($_POST['container_type']) && $_POST['container_type'] == '20GP' ? 'selected' : '' ?>>20ft General Purpose (20GP)</option>
        <option value="40GP" <?= isset($_POST['container_type']) && $_POST['container_type'] == '40GP' ? 'selected' : '' ?>>40ft General Purpose (40GP)</option>
        <option value="40HC" <?= isset($_POST['container_type']) && $_POST['container_type'] == '40HC' ? 'selected' : '' ?>>40ft High Cube (40HC)</option>
        <option value="45HC" <?= isset($_POST['container_type']) && $_POST['container_type'] == '45HC' ? 'selected' : '' ?>>45ft High Cube (45HC)</option>
    </select>

    <?php if (!empty($estimate)): ?>
        <div class="estimate">
            📦 Estimated Unloading Time: <?= htmlspecialchars($estimate) ?>
        </div>
        <input type="hidden" name="confirm_booking" value="1">
        <button type="submit" class="btn btn-success mt-3">Confirm Booking</button>
    <?php endif; ?>
</form>

</body>
</html>
