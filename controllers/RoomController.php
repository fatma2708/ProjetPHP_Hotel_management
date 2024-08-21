<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/hotelmanagement/models/Room.php';

class RoomController {
    public function index() {
        $search = $_GET['search'] ?? '';
        $room_type = $_GET['room_type'] ?? '';
        $sort = $_GET['sort'] ?? 'room_number'; // Default sort by room_number
        $order = $_GET['order'] ?? 'asc'; // Default order ascending
        $roomId = $_GET['id'] ?? null; // Get room ID if available

        // Ensure valid sort and order values
        $validSorts = ['room_number', 'price'];
        $validOrders = ['asc', 'desc'];
        $sort = in_array($sort, $validSorts) ? $sort : 'room_number';
        $order = in_array($order, $validOrders) ? $order : 'asc';

        try {
            // Get the list of rooms
            $rooms = Room::getAllRooms($search, $room_type, $sort, $order);

            // Get booking history if a room ID is specified
            $bookingHistory = [];
            if ($roomId) {
                $bookingHistory = Room::getBookingHistoryByRoomId($roomId);
            }

            include $_SERVER['DOCUMENT_ROOT'] . '/hotelmanagement/views/room_list.php';
        } catch (Exception $e) {
            echo "Erreur: " . $e->getMessage();
        }
    }

    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                // Input validation
                $this->validateRoomData($_POST['room_number'], $_POST['room_type'], $_POST['price'], $_POST['status']);

                // If validation passes, proceed with room creation
                Room::addRoom($_POST['room_number'], $_POST['room_type'], $_POST['price'], $_POST['status']);
                header('Location: room_index.php'); // Redirect to room index after adding
                exit;
            } catch (Exception $e) {
                // Display the error message if an exception is thrown
                echo "Erreur: " . $e->getMessage();
            }
        }
        // Display the form when not a POST request
        require_once $_SERVER['DOCUMENT_ROOT'] . '/hotelmanagement/views/room_form.php';
    }

    public function edit($id) {
        $room = Room::getRoomById($id); // Fetch room data for the given ID

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                // Input validation
                $this->validateRoomData($_POST['room_number'], $_POST['room_type'], $_POST['price'], $_POST['status']);

                // If validation passes, proceed with room update
                Room::updateRoom($id, $_POST['room_number'], $_POST['room_type'], $_POST['price'], $_POST['status']);
                header('Location: room_index.php'); // Redirect to room index after updating
                exit;
            } catch (Exception $e) {
                // Display the error message if an exception is thrown
                echo "Erreur: " . $e->getMessage();
            }
        }

        if ($room) {
            require_once $_SERVER['DOCUMENT_ROOT'] . '/hotelmanagement/views/room_form.php';
        } else {
            echo "Room data not found.";
        }
    }

    public function delete($id) {
        try {
            Room::deleteRoom($id);
            header('Location: room_index.php');
            exit;
        } catch (Exception $e) {
            // Handle any exceptions that occur during deletion
            echo "Erreur: " . $e->getMessage();
        }
    }

    private function validateRoomData($room_number, $room_type, $price, $status) {
        // Check if room number is numeric and positive
        if (!is_numeric($room_number) || $room_number <= 0) {
            throw new Exception('Numéro de chambre invalide.');
        }

        // Check if room type is a non-empty string
        if (empty($room_type) || !is_string($room_type)) {
            throw new Exception('Type de chambre invalide.');
        }

        // Check if price is a valid number
        if (!is_numeric($price) || $price <= 0) {
            throw new Exception('Prix invalide.');
        }

        // Check if status is either 'available' or 'booked'
        $validStatuses = ['available', 'booked'];
        if (!in_array($status, $validStatuses)) {
            throw new Exception('Statut invalide.');
        }
    }
}
?>
