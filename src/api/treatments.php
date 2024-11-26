<?php
include './functions.php';

if ($_SERVER['REQUEST_METHOD']) {
    switch ($_SERVER['REQUEST_METHOD']) {
        case "GET":
            if (isset($_GET['search']) && strlen($_GET['search']))
                return printJsonData(200, getAllTreatmentBySearch($_GET['search']));
            return printJsonData(200, getAllTreatments());
        case "POST":

            if ((!isset($_POST['service_id']) || !isset($_POST['alternative_id']) || !isset($_POST['reason']) || $_POST['reason'] == ""))
                return printJsonData(400, "Missing required fields");


            if ($_POST['service_id'] == $_POST['alternative_id'])
                return printJsonData(400, "Treatment and alternative cannot be the same");

            $newTreatment = createTreatment((int) $_POST['service_id'], isset($_POST['min_time']) ? $_POST['min_time'] : [], (int) $_POST['alternative_id'], $_POST['reason']);
            return printJsonData(500, $newTreatment);
        case "DELETE":
            $data = json_decode(file_get_contents("php://input"), true);
            if (!isset($data['id']))
                return printJsonData(400, "Missing required fields");

            return deleteTreatment((int) $data['id']) == -1 ? printJsonData(500, "Failed to delete treatment") : printJsonData(200, "Treatment deleted successfully");

        default:
            return printJsonData(405, "Method not allowed");
    }
}