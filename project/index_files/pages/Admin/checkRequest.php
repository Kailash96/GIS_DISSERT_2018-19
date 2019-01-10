<?php
    include("../../../db_connect.php");

    $value_check = $_POST["checker"];
    $checkQuery = "SELECT * FROM residents WHERE Active = 0";

    if ($result = mysqli_query($conn, $checkQuery)){
        $checkCount = mysqli_num_rows($result);
        echo $checkCount;
    } else {
        echo 'err';
    }
?>