<?php
declare(strict_types=1);
include '../includes/db_connection.php';
include './functions.php';

switch ($_SERVER['REQUEST_METHOD']) {
    case "GET":
        if (isset($_GET['customer_id']))
            return printJsonData(200, getConsultationByCustomer($_GET['customer_id']));
        return printJsonData(200, getAllAppointments());
    case "POST":
        $retVal = createConsultation((int) $_POST['customer_id'], $_POST['type'], $_POST['texture'], $_POST['hair'], $_POST['perming'], $_POST['relax'], $_POST['rebonding'], $_POST['bleaching']);
        
        return ($retVal == -1 ? printJsonData(500, "Error creating consultation") : $retVal == -2) ? printJsonData(code: 500, data: "You already have an existing consultation data.") : printJsonData(200, "Consultation created successfully");
    case "PATCH":
        if (!isset($_POST['customer_id']) || !isset($_POST['stylist_id']) || !isset($_POST['status']) || !isset($_POST['scheduled_date']))
            return printJsonData(400, "Missing required fields");
        return updateAppointment($_POST['id'], $_POST['customer_id'], $_POST['stylist_id'], $_POST['status'], $_POST['scheduled_date']) == -1 ? printJsonData(500, "Error updating appointment") : printJsonData(200, "Appointment updated successfully");
    case "DELETE":
        $data = json_decode(file_get_contents("php://input"), true);
        if (!isset($data['id']))
            return printJsonData(400, "Missing required fields");
        return deleteConsultation((int) $data['id']) == -1 ? printJsonData(500, "Error deleting consultation") : printJsonData(200, "Consultation deleted successfully");

    default:
        return printJsonData(405, "Method not allowed");
}