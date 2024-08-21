<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/hotelmanagement/models/Booking.php';

header('Content-Type: application/json'); // Set content type to JSON

if (isset($_GET['room_id'])) {
    $room_id = $_GET['room_id'];
    try {
        $bookings = Booking::getBookingHistory($room_id); // Ensure this method is implemented
        echo json_encode($bookings);
    } catch (Exception $e) {
        echo json_encode([]);
    }
} else {
    echo json_encode([]);
}
?>
