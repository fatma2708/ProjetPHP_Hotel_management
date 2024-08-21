<?php
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'client') {
    header("Location: index.php");
    exit;
}

?>

<html>
<head>
    <title>Client Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
    </style>
</head>
<body>
    <h1>Client Dashboard</h1>
    <p>Welcome, <?php echo $_SESSION['email']; ?>!</p>
    <ul>
        <li><a href="view_rooms.php">View Rooms</a></li>
    </ul>
</body>
</html>