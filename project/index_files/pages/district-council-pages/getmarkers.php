<?php
    include("../../../db_connect.php");

    $coords = array();
    $getMarkersQuery = "SELECT LocationCoordinate FROM residents WHERE Active = 1";
    if ($result = mysqli_query($conn, $getMarkersQuery)) {
        while($row = mysqli_fetch_assoc($result)){
            array_push($coords, $row['LocationCoordinate']);
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
        ($coords),
        ($zone_coords)
    );

    echo json_encode($data);

?>