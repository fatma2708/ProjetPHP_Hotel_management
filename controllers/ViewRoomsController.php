<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/hotelmanagement/models/ViewRoom.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/hotelmanagement/db.php';

class ViewRoomsController {
    public function __construct() {
        // Initialize the PDO connection in ViewRoom
        ViewRoom::init($GLOBALS['pdo']);
    }

    public function index() {
        $search = $_GET['search'] ?? '';
        $room_type = $_GET['room_type'] ?? '';
        $sort = $_GET['sort'] ?? 'room_number';
        $order = $_GET['order'] ?? 'asc';
        $roomId = $_GET['id'] ?? null;

        try {
            $rooms = ViewRoom::getAllRooms($search, $room_type, $sort, $order);

            $bookingHistory = [];
            if ($roomId) {
                $bookingHistory = ViewRoom::getBookingHistoryByRoomId($roomId);
            }

            include $_SERVER['DOCUMENT_ROOT'] . '/hotelmanagement/views/viewroomlist.php';
        } catch (Exception $e) {
            echo "Erreur: " . $e->getMessage();
        }
    }

    // No create, edit, or delete methods here
}
