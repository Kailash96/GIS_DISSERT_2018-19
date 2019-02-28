<?php
    include("../../../db_connect.php");

    $day = $_POST['day'];
    $zone = $_POST['zone'];
    $route = $_POST['route'];
    $truck = $_POST['truck'];
    $duration = $_POST['duration'];

    $success = false;

    $save_query = "INSERT INTO tbl_schedule (Day, truckID, routeID, zoneID, Duration)
        values ('$day', '$truck', $route, $zone, $duration)";

    if (mysqli_query($conn, $save_query)) {
        $success = true;
    }

    echo json_encode($success);

?>