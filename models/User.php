<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/hotelmanagement/db.php';

class User {
    public static function getAllUsers() {
        global $pdo;
        $stmt = $pdo->query("SELECT * FROM users");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function addUser($name, $email, $password, $role_id) {
        global $pdo;

        // Check if the email already exists
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $count = $stmt->fetchColumn();

        if ($count > 0) {
            throw new Exception('Cet email est déjà utilisé.');
        }

        // Hash the password before storing it
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        // Insert the new user
        $stmt = $pdo->prepare("INSERT INTO users (name, email, password, role_id) VALUES (?, ?, ?, ?)");
        $stmt->execute([$name, $email, $hashedPassword, $role_id]);
    }

    public static function getUserById($id) {
        global $pdo;
        $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function updateUser($id, $name, $email, $role_id) {
        global $pdo;
        $stmt = $pdo->prepare("UPDATE users SET name = ?, email = ?, role_id = ? WHERE id = ?");
        $stmt->execute([$name, $email, $role_id, $id]);
    }

    public static function deleteUser($id) {
        global $pdo;
        $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
        $stmt->execute([$id]);
    }
}
?>
