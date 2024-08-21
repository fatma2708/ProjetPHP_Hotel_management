<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Room Form</title>
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
    border-radius: 10px;
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
    <?php if (isset($error_message)): ?>
        <div style="color: red;">
            <?= htmlspecialchars($error_message) ?>
        </div>
    <?php endif; ?>

    <form action="<?= isset($room) ? "room_index.php?action=edit&id={$room['id']}" : "room_index.php?action=create" ?>" method="POST">
        <label for="room_number">Numéro de chambre :</label>
        <input type="text" name="room_number" value="<?= isset($room) ? htmlspecialchars($room['room_number']) : '' ?>" required>

        <label for="room_type">Type de chambre :</label>
        <input type="text" name="room_type" value="<?= isset($room) ? htmlspecialchars($room['room_type']) : '' ?>" required>

        <label for="price">Prix :</label>
        <input type="text" name="price" value="<?= isset($room) ? htmlspecialchars($room['price']) : '' ?>" required>

        <label for="status">Statut :</label>
        <select name="status" required>
            <option value="available" <?= isset($room) && $room['status'] == 'available' ? 'selected' : '' ?>>Disponible</option>
            <option value="booked" <?= isset($room) && $room['status'] == 'booked' ? 'selected' : '' ?>>Réservé</option>
        </select>

        <button type="submit"><?= isset($room) ? 'Update Room' : 'Create Room' ?></button>
    </form>
</body>
</html>
