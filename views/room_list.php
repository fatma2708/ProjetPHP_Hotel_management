<!DOCTYPE html>
<html>
<head>
    <title>Room List</title>
    <style>
        .container {
            display: flex;
        }
        .room-list {
            flex: 2;
        }
        .booking-history {
            flex: 1;
            margin-left: 20px;
            padding: 10px;
            border-left: 1px solid #ccc;
        }
        .filter-form {
            margin-bottom: 20px;
        }
        .filter-form input,
        .filter-form select {
            margin-right: 10px;
        }
        /* Add CSS for clickable rows */
        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #ccc;
            color: black;
        }
        th {
            background-color: rgb(57, 5, 57);
            color: #fff;
            padding: 10px;
        }
        td {
            padding: 10px;
            border-bottom: 1px solid #ccc;
  }
        tr {
            cursor: pointer;
        }
        tr:hover {
            background-color: #f5f5f5;
        }
        body {
      font-family: "Lato", sans-serif;
      background-image: url(assets/img/hero_2.jpg);
      color: #ccc;
  }
    </style>
    <script>
        function loadHistory(roomId) {
            // Create an XMLHttpRequest object
            var xhr = new XMLHttpRequest();
            
            // Configure it: GET-request for the URL with roomId parameter
            xhr.open('GET', 'get_booking_history.php?room_id=' + roomId, true);
            
            // Set up a function to run when the request completes
            xhr.onload = function() {
                if (xhr.status >= 200 && xhr.status < 300) {
                    // Parse the JSON response
                    var history = JSON.parse(xhr.responseText);
                    
                    // Get the booking history container
                    var historyContainer = document.getElementById('booking-history');
                    
                    // Clear any previous content
                    historyContainer.innerHTML = '<h2>Booking & Payment History</h2>';
                    
                    if (history.length > 0) {
                        // Create a list for the booking history
                        var ul = document.createElement('ul');
                        history.forEach(function(booking) {
                            var li = document.createElement('li');
                            li.textContent = booking.user_name + ' - Room ' + booking.room_number + 
                                              ' - ' + booking.check_in + ' to ' + booking.check_out + 
                                              ' - Payment: ' + booking.payment;
                            ul.appendChild(li);
                        });
                        historyContainer.appendChild(ul);
                    } else {
                        historyContainer.innerHTML += '<p>No booking history available for this room.</p>';
                    }
                } else {
                    console.error('Failed to fetch history');
                }
            };
            
            // Send the request
            xhr.send();
        }
    </script>
</head>
<body>
    <div class="container">
        <!-- Room List Section -->
        <div class="room-list">
            <h1>Room List</h1>
            
            <a href="room_index.php?action=create">Add Room</a>

            <!-- Search and Filter Form -->
            <form method="get" action="room_index.php" class="filter-form">
                <input type="text" name="search" placeholder="Search by room number" value="<?= htmlspecialchars($search) ?>">
                <select name="room_type">
                    <option value="">All Room Types</option>
                    <option value="single" <?= $room_type == 'single' ? 'selected' : '' ?>>Single</option>
                    <option value="double" <?= $room_type == 'double' ? 'selected' : '' ?>>Double</option>
                    <option value="suite" <?= $room_type == 'suite' ? 'selected' : '' ?>>Suite</option>
                </select>
                <button type="submit">Filter</button>
            </form>

            <!-- Sorting Links -->
            <p>Sort by:
                <a href="room_index.php?sort=room_number&order=asc&search=<?= urlencode($search) ?>&room_type=<?= urlencode($room_type) ?>">Num chambre Asc</a> |
                <a href="room_index.php?sort=room_number&order=desc&search=<?= urlencode($search) ?>&room_type=<?= urlencode($room_type) ?>">Num chambre Desc</a> |
                <a href="room_index.php?sort=price&order=asc&search=<?= urlencode($search) ?>&room_type=<?= urlencode($room_type) ?>">Prix Asc</a> |
                <a href="room_index.php?sort=price&order=desc&search=<?= urlencode($search) ?>&room_type=<?= urlencode($room_type) ?>">Prix Desc</a>
            </p>

            <table>
                <tr>
                    <th>Numéro</th>
                    <th>Type</th>
                    <th>Prix</th>
                    <th>Statut</th>
                    <th>Actions</th>
                </tr>
                <?php foreach ($rooms as $room): ?>
                <tr onclick="loadHistory(<?= $room['id'] ?>)">
                    <td><?= htmlspecialchars($room['room_number']) ?></td>
                    <td><?= htmlspecialchars($room['room_type']) ?></td>
                    <td><?= htmlspecialchars($room['price']) ?></td>
                    <td><?= htmlspecialchars($room['status']) ?></td>
                    <td>
                        <a href="room_index.php?action=edit&id=<?= $room['id'] ?>">Modifier</a>
                        <a href="room_index.php?action=delete&id=<?= $room['id'] ?>" onclick="return confirm('ètes vous sur de vouloir supprimer cette chambre?')">Supprimer</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </table>
        </div>

        <!-- Booking History Section -->
        <div class="booking-history" id="booking-history">
            <h2>Historique de réservation et paiement</h2>
            <p>Selectionner une chambre pour afficher son historique.</p>
        </div>
    </div>
</body>
</html>
