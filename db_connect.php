<?php
    
    $servername = "localhost";
    $username = "u158955825_arun";
    $password = "4Z6LA0G7KjgN";
    $dbname = "u158955825_gis";

    $conn = mysqli_connect($servername, $username, $password, $dbname);

    // Check connection
    if (mysqli_connect_errno($conn)){
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }

?>