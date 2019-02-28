<?php
    include("../../../db_connect.php");

    $nic = $_POST['nic'];

    $success = false;
    $rejectQuery = "DELETE FROM tbl_residents WHERE NIC = '$nic'";
    if (mysqli_query($conn, $rejectQuery)) {
        $success = true;
    }

    echo json_encode($success);

?>