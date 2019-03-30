<?php
    include("../../config/db_connect.php");

    $counter = 0;
    $countQuery = "SELECT * FROM tbl_residents WHERE zoneID = 0";
    if ($reslt = mysqli_query($conn, $countQuery)) {
        $counter = mysqli_num_rows($reslt);
    }

    echo json_encode($counter);

?>