<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "wastemanagement";

    $conn = mysqli_connect($servername, $username, $password, $dbname);

    // Check connection
    if (mysqli_connect_errno($conn)){
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }

?>