<?php
    include("../../../db_connect.php");

    $user_data = array();
    $getMarkersQuery = "SELECT * FROM residents WHERE Active = 1";
    if ($result = mysqli_query($conn, $getMarkersQuery)) {
        while($row = mysqli_fetch_assoc($result)){
            array_push($user_data, array($row['LocationCoordinate'], $row['Name'], $row['Address']));
        }
    }

    $zone_coords = array();
    $getPolygonCoords_query = "SELECT coordinates FROM zone WHERE collectorsID = 'DCOF'";
    if ($results = mysqli_query($conn, $getPolygonCoords_query)) {
        while ($row = mysqli_fetch_assoc($results)) {
            array_push($zone_coords, $row['coordinates']);
        }
    }
    
    $data = array(
        ($zone_coords),
        ($user_data)
    );

    echo json_encode($data);

?>