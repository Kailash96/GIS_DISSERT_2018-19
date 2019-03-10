<?php

    include("../../../db_connect.php");
    $userID = $_POST['GenID'];

    $getdetailsquery = "SELECT * FROM tbl_generator WHERE GeneratorID = '$userID' LIMIT 1";

    $data = array();
    if ($results = mysqli_query($conn, $getdetailsquery)){
        $row = mysqli_fetch_assoc($results);
        
        $data[0] = $row['GeneratorID'];
        $data[1] = $row['Name'];
        $data[2] = $row['Address'];
        $data[3] = $row['PhoneNumber'];
        $data[4] = $row['LocationCoordinate'];
        $data[5] = $row['Email'];
        $data[6] = $row['country'];
        $data[7] = $row['region'];
        
        echo json_encode($data);

    }

?>