<?php
session_start();
require 'config.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    echo "Access denied.";
    exit;
}

$bookings = $pdo->query("
    SELECT u.name, s.slot_time, b.container_type, b.created_at 
    FROM bookings b
    JOIN users u ON b.user_id = u.id
    JOIN slots s ON b.slot_id = s.id
    ORDER BY b.created_at DESC
")->fetchAll();
?>

<h2>QLess Admin Dashboard - Bookings</h2>
<table border="1" cellpadding="10">
    <tr>
        <th>Driver Name</th>
        <th>Slot Time</th>
        <th>Container Type</th>
        <th>Booked At</th>
    </tr>
    <?php foreach ($bookings as $b): ?>
        <tr>
            <td><?= htmlspecialchars($b['name']) ?></td>
            <td><?= date('h:i A', strtotime($b['slot_time'])) ?></td>
            <td><?= $b['container_type'] ?></td>
            <td><?= $b['created_at'] ?></td>
        </tr>
    <?php endforeach; ?>
</table>
