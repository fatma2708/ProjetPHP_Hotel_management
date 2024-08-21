<form action="user_index.php?action=create_user" method="POST">
    <label for="name">Nom :</label>
    <input type="text" name="name" required>

    <label for="email">Email :</label>
    <input type="email" name="email" required>

    <label for="password">Mot de passe :</label>
    <input type="password" name="password" required>

    <label for="role_id">Rôle :</label>
    <select name="role_id" required>
        <option value="1">Admin</option>
        <option value="2">Utilisateur</option>
    </select>

    <button type="submit">Créer l'utilisateur</button>
</form>
