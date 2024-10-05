<?php
include 'src/api/functions.php';

if ($_SERVER['REQUEST_METHOD']) {
    switch ($_SERVER['REQUEST_METHOD']) {
        case "GET":
            if ($_GET['name'])
                return printJsonData(200, getServicesByName($_GET['name']));
            return printJsonData(200, getAllServices());
        case "POST":
            if (!isset($_POST['name']) || !isset($_POST['price']) || !isset($_POST['duration']) || !isset($_POST['followup_duration']))
                return printJsonData(400, "Missing required fields");
            return createService($_POST['name'], $_POST['price'], $_POST['duration'], $_POST['followup_duration']) == -1 ? printJsonData(500, "Failed to create service") : printJsonData(200, "Service created successfully");
        case "PATCH":
            if (!isset($_POST['id']) || !isset($_POST['name']) || !isset($_POST['price']) || !isset($_POST['duration']) || !isset($_POST['followup_duration']))
                return printJsonData(400, "Missing required fields");
            return updateService($_POST['id'], $_POST['name'], $_POST['price'], $_POST['duration'], $_POST['followup_duration']) == -1 ? printJsonData(500, "Failed to update service") : printJsonData(200, "Service updated successfully");
        case "DELETE":
            if (!isset($_POST['id']))
                return printJsonData(400, "Missing required fields");
            return deleteService($_POST['id']) == -1 ? printJsonData(500, "Failed to delete service") : printJsonData(200, "Service deleted successfully");

        default:
            return printJsonData(405, "Method not allowed");
    }
}