<?php
include './functions.php';

if ($_SERVER['REQUEST_METHOD']) {
    switch ($_SERVER['REQUEST_METHOD']) {
        case "GET":
            if (isset($_GET['name']))
                return printJsonData(200, getServicesByName($_GET['name']));
            if (isset($_GET['popular']))
                if (isset($_GET['search']) && strlen($_GET['search']))
                    return printJsonData(200, getPopularServicesBySearch($_GET['search']));
                else
                    return printJsonData(200, getPopularServices());
            return printJsonData(200, getAllServices());
        case "POST":
            if (!isset($_POST['name']) || !isset($_POST['price']) || !isset($_POST['duration']) || !isset($_POST['followup_duration']) || !isset($_POST['description']))
                return printJsonData(400, $_POST['duration']);
            return createService($_POST['name'], (float) $_POST['price'], (int) $_POST['duration'], (int) $_POST['followup_duration'], $_POST['description']) == -1 ? printJsonData(500, "Failed to create service") : printJsonData(200, "Service created successfully");
        case "PATCH":
            $data = json_decode(file_get_contents("php://input"), true);
            if (!isset($data['id']) || !isset($data['name']) || !isset($data['price']) || !isset($data['duration']) || !isset($data['followup_duration']) || !isset($data['description']))
                return printJsonData(400, "Missing required fields");
            return updateService((int) $data['id'], $data['name'], (float) $data['price'], (int) $data['duration'], (int) $data['followup_duration'], $data['description']) == -1 ? printJsonData(500, "Failed to update service") : printJsonData(200, "Service updated successfully");
        case "DELETE":
            $data = json_decode(file_get_contents("php://input"), true);
            if (!isset($data['id']))
                return printJsonData(400, "Missing required fields");
            return deleteService((int) $data['id']) == -1 ? printJsonData(500, "Failed to delete service") : printJsonData(200, "Service deleted successfully");

        default:
            return printJsonData(405, "Method not allowed");
    }
}