<?php
declare(strict_types=1);
session_start();
include './functions.php';

switch ($_SERVER['REQUEST_METHOD']) {
    case "GET":
        return $_GET['id'] ? printJsonData(200, getUser($_GET['id'])) : printJsonData(200, getAllUsers());

    case "POST":
        if (isset($_POST['loginEmail']) && isset($_POST['password']))
            if(isset($_POST['admin'])) return loginAdmin($_POST['loginEmail'], $_POST['password']);
            else return loginUser($_POST['loginEmail'], $_POST['password']);
        if (!isset($_POST['name']) || !isset($_POST['email']) || !isset($_POST['password']))
            return printJsonData(400, "Missing required fields");
        return createUser($_POST['name'], $_POST['email'], $_POST['password']);

    case "PATCH":
        $data = json_decode(file_get_contents("php://input"), true);
        if (isset($data['id']) && isset($data['name']) && isset($data['email']))
            return updateUserProfile((int) $data['id'], $data['name'], $data['email']);
        if (isset($data['id']) && isset($data['oldPassword']) && isset($data['newPassword']))
            return updateUserPassword((int) $data['id'], $data['oldPassword'], $data['newPassword']);
        return printJsonData(200, $data);

    case "DELETE":
        $data = json_decode(file_get_contents("php://input"), true);
        if (!isset($data['id']) && !isset($data['password']))
            return printJsonData(400, "Missing required fields");
        return deleteUser((int) $data['id'], $data['password']);

    default:
        return printJsonData(405, "Method not allowed");
}
?>