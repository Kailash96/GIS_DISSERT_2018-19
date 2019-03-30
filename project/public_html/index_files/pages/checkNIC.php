<?php
    include("../../../config/db_connect.php");

    $nic = $_POST['nic'];
    $exist = false;
    $check = "SELECT * FROM tbl_generator WHERE GeneratorID = '$nic'";

    if (mysqli_num_rows(mysqli_query($conn, $check)) > 0) {
        $exist = true;
    }

    echo json_encode($exist);

?>