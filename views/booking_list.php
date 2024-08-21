<!DOCTYPE html>
<html>
<head>
    <title>Booking List</title>
    <style>
        .filter-form {
            margin-bottom: 20px;
        }
        .filter-form input,
        .filter-form select {
            margin-right: 10px;
        }
  table {
    font-family: "Lato", sans-serif;
    color: black;
}

  th {
    background-color: rgb(57, 5, 57);
    color: #fff;
    padding: 10px;
  }

  tr {
    background-color:white;
    padding: 10px;
    border-bottom: 1px solid #ccc;
  }

  td {
    padding: 10px;
    border-bottom: 1px solid #ccc;
  }

  tr:hover {
    background-color: #ffe6cc;
  }

  .delete-button {
    background-color: #ff0000;
    color: #fff;
    padding: 5px 10px;
    border-radius: 5px;
    cursor: pointer;
  }

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
    <h1>Booking List</h1>

    <a href="booking_index.php?action=create">Add Booking</a>

    <!-- Search and Filter Form -->
    <form method="get" action="booking_index.php" class="filter-form">
        <input type="text" name="search" placeholder="Search by room number or user name" value="<?= htmlspecialchars($search) ?>">
        <button type="submit">Filter</button>
    </form>

    <!-- Sorting Links -->
    <p>Sort by:
        <a href="booking_index.php?sort=check_in&order=asc&search=<?= urlencode($search) ?>">Check-in Asc</a> |
        <a href="booking_index.php?sort=check_in&order=desc&search=<?= urlencode($search) ?>">Check-in Desc</a> |
        <a href="booking_index.php?sort=payment&order=asc&search=<?= urlencode($search) ?>">Id client Asc</a> |
        <a href="booking_index.php?sort=payment&order=desc&search=<?= urlencode($search) ?>">Id client Desc</a>
    </p>

    <table border="1">
        <tr>
            <th>ID client</th>
            <th>ID chambre</th>
            <th>Check-In</th>
            <th>Check-Out</th>
            <th>Nuitées</th>
            <th>Prix nuitée</th>
            <th>Total</th>
            <th>Actions</th>
        </tr>
        <?php foreach ($bookings as $booking): ?>
        <tr>
            <td><?= htmlspecialchars($booking['user_id']) ?></td>
            <td><?= htmlspecialchars($booking['room_id']) ?></td>
            <td><?= htmlspecialchars($booking['check_in']) ?></td>
            <td><?= htmlspecialchars($booking['check_out']) ?></td>
            <td><?= htmlspecialchars($booking['nights']) ?></td>
            <td><?= htmlspecialchars($booking['price']) ?> EUR</td>
            <td><?= htmlspecialchars($booking['payment']) ?> EUR</td>
            <td>
                <a href="booking_index.php?action=edit&id=<?= $booking['id'] ?>">Modifier</a>
                <a href="booking_index.php?action=delete&id=<?= $booking['id'] ?>" onclick="return confirm('ètes vous sur de vouloir supprimer cette réservation?')">Supprimer</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
