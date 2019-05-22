<?php
    include("../../config/db_connect.php");

    $username = $_POST['username'];
    $address = $_POST['address'];
    $telephone = $_POST['telephone'];
    $region = $_POST['region'];
    $category = $_POST['category'];
    $location = "null";

    $register = "
        INSERT INTO
            tbl_collectors (Name, Address, Telephone, LocationCoordinate, RegionName, Category)
        VALUES ('$username', '$address',$telephone, '$location', '$region', '$category')
    ";
    if (mysqli_query($conn, $register)) {
        echo json_encode("Success!");
    } else {
        echo json_encode("Failed!");
    }
?>