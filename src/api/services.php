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
            if (!isset($_POST['description']))
                return printJsonData(400, "Missing required fields");
            $name = $_POST['name'] ?? 'N/A';
            $price = $_POST['price'] ?? 0;
            $duration = $_POST['duration'] ?? 0;
            $followup_duration = $_POST['followup_duration'] ?? 0;
            $chemical = isset($_POST['chemical']) ? 1 : 0;
            if(isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                return createServiceWithPicture($name, (float) $price, (int) $duration, (int) $followup_duration, $_POST['description'], $_FILES['image'], (int) $chemical) == -1 ? printJsonData(500, "Failed to create service") : printJsonData(200, "Service created successfully");
            }
            return createService($name, (float) $price, (int) $duration, (int) $followup_duration, $_POST['description'], (int) $chemical) == -1 ? printJsonData(500, "Failed to create service") : printJsonData(200, "Service created successfully");
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