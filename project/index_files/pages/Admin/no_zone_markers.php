<?php
    include("../../../db_connect.php");

    $region = $_POST['region'];

    $coordinates = array();
    $getnozoneQuery = "SELECT * FROM tbl_generator WHERE zoneID = 0 AND Active = 1 AND region = '$region'";
    if ($result = mysqli_query($conn, $getnozoneQuery)) {
        while ($row = mysqli_fetch_assoc($result)) {
            array_push($coordinates, $row['LocationCoordinate']);
        }
    }

    echo json_encode($coordinates);
?>