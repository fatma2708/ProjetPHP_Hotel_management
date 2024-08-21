<?php
require 'controllers/RoomController.php';

$controller = new RoomController();

if (isset($_GET['action'])) {
    switch ($_GET['action']) {
        case 'create':
            $controller->create();
            break;
        case 'edit':
            if (isset($_GET['id'])) {
                $controller->edit($_GET['id']);
            } else {
                echo "No room ID specified.";
            }
            break;
        case 'delete':
            if (isset($_GET['id'])) {
                $controller->delete($_GET['id']);
            } else {
                echo "No room ID specified.";
            }
            break;
        default:
            $controller->index();
            break;
    }
} else {
    $controller->index();
}
?>
