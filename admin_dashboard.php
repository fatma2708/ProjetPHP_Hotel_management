<?php
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: index.php");
    exit;
}

?>

<html>
<head>
    <title>Admin Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
    </style>
</head>
<body>
    <h1>Admin Dashboard</h1>
    <p>Welcome, <?php echo $_SESSION['email']; ?>!</p>
    <ul>
        <li><a href="user_index.php">Manage Users</a></li>
        <li><a href="booking_index.php">Manage Bookings</a></li>
        <li><a href="room_index.php">Manage Rooms</a></li>
    </ul>
</body>
</html>