<?php
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'receptionniste') {
    header("Location: index.php");
    exit;
}

?>

<html>
<head>
    <title>Receptionniste Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
    </style>
</head>
<body>
    <h1>Receptionniste Dashboard</h1>
    <p>Welcome, <?php echo $_SESSION['email']; ?>!</p>
    <ul>
        <li><a href="booking_index.php">Manage Bookings</a></li>
    </ul>
</body>
</html>