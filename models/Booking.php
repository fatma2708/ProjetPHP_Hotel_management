<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/hotelmanagement/db.php'; // Include the database connection

class Booking {
    public static function getAllBookings($sort = 'check_in', $order = 'asc', $search = '') {
        global $pdo;

        // Ensure valid sort column
        $validSortColumns = ['check_in', 'check_out', 'user_id', 'room_id'];
        $sort = in_array($sort, $validSortColumns) ? $sort : 'check_in';

        // Query to fetch all bookings with calculated payment
        $query = "SELECT bookings.*, 
                         rooms.price, 
                         users.name AS user_name, 
                         rooms.room_number AS room_number,
                         DATEDIFF(check_out, check_in) AS nights, 
                         (DATEDIFF(check_out, check_in) * rooms.price) AS payment 
                  FROM bookings 
                  JOIN rooms ON bookings.room_id = rooms.id 
                  JOIN users ON bookings.user_id = users.id
                  WHERE 1=1";
        $params = [];

        if (!empty($search)) {
            $query .= " AND (rooms.room_number LIKE ? OR users.name LIKE ?)";
            $params[] = "%$search%";
            $params[] = "%$search%";
        }

        $query .= " ORDER BY $sort $order";

        $stmt = $pdo->prepare($query);
        $stmt->execute($params);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function addBooking($user_id, $room_id, $check_in, $check_out) {
        global $pdo;
        $stmt = $pdo->prepare("INSERT INTO bookings (user_id, room_id, check_in, check_out) VALUES (?, ?, ?, ?)");
        $stmt->execute([$user_id, $room_id, $check_in, $check_out]);
    }

    public static function getBookingById($id) {
        global $pdo;
        $stmt = $pdo->prepare("SELECT * FROM bookings WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function updateBooking($id, $user_id, $room_id, $check_in, $check_out) {
        global $pdo;
        $stmt = $pdo->prepare("UPDATE bookings SET user_id = ?, room_id = ?, check_in = ?, check_out = ? WHERE id = ?");
        $stmt->execute([$user_id, $room_id, $check_in, $check_out, $id]);
    }

    public static function deleteBooking($id) {
        global $pdo;
        $stmt = $pdo->prepare("DELETE FROM bookings WHERE id = ?");
        $stmt->execute([$id]);
    }
    public static function getBookingHistory($room_id) {
        global $pdo;

        $stmt = $pdo->prepare("SELECT bookings.*, 
                                      users.name AS user_name, 
                                      rooms.room_number AS room_number,
                                      DATEDIFF(check_out, check_in) AS nights, 
                                      (DATEDIFF(check_out, check_in) * rooms.price) AS payment 
                               FROM bookings 
                               JOIN rooms ON bookings.room_id = rooms.id 
                               JOIN users ON bookings.user_id = users.id
                               WHERE bookings.room_id = ?
                               ORDER BY check_in DESC");
        $stmt->execute([$room_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public static function getTotalBookings() {
        global $pdo;
        $stmt = $pdo->query("SELECT COUNT(*) AS total FROM bookings");
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'];
    }

    public static function getTotalRevenue() {
        global $pdo;
        $stmt = $pdo->query("SELECT SUM(DATEDIFF(check_out, check_in) * rooms.price) AS total_revenue
                             FROM bookings
                             JOIN rooms ON bookings.room_id = rooms.id");
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total_revenue'];
    }

    public static function getBookingsPerRoom() {
        global $pdo;
        $stmt = $pdo->query("SELECT rooms.room_number, COUNT(bookings.id) AS total_bookings
                             FROM bookings
                             JOIN rooms ON bookings.room_id = rooms.id
                             GROUP BY rooms.room_number");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getBookingsPerUser() {
        global $pdo;
        $stmt = $pdo->query("SELECT users.name, COUNT(bookings.id) AS total_bookings
                             FROM bookings
                             JOIN users ON bookings.user_id = users.id
                             GROUP BY users.name");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public static function getAverageBookingDuration() {
        global $pdo;
        $stmt = $pdo->query("SELECT AVG(DATEDIFF(check_out, check_in)) AS average_duration
                             FROM bookings");
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['average_duration'];
    }
    
}
?>
