<?php
declare(strict_types=1);
include '../includes/db_connection.php';
include './functions.php';

switch ($_SERVER['REQUEST_METHOD']) {
    case "GET":
        if (isset($_GET['scheduled_date']))
            return printJsonData(200, getAppointmentsByScheduledDate($_GET['scheduled_date']));
        if (isset($_GET['search']) && !isset($_GET['customer_id']))
            return printJsonData(200, getAppointmentsBySearch($_GET['search']));
        if (isset($_GET['customer_id']))
            if (isset($_GET['search']))
                return printJsonData(200, getAppointmentsByCustomerAndSearch((int) $_GET['customer_id'], $_GET['search']));
            else
                return printJsonData(200, getAppointmentsByCustomer((int) $_GET['customer_id']));
        if (isset($_GET['stylist_id']))
            return printJsonData(200, getAppointmentsByStylist($_GET['stylist_id']));
        if (isset($_GET['status']))
            return printJsonData(200, getAppointmentsByStatus($_GET['status']));
        if (isset($_GET['id']))
            return printJsonData(200, getAppointmentById($_GET['id']));
        return printJsonData(200, getAllAppointments());
    case "POST":
        if (!isset($_POST['customer_id']) || !isset($_POST['stylist_id']) || !isset($_POST['service_id']) || !isset($_POST['status']) || !isset($_POST['scheduled_date']))
            return printJsonData(400, "Missing required fields");
        if (!in_array($_POST['stylist_id'], array_column(getAvailableStylists($_POST['service_id'], $_POST['scheduled_date']), "stylist_id")))
            return printJsonData(400, "All stylists are unavailable at your requested time. Please choose a different time or service");
        return createAppointment((int) $_POST['customer_id'], (int) $_POST['stylist_id'], (int) $_POST['service_id'], $_POST['status'], $_POST['scheduled_date']) == -1 ? printJsonData(400, "Error creating appointment") : printJsonData(200, getAppointmentById(mysqli_insert_id($conn)));
    case "PATCH":
        $data = json_decode(file_get_contents("php://input"), true);
        if (isset($data['id']) && isset($data['cancel'])) {
            $retVal = cancelAppointment((int) $data['id']);
            return $retVal == -1 ? printJsonData(500, "Error canceling appointment") : printJsonData(200, $retVal);
        }
        if (!isset($data['id']) || !isset($data['customer_id']) || !isset($data['stylist_id']) || !isset($data['status']) || !isset($data['scheduled_date']))
            return printJsonData(400, json_encode("Missing required fields"));

        return updateAppointment((int) $data['id'], (int) $data['customer_id'], (int) $data['stylist_id'], $data['status'], $data['scheduled_date']) == -1 ? printJsonData(500, "Error updating appointment") : printJsonData(200, "Appointment updated successfully");
    case "DELETE":
        if (!isset($_POST['id']))
            return printJsonData(400, "Missing required fields");
        return deleteAppointment($_POST['id']) == -1 ? printJsonData(500, "Error deleting appointment") : printJsonData(200, "Appointment deleted successfully");

    default:
        return printJsonData(405, "Method not allowed");
}