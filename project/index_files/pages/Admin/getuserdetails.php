<?php

    include("../../../db_connect.php");
    $userID = $_POST['id'];
    $category = $_POST['category'];

    /*
    if ($category = 'resident'){
        $getdetailsquery = "SELECT * FROM residents WHERE NIC = $userID";
    }

    $data = array();
    if ($results = mysqli_query($conn, $getdetailsquery)){
        $row = mysqli_fetch_assoc($results);
        $data[0] = $row['NIC'];
        $data[1] = $row['Name'];
        $data[2] = $row['Tan'];
        $data[3] = $row['Address'];
        $data[4] = $row['PhoneNumber'];
        echo json_encocde($data);
    }
    */

?>