<?php

    include("../../../../config/db_connect.php");

    $slotID = $_POST['slotID'];
    $data = explode("_", $slotID);
    $zone = $data[0];
    $day = $data[1];
    $truckID = $data[2];

    $slot_data = array();

    $getData = "SELECT * FROM tbl_schedule WHERE TruckID = '$truckID' AND Day = '$day' AND Zone = $zone";
    if ($data_result = mysqli_query($conn, $getData)) {
        $data_rw = mysqli_fetch_assoc($data_result);
    }

    $scheduleID = $data_rw['ScheduleID'];
    $numberOfTrips = "SELECT * FROM tbl_route WHERE scheduleID = $scheduleID";
    $number = mysqli_num_rows(mysqli_query($conn, $numberOfTrips));

    array_push($slot_data, $truckID, $data_rw['TotalWastes'], $data_rw['NumberOfHouses'], $number);

    echo json_encode($slot_data);

?>