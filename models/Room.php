<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/hotelmanagement/db.php';

class Room {
    public static function getAllRooms($search = '', $room_type = '', $sort = 'room_number', $order = 'asc') {
        global $pdo;
    
        // Build the SQL query
        $query = "SELECT * FROM rooms WHERE 1=1";
        $params = [];
    
        if (!empty($search)) {
            $query .= " AND (room_number LIKE ? OR room_type LIKE ?)";
            $params[] = "%$search%";
            $params[] = "%$search%";
        }
    
        if (!empty($room_type)) {
            $query .= " AND room_type = ?";
            $params[] = $room_type;
        }
    
        // Add sorting to the query
        $query .= " ORDER BY $sort $order";
    
        $stmt = $pdo->prepare($query);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public static function addRoom($room_number, $room_type, $price, $status) {
        global $pdo;
        try {
            $stmt = $pdo->prepare("INSERT INTO rooms (room_number, room_type, price, status) VALUES (?, ?, ?, ?)");
            $stmt->execute([$room_number, $room_type, $price, $status]);
        } catch (PDOException $e) {
            if ($e->getCode() == 23000) { // Duplicate entry
                throw new Exception('Le numéro de chambre existe déjà.');
            } else {
                throw new Exception('Une erreur est survenue lors de l\'ajout de la chambre.');
            }
        }
    }

    public static function getRoomById($id) {
        global $pdo;
        $stmt = $pdo->prepare("SELECT * FROM rooms WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function updateRoom($id, $room_number, $room_type, $price, $status) {
        global $pdo;
        try {
            $stmt = $pdo->prepare("UPDATE rooms SET room_number = ?, room_type = ?, price = ?, status = ? WHERE id = ?");
            $stmt->execute([$room_number, $room_type, $price, $status, $id]);
        } catch (PDOException $e) {
            if ($e->getCode() == 23000) { // Duplicate entry
                throw new Exception('Le numéro de chambre existe déjà.');
            } else {
                throw new Exception('Une erreur est survenue lors de la mise à jour de la chambre.');
            }
        }
    }

    public static function deleteRoom($id) {
        global $pdo;
        try {
            $stmt = $pdo->prepare("DELETE FROM rooms WHERE id = ?");
            $stmt->execute([$id]);
        } catch (PDOException $e) {
            throw new Exception('Une erreur est survenue lors de la suppression de la chambre.');
        }
    }

    public static function getBookingHistoryByRoomId($roomId) {
        global $pdo;

        $query = "SELECT bookings.*, 
                         users.name AS user_name, 
                         DATEDIFF(check_out, check_in) AS nights, 
                         (DATEDIFF(check_out, check_in) * rooms.price) AS payment 
                  FROM bookings 
                  JOIN rooms ON bookings.room_id = rooms.id 
                  JOIN users ON bookings.user_id = users.id
                  WHERE rooms.id = ?
                  ORDER BY check_in DESC";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$roomId]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
