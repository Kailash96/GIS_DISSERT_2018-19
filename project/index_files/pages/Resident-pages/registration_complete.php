<?php
    // database connection
    include("../../../db_connect.php");

    $nic = $_POST["nic"];
    $fullname = $_POST["fullname"];
    $tan = $_POST["tan"];
    $phone = $_POST["phone"];
    $email = $_POST["email"];
    $address = $_POST["address"];
    $locationCoordinate = $_POST["locationCoordinate"];

    $add_data = "INSERT INTO residents (NIC, Name, TAN, Address, PhoneNumber, LocationCoordinate, Email)
                VALUES ('$nic', '$fullname', '$tan', '$address', $phone, '$locationCoordinate', '$email')";

    if (mysqli_query($conn, $add_data)){
        echo "Data submitted successfully. Admin will verify your data.";
    } else {
        echo "failed";
    }

    
?>