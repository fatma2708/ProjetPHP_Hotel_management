<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/hotelmanagement/models/Booking.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/hotelmanagement/models/User.php'; 
require_once $_SERVER['DOCUMENT_ROOT'] . '/hotelmanagement/models/Room.php';

class BookingController {
    public function index() {
        $sort = $_GET['sort'] ?? 'check_in';
        $order = $_GET['order'] ?? 'asc';
        $search = $_GET['search'] ?? '';

        // Fetch all bookings with sorting and search
        $bookings = Booking::getAllBookings($sort, $order, $search);

        // Include the booking list view
        include $_SERVER['DOCUMENT_ROOT'] . '/hotelmanagement/views/booking_list.php';
    }

    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                if (isset($_POST['user_id'], $_POST['room_id'], $_POST['check_in'], $_POST['check_out'])) {
                    // Add a new booking
                    Booking::addBooking($_POST['user_id'], $_POST['room_id'], $_POST['check_in'], $_POST['check_out']);
                    header('Location: booking_index.php');
                    exit;
                } else {
                    echo "Veuillez remplir tous les champs.";
                }
            } catch (Exception $e) {
                echo "Erreur: " . $e->getMessage();
            }
        }

        // Fetch all users and rooms for selection in the booking form
        $users = User::getAllUsers();
        $rooms = Room::getAllRooms();
        require_once $_SERVER['DOCUMENT_ROOT'] . '/hotelmanagement/views/booking_form.php';
    }

    public function edit($id) {
        $booking = Booking::getBookingById($id);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                if (isset($_POST['user_id'], $_POST['room_id'], $_POST['check_in'], $_POST['check_out'])) {
                    // Update the existing booking
                    Booking::updateBooking($id, $_POST['user_id'], $_POST['room_id'], $_POST['check_in'], $_POST['check_out']);
                    header('Location: booking_index.php');
                    exit;
                } else {
                    echo "Veuillez remplir tous les champs.";
                }
            } catch (Exception $e) {
                echo "Erreur: " . $e->getMessage();
            }
        }

        // Fetch all users and rooms for selection in the booking form
        $users = User::getAllUsers();
        $rooms = Room::getAllRooms();
        require_once $_SERVER['DOCUMENT_ROOT'] . '/hotelmanagement/views/booking_form.php';
    }

    public function delete($id) {
        // Delete the booking
        Booking::deleteBooking($id);
        header('Location: booking_index.php');
        exit;
    }
}
?>
