<!DOCTYPE html>
<html>
<head>
    <title>Booking Form</title>
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
    <h1><?= isset($booking) ? 'Edit Booking' : 'Add Booking' ?></h1>

    <form method="POST" action="">
        <label for="user_id">Client:</label>
        <select name="user_id" id="user_id" required>
            <?php foreach ($users as $user): ?>
                <option value="<?= htmlspecialchars($user['id']) ?>" <?= isset($booking) && $booking['user_id'] == $user['id'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($user['name']) ?>
                </option>
            <?php endforeach; ?>
        </select>
        <br>

        <label for="room_id">Chambre:</label>
        <select name="room_id" id="room_id" required>
            <?php foreach ($rooms as $room): ?>
                <option value="<?= htmlspecialchars($room['id']) ?>" <?= isset($booking) && $booking['room_id'] == $room['id'] ? 'selected' : '' ?>>
                    Chambre <?= htmlspecialchars($room['id']) ?>
                </option>
            <?php endforeach; ?>
        </select>
        <br>

        <label for="check_in">Check-In:</label>
        <input type="date" name="check_in" id="check_in" value="<?= isset($booking) ? htmlspecialchars($booking['check_in']) : '' ?>" required>
        <br>

        <label for="check_out">Check-Out:</label>
        <input type="date" name="check_out" id="check_out" value="<?= isset($booking) ? htmlspecialchars($booking['check_out']) : '' ?>" required>
        <br>

        <button type="submit"class='edit-button'>Valider</button>
    </form>
    <br>
    <a href="booking_index.php?action=index">Retour a la liste</a>
</body>
</html>
