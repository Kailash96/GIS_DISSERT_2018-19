<?php
    include("../../../db_connect.php");

    $coords = json_decode($_POST['coords']);
    $collectorsID = $_POST['collectors_id'];
    $region_name = $_POST['region_name'];


    for ($j = 0; $j < sizeof($coords); $j++) {
        $value = $coords[$j];
        $save_query = "INSERT INTO tbl_region (coordinates, regionName, CollectorsID) VALUES ('$value', '$region_name', '$collectorsID')";
        mysqli_query($conn, $save_query);
    }

?>