<?php
    include("../../../db_connect.php");

    $user_data = array();
    $bin_data = array();
    $getMarkersQuery = "SELECT * FROM residents WHERE Active = 1";
    if ($result = mysqli_query($conn, $getMarkersQuery)) {
        while($row = mysqli_fetch_assoc($result)){
            array_push($user_data, array($row['LocationCoordinate'], $row['Name'], $row['Address'], $row['NIC']));
            
            // GET BIN INFO
            $genID = $row['NIC'];
            $bin_query = "SELECT * FROM bins WHERE GeneratorID = '$genID'";
            if ($result_data = mysqli_query($conn, $bin_query)){
                while ($row_data = mysqli_fetch_assoc($result_data)) {
                    array_push($bin_data, array($row['NIC'], $row_data['Type'], $row_data['Capacity'], $row_data['NoOfBins']));
                }
            }

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
        ($user_data),
        ($bin_data)
    );

    echo json_encode($data);

?>