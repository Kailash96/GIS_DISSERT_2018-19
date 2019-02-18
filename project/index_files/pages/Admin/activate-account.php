<?php
    include("../../../db_connect.php");

    $nic = $_POST['nic'];
    $fullname = $_POST['fname'];
    $password = SHA1(substr($fullname, 0, 3) . substr($nic, -3));
    $category = $_POST['category'];
    
    if ($category == 'resident') {
        $act_query = "UPDATE tbl_residents SET Active = 1 WHERE NIC = '$nic'";
    } else if ($category == 'commercial') {
        // UPDATE COMMERCIAL
    } else if ($category == 'industrial') {
        // UPDATE INDUSTRIAL
    }
    
    if (mysqli_query($conn, $act_query)){
        $setacctQuery = "INSERT INTO generatorslogin (GeneratorID, Password, Category) VALUES ('$nic', '$password', '$category')";
        mysqli_query($conn, $setacctQuery);
    }

?>