<?php
    include("../../config/db_connect.php");

    $userid = $_POST['user_id'];
    $bin_type = $_POST['bin_type'];
    $bin_capacity = $_POST['bin_capacity'];
    $nOfBin = $_POST['nOfBin'];
    $act = $_POST['act'];

    if ($act == 1) {
        $checkExist = "SELECT * FROM bins WHERE GeneratorID = '$userid' AND Type = '$bin_type' AND Capacity = '$bin_capacity'";
        if (mysqli_num_rows(mysqli_query($conn, $checkExist)) > 0) {
            $query = "UPDATE bins SET NoOfBins = NoOfBins + $nOfBin WHERE GeneratorID = '$userid' AND Type = '$bin_type' AND Capacity = '$bin_capacity'";
        } else {
            $query = "INSERT INTO bins (Type, GeneratorID, Capacity, NoOfBins) VALUES ('$bin_type', '$userid', '$bin_capacity', $nOfBin)";
        }
    } else if ($act == 0){
        $checkExist = "SELECT * FROM bins WHERE GeneratorID = '$userid' AND Type = '$bin_type' AND Capacity = '$bin_capacity'";
        if (mysqli_num_rows(mysqli_query($conn, $checkExist)) > 1) {
            $query = "UPDATE bins SET NoOfBins = NoOfBins - 1 WHERE GeneratorID = '$userid' AND Type = '$bin_type' AND Capacity = '$bin_capacity'";
        } else {
            $query = "DELETE FROM bins WHERE GeneratorID = '$userid' AND Type = '$bin_type' AND Capacity = '$bin_capacity'";
        }
    }

    mysqli_query($conn, $query);
?>