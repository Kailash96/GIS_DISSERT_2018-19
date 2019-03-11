<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "testing";

    $conn = mysqli_connect($servername, $username, $password, $dbname);

    // Check connection
    if (mysqli_connect_errno($conn)){
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }

    
    $query = "INSERT INTO timecheck2 (thetime) values (now())";

    $count = 0;
    while ($count < 10) {
        mysqli_query($conn, $query);
        $count++;
        sleep(20);
    }

?>