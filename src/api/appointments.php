<?php
declare(strict_types=1);
include '../includes/db_connection.php';
include './functions.php';

switch ($_SERVER['REQUEST_METHOD']) {
    case "GET":
        if ($_GET['scheduled_date'])
            return printJsonData(200, getAppointmentsByScheduledDate($_GET['scheduled_date']));
        if ($_GET['customer_id'])
            return printJsonData(200, getAppointmentsByCustomer($_GET['customer_id']));
        if ($_GET['stylist_id'])
            return printJsonData(200, getAppointmentsByStylist($_GET['stylist_id']));
        if ($_GET['status'])
            return printJsonData(200, getAppointmentsByStatus($_GET['status']));
        if ($_GET['id'])
            return printJsonData(200, getAppointmentById($_GET['id']));
        return printJsonData(200, getAllAppointments());
    case "POST":
        if (!isset($_POST['customer_id']) || !isset($_POST['stylist_id']) || !isset($_POST['status']) || !isset($_POST['scheduled_date']))
            return printJsonData(400, "Missing required fields");
        return createAppointment($_POST['customer_id'], $_POST['stylist_id'], $_POST['status'], $_POST['scheduled_date']) == -1 ? printJsonData(500, "Error creating appointment") : printJsonData(200, "Appointment created successfully");
    case "PATCH":
        if (!isset($_POST['customer_id']) || !isset($_POST['stylist_id']) || !isset($_POST['status']) || !isset($_POST['scheduled_date']))
            return printJsonData(400, "Missing required fields");
        return updateAppointment($_POST['id'], $_POST['customer_id'], $_POST['stylist_id'], $_POST['status'], $_POST['scheduled_date']) == -1 ? printJsonData(500, "Error updating appointment") : printJsonData(200, "Appointment updated successfully");
    case "DELETE":
        if (!isset($_POST['id']))
            return printJsonData(400, "Missing required fields");
        return deleteAppointment($_POST['id']) == -1 ? printJsonData(500, "Error deleting appointment") : printJsonData(200, "Appointment deleted successfully");

    default:
        return printJsonData(405, "Method not allowed");
}