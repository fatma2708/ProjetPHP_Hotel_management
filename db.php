<?php
$host = 'localhost';
$dbname = 'hotel_management';
$username = 'root'; // Par défaut, c'est 'root' sans mot de passe
$password = ''; // Par défaut, il n'y a pas de mot de passe

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>
