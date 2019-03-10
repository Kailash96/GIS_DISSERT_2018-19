<?php
    include("../../../db_connect.php");

    $nic = $_POST['nic'];
    $fullname = $_POST['fname'];
    $password = SHA1(strtolower(substr($fullname, 0, 3) . substr($nic, -3)));
    
    $act_query = "UPDATE tbl_generator SET Active = 1 WHERE GeneratorID = '$nic'";
    
    if (mysqli_query($conn, $act_query)){
        $setacctQuery = "INSERT INTO tbl_generators_login (GeneratorID, Password) VALUES ('$nic', '$password')";
        mysqli_query($conn, $setacctQuery);
    }

?>