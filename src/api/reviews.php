<?php
declare(strict_types=1);
include '../includes/db_connection.php';
include './functions.php';

switch ($_SERVER['REQUEST_METHOD']) {
    case "GET":
        if ($_GET['id'])
            return printJsonData(200, getReviewById($_GET['id']));
        if ($_GET['customer_id'])
            return printJsonData(200, getReviewsByCustomerId($_GET['customer_id']));
        if ($_GET['appointment_id'])
            return printJsonData(200, getReviewsByAppointmentId($_GET['appointment_id']));
        if ($_GET['review'])
            return printJsonData(200, getReviewsByReview($_GET['review']));
        return printJsonData(200, getAllReviews());
    case "POST":
        if (!isset($_POST['customer_id']) || !isset($_POST['appointment_id']) || !isset($_POST['rating']) || !isset($_POST['review']))
            return printJsonData(400, "Missing required fields");
        return createReview($_POST['customer_id'], $_POST['appointment_id'], $_POST['rating'], $_POST['review']) == -1 ? printJsonData(500, "Failed to create review") : printJsonData(200, "Review created successfully");
    case "PATCH":
        if (!isset($_POST['id']) || !isset($_POST['customer_id']) || !isset($_POST['appointment_id']) || !isset($_POST['rating']) || !isset($_POST['review']))
            return printJsonData(400, "Missing required fields");
        return updateReview($_POST['id'], $_POST['customer_id'], $_POST['appointment_id'], $_POST['rating'], $_POST['review']) == -1 ? printJsonData(500, "Failed to update review") : printJsonData(200, "Review updated successfully");
    case "DELETE":
        if (!isset($_POST['id']))
            return printJsonData(400, "Missing required fields");
        return deleteReview($_POST['id']) == -1 ? printJsonData(500, "Failed to delete review") : printJsonData(200, "Review deleted successfully");

    default:
        return printJsonData(405, "Method not allowed");
}