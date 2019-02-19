<?php

    include("../../../db_connect.php");
    $userID = $_POST['id'];
    $category = $_POST['category'];

    
    if ($category == 'resident'){
        $getdetailsquery = "SELECT * FROM tbl_residents WHERE NIC = '$userID' LIMIT 1";
    } else if ($category == 'commercial') {
        $getdetailsquery = "SELECT * FROM commercial WHERE RegNo = '$userID' LIMIT 1";
    } else if ($category == 'industrial') {
        $getdetailsquery = "SELECT * FROM industrial WHERE RegNo = '$userID' LIMIT 1";
    }

    $data = array();
    if ($results = mysqli_query($conn, $getdetailsquery)){
        $row = mysqli_fetch_assoc($results);

        if ($category == 'resident'){
            $data[0] = $row['NIC'];
            $data[1] = $row['Name'];
            $data[2] = $row['Tan'];
            $data[3] = $row['Address'];
            $data[4] = $row['PhoneNumber'];
            $data[5] = $row['LocationCoordinate'];
            $data[6] = $row['Email'];
            $data[7] = $row['country'];
            $data[8] = $row['region'];
        } else {
            $data[0] = $row['RegNo'];
            $data[1] = $row['Name'];
            $data[2] = $row['Tan'];
            $data[3] = $row['Address'];
            $data[4] = $row['PhoneNumber'];
            $data[5] = $row['Email'];
            $data[6] = $row['LocationCoordinate'];
        }
        
        echo json_encode($data);

    }

?>