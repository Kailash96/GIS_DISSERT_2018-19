<?php
    include("../../../db_connect.php");

    $nic = $_POST['nic'];
    $password = $nic . '%' . rand(1000, 9999);
    $category = $_POST['category'];
    
    if ($category == 'resident') {
        $act_query = "UPDATE residents SET Active = 1 WHERE NIC = '$nic'";
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