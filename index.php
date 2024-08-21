<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/hotelmanagement/db.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/hotelmanagement/controllers/UserController.php';

$pdo = new PDO('mysql:host=localhost;dbname=hotel_management', 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


$action = $_GET['action'] ?? '';
$id = $_GET['id'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'] ?? null;
    $role_id = $_POST['role_id'];

    if ($action === 'edit' && $id) {
        $userController->edit($id, $name, $email, $password, $role_id);
    } else {
        $userController->create($name, $email, $password, $role_id);
    }

    header('Location: user_index.php');
    exit();
}

if ($action === 'edit' && $id) {
    $user = $userController->getUserById($id);
} else {
    $user = null;
}
?>