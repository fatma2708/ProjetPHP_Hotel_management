<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/hotelmanagement/db.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/hotelmanagement/controllers/UserController.php';

$pdo = new PDO('mysql:host=localhost;dbname=hotel_management', 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$userController = new UserController($pdo);

$action = $_GET['action'] ?? '';
$id = $_GET['id'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role_id = $_POST['role_id'];

    // Check if email is already in use
    $existingUser = $userController->getUserByEmail($email);

    if ($existingUser) {
        $error = 'Email is already in use. Please choose a different email.';
    } else {
        if ($action === 'edit_user' && $id) {
            $userController->edit($id, $name, $email, $password, $role_id);
        } else {
            $userController->create($name, $email, $password, $role_id);
        }

        header('Location: user_index.php');
        exit();
    }
}

if ($action === 'delete_user' && $id) {
    $userController->delete($id);
    header('Location: user_index.php');
    exit();
}

$users = $userController->getAllUsers();
$user = null;

if ($action === 'edit_user' && $id) {
    $user = $userController->getUserById($id);
}
?>

<!-- Rest of your HTML code remains the same -->

<!DOCTYPE html>
<html>
<head>
    <title>Liste d'utilisateurs</title>
    <style>
  /* Add a cute font to the table */
  table {
    font-family: "Lato", sans-serif;
    color: black;
}

  /* Make the table headers cute */
  th {
    background-color: rgb(57, 5, 57);
    color: #fff;
    padding: 10px;
  }

  /* Make the table rows cute */
  tr {
    background-color:white;
    padding: 10px;
    border-bottom: 1px solid #ccc;
  }

  /* Make the table data cute */
  td {
    padding: 10px;
    border-bottom: 1px solid #ccc;
  }

  /* Add a cute hover effect to the table rows */
  tr:hover {
    background-color: #ffe6cc;
  }

  /* Make the delete button cute */
  .delete-button {
    background-color: #ff0000;
    color: #fff;
    padding: 5px 10px;
    border-radius: 5px;
    cursor: pointer;
  }

  /* Make the edit button cute */
  .edit-button {
    background-color: rgb(57, 5, 57);
    color: #fff;
    padding: 5px 10px;
    border-radius: 5px;
    cursor: pointer;
  }
  body {
      font-family: "Lato", sans-serif;
      color: #ccc;
      background-image: url(assets/img/hero_2.jpg);
      
  }
  
  
</style>
</head>
<body>
    <h1>Utilisateurs</h1>
    <a href="user_index.php?action=create_user"class='edit-button'>Ajouter un utilisateur</a>
    
    <?php if ($action === 'create_user' || $action === 'edit_user'): ?>
        <h2><?= $action === 'edit_user' ? 'Edit User' : 'Create User' ?></h2>
        <form action="user_index.php?action=<?= $action ?><?= $user ? '&id=' . $user['id'] : '' ?>" method="POST">
            <label for="name">Nom :</label>
            <input type="text" name="name" value="<?= $user['name'] ?? '' ?>" required>

            <label for="email">Email :</label>
            <input type="email" name="email" value="<?= $user['email'] ?? '' ?>" required>

            <?php if (isset($error)): ?>
                <p style="color: red;"><?= $error ?></p>
            <?php endif; ?>

            <label for="password">Mot de passe :</label>
            <input type="password" name="password" required>

            <label for="role_id">Rôle :</label>
            <select name="role_id" required>
                <option value="1" <?= $user && $user['role_id'] == 1 ? 'selected' : '' ?>>Admin</option>
                <option value="2" <?= $user && $user['role_id'] == 2 ? 'selected' : '' ?>>Client</option>
                <option value="3" <?= $user && $user['role_id'] == 2 ? 'selected' : '' ?>>Réceptionniste</option>

            </select>

            <button type="submit"class="edit-button"><?= $action === 'edit_user' ? 'Modifier l\'utilisateur' : 'Créer l\'utilisateur' ?></button>
        </form>
    <?php endif; ?>

    <h2>Utilisateurs existants</h2>
    <table border="1">
        <tr>
            <th>Nom</th>
            <th>Email</th>
            <th>Actions</th>
        </tr>
        <?php foreach ($users as $user): ?>
        <tr>
            <td><?= htmlspecialchars($user['name']) ?></td>
            <td><?= htmlspecialchars($user['email']) ?></td>
            <td>
                <a href="user_index.php?action=edit_user&id=<?= $user['id'] ?>">Modifier</a>
                <a href="user_index.php?action=delete_user&id=<?= $user['id'] ?>">Supprimer</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>