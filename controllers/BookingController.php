<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/hotelmanagement/models/Booking.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/hotelmanagement/models/User.php'; 
require_once $_SERVER['DOCUMENT_ROOT'] . '/hotelmanagement/models/Room.php';

class BookingController {
    private $bookingModel;

    public function __construct() {
        // Initialize the booking model
        $this->bookingModel = new Booking();
    }

    public function index() {
        $sort = isset($_GET['sort']) ? $_GET['sort'] : 'check_in';
        $order = isset($_GET['order']) ? $_GET['order'] : 'asc';
        $search = isset($_GET['search']) ? $_GET['search'] : '';

        // Fetch all bookings
        $bookings = Booking::getAllBookings($sort, $order, $search);

        // Calculate statistics
        $totalBookings = count($bookings);
        $totalRevenue = array_sum(array_column($bookings, 'payment'));
        $totalNights = array_sum(array_column($bookings, 'nights'));
        $averageBookingDuration = $totalBookings > 0 ? $totalNights / $totalBookings : 0;

        // Fetch additional statistics
        $bookingsPerRoom = Booking::getBookingsPerRoom();
        $bookingsPerUser = Booking::getBookingsPerUser();

        // Include the view file and pass the data
        include $_SERVER['DOCUMENT_ROOT'] . '/hotelmanagement/views/booking_list.php';
    }

    public function create() {
        $error = ''; // Initialize error message

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userId = $_POST['user_id'] ?? null;
            $roomId = $_POST['room_id'] ?? null;
            $checkInDate = $_POST['check_in'] ?? null;
            $checkOutDate = $_POST['check_out'] ?? null;

            // Validate input
            if (!$userId || !$roomId || !$checkInDate || !$checkOutDate) {
                $error = "Veuillez remplir tous les champs.";
            } elseif (strtotime($checkOutDate) <= strtotime($checkInDate)) {
                $error = "La date de départ doit être après la date d'arrivée.";
            } else {
                try {
                    // Add a new booking
                    Booking::addBooking($userId, $roomId, $checkInDate, $checkOutDate);
                    header('Location: booking_index.php');
                    exit;
                } catch (Exception $e) {
                    $error = "Erreur: " . $e->getMessage();
                }
            }
        }

        // Fetch all users and rooms for selection in the booking form
        $users = User::getAllUsers();
        $rooms = Room::getAllRooms();
        require_once $_SERVER['DOCUMENT_ROOT'] . '/hotelmanagement/views/booking_form.php';
    }

    public function edit($id) {
        $error = ''; // Initialize error message
        $booking = Booking::getBookingById($id);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userId = $_POST['user_id'] ?? null;
            $roomId = $_POST['room_id'] ?? null;
            $checkInDate = $_POST['check_in'] ?? null;
            $checkOutDate = $_POST['check_out'] ?? null;

            // Validate input
            if (!$userId || !$roomId || !$checkInDate || !$checkOutDate) {
                $error = "Veuillez remplir tous les champs.";
            } elseif (strtotime($checkOutDate) <= strtotime($checkInDate)) {
                $error = "La date de départ doit être après la date d'arrivée.";
            } else {
                try {
                    // Update the existing booking
                    Booking::updateBooking($id, $userId, $roomId, $checkInDate, $checkOutDate);
                    header('Location: booking_index.php');
                    exit;
                } catch (Exception $e) {
                    $error = "Erreur: " . $e->getMessage();
                }
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

    public function getStatistics() {
        // Fetch statistics data
        $totalBookings = $this->bookingModel->getTotalBookings();
        $totalRevenue = $this->bookingModel->getTotalRevenue();
        $averageDuration = $this->bookingModel->getAverageBookingDuration();
        $bookingsPerRoom = $this->bookingModel->getBookingsPerRoom();
        $bookingsPerUser = $this->bookingModel->getBookingsPerUser();

        return [
            'totalBookings' => $totalBookings,
            'totalRevenue' => $totalRevenue,
            'averageDuration' => $averageDuration,
            'bookingsPerRoom' => $bookingsPerRoom,
            'bookingsPerUser' => $bookingsPerUser,
        ];
    }

    public function statistics() {
        $data = $this->getStatistics();
        $chartData = [
            'labels' => array_column($data['bookingsPerRoom'], 'room_id'),
            'data' => array_column($data['bookingsPerRoom'], 'count')
        ];
        include 'views/statistics.php';
    }
}
?>
