<?php
declare(strict_types=1);
session_start();
include './functions.php';

switch ($_SERVER['REQUEST_METHOD']) {
    case "GET":
        return $_GET['id'] ? printJsonData(200, getUser($_GET['id'])) : printJsonData(200, getAllUsers());

    case "POST":
        if (isset($_POST['loginEmail']) && isset($_POST['password']))
            return loginUser($_POST['loginEmail'], $_POST['password']);
        if (!isset($_POST['name']) || !isset($_POST['email']) || !isset($_POST['password']))
            return printJsonData(400, "Missing required fields");
        return createUser($_POST['name'], $_POST['email'], $_POST['password']);

    case "PATCH":
        if (!isset($_POST['id']) || !isset($_POST['name']) || !isset($_POST['email']) || !isset($_POST['password']))
            return printJsonData(400, "Missing required fields");
        return updateUser($_POST['id'], $_POST['name'], $_POST['email'], $_POST['password']);

    case "DELETE":
        if (!isset($_POST['id']))
            return printJsonData(400, "Missing required fields");
        return deleteUser($_POST['id']);

    default:
        return printJsonData(405, "Method not allowed");
}
?>