<?php

function db_conn(): bool|mysqli      
{
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "salon_db";
    $conn = mysqli_connect($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die(`Connection failed: {$conn->connect_error}`);
    }

    // Store the connection in $GLOBALS for later use
    $GLOBALS['db_connection'] = $conn;

    return $conn;
}

db_conn();

?>