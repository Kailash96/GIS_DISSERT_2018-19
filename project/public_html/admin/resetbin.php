<?php
    include("../../config/db_connect.php");

    $userid = $_POST['userid'];
    $type = $_POST['type'];


    $getPreviousQuery = "SELECT * FROM tbl_waste_gen WHERE generatorID = '$userid' ORDER BY wgID DESC LIMIT 1";
    if ($results = mysqli_query($conn, $getPreviousQuery)) {
        $previous = mysqli_fetch_assoc($results);
        $organic = $previous['Organic'];
        $plastic = $previous['Plastic'];
        $paper = $previous['Paper'];
        $other = $previous['Other'];
        if ($type == 'Organic') {
            $organic = 0;
        } else if ($type == 'Plastic') {
            $plastic = 0;
        } else if ($type == 'Paper') {
            $paper = 0;
        } else if ($type == 'Other') {
            $other = 0;
        }
        $today = date("Y-m-d");
        $todaytime = date("H:i:s");
        $resetQuery = "INSERT INTO tbl_waste_gen (Organic, Plastic, Paper, Other, getDate, getTime, generatorID)
            VALUES ($organic, $plastic, $paper, $other, '$today', '$todaytime', '$userid')
        ";
        if (mysqli_query($conn, $resetQuery)) {
            echo json_encode("success");
        } else {
            echo json_encode("failed");
        }
    } else {
        echo json_encode("query not good");
    }

?>