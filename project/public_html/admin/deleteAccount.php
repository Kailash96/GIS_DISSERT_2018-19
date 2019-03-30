<?php
    include("../../config/db_connect.php");

    $userid = $_POST['genID'];
    $deleteQuery = "DELETE FROM tbl_generator WHERE GeneratorID = '$userid'";
    if (mysqli_query($conn, $deleteQuery)) {
        $deleteLoginDetails = "DELETE FROM tbl_generators_login WHERE GeneratorID = '$userid'";
        if (mysqli_query($conn, $deleteLoginDetails)){
            echo json_encode("success");
        } else {
            echo json_encode("Login Details not deleted!");
        }
    } else {
        echo json_encode("failed!");
    }
    
?>