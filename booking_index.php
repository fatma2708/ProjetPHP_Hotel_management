<?php
require 'controllers/BookingController.php';

$controller = new BookingController();

if (isset($_GET['action'])) {
    switch ($_GET['action']) {
        case 'create':
            $controller->create();
            break;
        case 'edit':
            if (isset($_GET['id'])) {
                $controller->edit($_GET['id']);
            } else {
                echo "Booking ID is required.";
            }
            break;
        case 'delete':
            if (isset($_GET['id'])) {
                $controller->delete($_GET['id']);
            } else {
                echo "Booking ID is required.";
            }
            break;
        case 'statistics':
            $controller->statistics();
            break;
        default:
            $controller->index();
            break;
    }
} else {
    $controller->index();
}
?>
