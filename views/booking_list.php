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
            width: 65%; /* Adjust width for table */
            float: left; /* Float table to the left */
        }
        th {
            background-color: rgb(57, 5, 57);
            color: #fff;
            padding: 10px;
        }
        tr {
            background-color: white;
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
        .statistics {
            width: 30%; /* Adjust width for statistics */
            float: right; /* Float statistics to the right */
            background-color: #fff;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
            font-family: "Lato", sans-serif;
        }
        .statistics h2 {
            color: rgb(57, 5, 57);
            font-size: 1.5em;
            margin-top: 0;
        }
        .statistics p,
        .statistics ul {
            margin: 10px 0;
        }
        .statistics ul {
            padding-left: 20px;
        }
        body {
            font-family: "Lato", sans-serif;
            color: #333;
            background-image: url(assets/img/hero_2.jpg);
            background-size: cover;
            margin: 0;
            padding: 20px;
        }
        a {
            color: white;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
        .chart-container {
            width: 100%;
            height: 300px;
            margin-bottom: 20px;
        }
        h1{
          color:white;
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <h1>Liste des réservations</h1>

    <a href="booking_index.php?action=create"class='edit-button'>Ajouter</a>
    <a href="statistics.php" class='edit-button'>Voir statistiques</a>


    <!-- Search and Filter Form -->
    <form method="get" action="booking_index.php" class="filter-form">
        <input type="text" name="search" placeholder="Search by room number or user name" value="<?= htmlspecialchars($search) ?>">
        <button type="submit">Filtrer</button>
    </form>

    <!-- Sorting Links -->
    <p>Trier par:
        <a href="booking_index.php?sort=check_in&order=asc&search=<?= urlencode($search) ?>">Check-in Asc</a> |
        <a href="booking_index.php?sort=check_in&order=desc&search=<?= urlencode($search) ?>">Check-in Desc</a> |

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
                <a href="booking_index.php?action=edit&id=<?= $booking['id'] ?>" class="edit-button">Modifier</a>
                <a href="booking_index.php?action=delete&id=<?= $booking['id'] ?>" class="delete-button" onclick="return confirm('Etes vous sur de vouloir supprimer cette réservation?')">Supprimer</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>


 


   