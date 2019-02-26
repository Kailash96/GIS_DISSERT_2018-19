<?php
    include("../../../db_connect.php");

    $day = $_POST['day'];
    $zone = $_POST['zone'];
    $shift = $_POST['shift'];
    $route = $_POST['route'];
    $truck = $_POST['truck'];

    $success = false;

    if ($shift == 'A') {
        $save_query = "INSERT INTO tbl_schedule (Day, truckID, routeID, zoneID, Shift_A)
        values ('$day', '$truck', $route, $zone, 1)";
    } else if ($shift == 'B') {
        $save_query = "INSERT INTO tbl_schedule (Day, truckID, routeID, zoneID, Shift_B)
        values ('$day', '$truck', $route, $zone, 1)";
    } else if ($shift == 'C') {
        $save_query = "INSERT INTO tbl_schedule (Day, truckID, routeID, zoneID, Shift_C)
        values ('$day', '$truck', $route, $zone, 1)";
    } else {
        $save_query = "INSERT INTO tbl_schedule (Day, truckID, routeID, zoneID, Shift_D)
        values ('$day', '$truck', $route, $zone, 1)";
    }

    if (mysqli_query($conn, $save_query)) {
        $success = true;
    }

    echo json_encode($success);

?>