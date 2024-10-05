<?php
declare(strict_types=1);
include '../includes/db_connection.php';
include './functions.php';

switch ($_SERVER['REQUEST_METHOD']) {
    case "GET":
        if ($_GET['appointment_id'])
            return printJsonData(200, getAppointmentServicesByAppointmentId($_GET['appointment_id']));
        if ($_GET['service_id'])
            return printJsonData(200, getAppointmentServicesByServiceId($_GET['service_id']));
        if ($_GET['id'])
            return printJsonData(200, getAppointmentServiceById($_GET['id']));
        return printJsondata(200, getAllAppointmentServices());
    case "POST":
        if (!isset($_POST['appointment_id']) || !isset($_POST['service_id']))
            return print_r(json_encode(["code" => 400, "data" => "Missing required fields"]));
        return createAppointmentService($_POST['appointment_id'], $_POST['service_id']);
    case "PATCH":
        if (!isset($_POST['id']) || !isset($_POST['appointment_id']) || !isset($_POST['service_id']))
            return printJsonData(400, "Missing required fields");
        return updateAppointmentService($_POST['id'], $_POST['appointment_id'], $_POST['service_id']) == -1 ? printJsonData(400, "Failed to update appointment service") : printJsonData(200, "Appointment service updated successfully");
    case "DELETE":
        if (!isset($_POST['id']))
            return printJsonData(400, "Missing required fields");
        return deleteAppointmentService($_POST['id']) == -1 ? printJsonData(400, "Failed to delete appointment service") : printJsonData(200, "Appointment service deleted successfully");
    default:
        return printJsonData(405, "Method not allowed");
}