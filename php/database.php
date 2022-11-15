<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "prison_system";

    $conn = new mysqli($servername, $username, $password, $database);
    
    if($conn->connect_error) {
        die("Database connection failed: ". $conn->connect_error);
    }
    else echo "Connected to DB.";
?>