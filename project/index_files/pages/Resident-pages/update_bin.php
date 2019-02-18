<?php
    include("../../../db_connect.php");

    $userID = $_POST['userID'];
    $act = $_POST['act'];

    $data = array("false");

    if ($act == 0) {
        $update_query = "SELECT * FROM tbl_waste_gen WHERE generatorID = '$userID' ORDER BY wgID DESC LIMIT 1";
        if ($results = mysqli_query($conn, $update_query)) {
            $row = mysqli_fetch_assoc($results);
            array_push($data, $row['Domestic']);
            array_push($data, $row['Plastic']);
            array_push($data, $row['Paper']);
            array_push($data, $row['Other']);
            array_push($data, $row['getDate']);
        }
    } else {
        // $domestic_level
        $domestic_level = $_POST['domestic_level'];
        // $plastic_level
        $plastic_level = $_POST['plastic_level'];
        // $paper_level
        $paper_level = $_POST['paper_level'];
        // $other_level
        $other_level = $_POST['other_level'];

        $current_date = date("y-m-d");
        $timestamp = strtotime(date("h:i:s")) + (60 * 60 * 4);
        $current_time = date("h:i:s", $timestamp);

        $update_query = "
            INSERT INTO tbl_waste_gen (Domestic, Plastic, Paper, Other, getDate, getTime, generatorID)
            VALUES ($domestic_level, $plastic_level, $paper_level, $other_level, '$current_date', '$current_time', '$userID')
        ";

        if (mysqli_query($conn, $update_query)) {
            $data[0] = "true";
        }
    }

    echo json_encode($data);

?>