<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/hotelmanagement/models/User.php';

class UserController {
    private $pdo;

    public function index() {
        $users = User::getAllUsers();
        include $_SERVER['DOCUMENT_ROOT'] . '/hotelmanagement/views/user_list.php';
    }

    public function create() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Check if all required fields are set
        if (isset($_POST['name'], $_POST['email'], $_POST['password'], $_POST['role_id'])) {
            try {
                // Attempt to add the user
                User::addUser($_POST['name'], $_POST['email'], $_POST['password'], $_POST['role_id']);
                
                // Redirect to the user list after successful creation
                header('Location: user_index.php?action=create_user');
                exit;
            } catch (Exception $e) {
                // Display an error message if an exception is thrown
                echo "Erreur: " . $e->getMessage();
            }
        } else {
            // Display a message if not all fields are filled
            echo "Veuillez remplir tous les champs.";
        }
    }
}

    public function edit($id) {
        $user = User::getUserById($id);
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            User::updateUser($id, $_POST['name'], $_POST['email'], $_POST['role_id']);
            header('Location: user_index.php?action=edit_user');
            exit;
        }
        include $_SERVER['DOCUMENT_ROOT'] . '/hotelmanagement/views/user_form.php';
    }
    public function getUserByEmail($email)
{
    $stmt = $this->pdo->prepare('SELECT * FROM users WHERE email = :email');
    $stmt->execute(['email' => $email]);
    $user = $stmt->fetch();

    return $user;
}

    public function delete($id) {
        try {
            User::deleteUser($id);
            header('Location: user_index.php?action=delete_user');
            exit;
        } catch (Exception $e) {
            // Handle any exceptions that occur during deletion
            echo "Erreur: " . $e->getMessage();
        }
    }
    public function getUserById($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }
    public function getAllUsers($sort = 'name', $order = 'asc', $search = '') {
        $query = "SELECT * FROM users WHERE name LIKE ? ORDER BY $sort $order";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(["%$search%"]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
