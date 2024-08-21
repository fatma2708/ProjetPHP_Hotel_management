<?php

class ViewRoom {
    private static $pdo;

    public static function init($pdo) {
        self::$pdo = $pdo;
    }

    public static function getAllRooms($search = '', $room_type = '', $sort = 'room_number', $order = 'asc') {
        if (!self::$pdo) {
            throw new Exception('Database connection is not initialized.');
        }

        $sql = "SELECT * FROM rooms WHERE 1=1";

        if (!empty($search)) {
            $sql .= " AND (room_number LIKE :search OR room_type LIKE :search)";
        }

        if (!empty($room_type)) {
            $sql .= " AND room_type = :room_type";
        }

        $sql .= " ORDER BY $sort $order";

        $stmt = self::$pdo->prepare($sql);

        if (!empty($search)) {
            $stmt->bindValue(':search', '%' . $search . '%');
        }
        if (!empty($room_type)) {
            $stmt->bindValue(':room_type', $room_type);
        }

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getBookingHistoryByRoomId($roomId) {
        if (!self::$pdo) {
            throw new Exception('Database connection is not initialized.');
        }

        $sql = "SELECT * FROM bookings WHERE room_id = :room_id ORDER BY check_in_date DESC";

        $stmt = self::$pdo->prepare($sql);
        $stmt->bindValue(':room_id', $roomId);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // No methods for adding, editing, or deleting rooms
}
