<?php
    include("../../../../config/db_connect.php");

    $coords = json_decode($_POST['coords']);

    for ($i = 0; $i < sizeof($coords); $i++) {
        $value = $coords[$i];
        $save_query = "INSERT INTO zone (collectorsID, coordinates) VALUES ('DCOF', '$value')";
        mysqli_query($conn, $save_query);
    }
?>