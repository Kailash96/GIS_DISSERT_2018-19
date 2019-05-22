<?php
    include("../project/config/db_connect.php");

    $reset_trip = "DELETE FROM tbl_trips";
    $reset_trip_1 = "ALTER TABLE tbl_trips AUTO_INCREMENT 0";
    $reset_schedule = "DELETE FROM tbl_schedule";
    $reset_schedule_1 = "ALTER TABLE tbl_schedule AUTO_INCREMENT 0";
    $reset_route_per_zone = "DELETE FROM tbl_route_per_zone";
    $reset_route_per_zone_1 = "ALTER TABLE tbl_route_per_zone AUTO_INCREMENT 0";
    $reset_carry_forward = "DELETE FROM tbl_carry_forward";
    $reset_carry_forward_1 = "ALTER TABLE tbl_carry_forward AUTO_INCREMENT 0";

    mysqli_query($conn, $reset_trip);
    mysqli_query($conn, $reset_trip_1);
    mysqli_query($conn, $reset_schedule);
    mysqli_query($conn, $reset_schedule_1);
    mysqli_query($conn, $reset_route_per_zone);
    mysqli_query($conn, $reset_route_per_zone_1);
    mysqli_query($conn, $reset_carry_forward);
    mysqli_query($conn, $reset_carry_forward_1);
    
?>