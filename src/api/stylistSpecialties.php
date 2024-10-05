<?php
declare(strict_types=1);
include '../includes/db_connection.php';
include './functions.php';

switch ($_SERVER['REQUEST_METHOD']) {
    case "GET":
        if ($_GET['id'])
            return printJsonData(200, getStylistSpecialtiesById($_GET['id']));
        if ($_GET['stylist_id'])
            return printJsonData(200, getStylistSpecialtiesByStylistId($_GET['stylist_id']));
        if ($_GET['service_id'])
            return printJsonData(200, getStylistSpecialtiesByServiceId($_GET['service_id']));
        return printJsonData(200, getAllStylistSpecialties());
    case "POST":
        if (!isset($_POST['stylist_id']) || !isset($_POST['service_id']))
            return printJsonData(400, "Missing required fields");
        return createStylistSpecialty($_POST['stylist_id'], $_POST['service_id']) == -1 ? printJsonData(500, "Failed to create stylist specialty") : printJsonData(200, "Stylist specialty created successfully");
    case "PATCH":
        if (!isset($_POST['id']) || !isset($_POST['stylist_id']) || !isset($_POST['service_id']))
            return printJsonData(400, "Missing required fields");
        return updateStylistSpecialty($_POST['id'], $_POST['stylist_id'], $_POST['service_id']) == -1 ? printJsonData(500, "Failed to update stylist specialty") : printJsonData(200, "Stylist specialty updated successfully");
    case "DELETE":
        if (!isset($_POST['id']))
            return printJsonData(400, "Missing required fields");
        return deleteStylistSpecialty($_POST['id']) == -1 ? printJsonData(500, "Failed to delete stylist specialty") : printJsonData(200, "Stylist specialty deleted successfully");
    default:
        return printJsonData(405, "Method not allowed");
}