<?php
    include("../../../../../config/db_connect.php");

    $userid = $_POST['userid'];
    $wasteAmount = $_POST['wasteamount'];
    $collect_date = $_POST['collect'];
    $today = date("Y-m-d");

    $saveRequest = "
            INSERT INTO
                tbl_collection_request (RequestDate, UserID, CollectionDate, WasteAmount)
            VALUES
                ('$today', '$userid', '$collect_date', $wasteAmount)
        ";

    if (mysqli_query($conn, $saveRequest)){
        echo json_encode(1);
    } else {
        echo json_encode(0);
    }
    
?>