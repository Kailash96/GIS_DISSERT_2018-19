<?php
    include("../../../db_connect.php");

    $routes = array();
    $query = "SELECT * FROM tbl_trips";
    if ($results = mysqli_query($conn, $query)) {
        while ($route = mysqli_fetch_assoc($results)) {
            array_push($routes, json_decode($route["Trips"]));
        }
    }

    echo json_encode($routes);
    
?>