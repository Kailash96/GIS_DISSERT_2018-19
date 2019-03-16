<?php
    include("../../../db_connect.php");
    include("phpfunctions.php");

    function checkInRegion($individualZone) {
        $flag = false;
        $region_query = "SELECT * FROM tbl_region";
        
        if ($my_result = mysqli_query($GLOBALS['conn'], $region_query)) {
            while ($row = mysqli_fetch_assoc($my_result)) {

                for ($a = 0; $a < sizeof($individualZone); $a++) {
                    $flag = pointinpolygon($individualZone[$a], json_decode($row['coordinates']));
                    if (!$flag){
                        break;
                    }
                }
                if ($flag) {
                    return $row['regionID'];
                    break;
                }
            }
            return 0;
        }
        
    }

    function draw_zone(){
        $zones = array();
        // SETS THE ZONES
        $getZonesCoords_query = "SELECT coordinates FROM tbl_zones";
        if ($results = mysqli_query($GLOBALS['conn'], $getZonesCoords_query)) {
            while ($row = mysqli_fetch_assoc($results)) {
                $coords = $row['coordinates'];
                array_push($zones, $coords);
            }
        }

        echo json_encode($zones);
    }
    
    $act = $_POST['act'];
    if ($act == 1) {
        $array_of_zones = json_decode($_POST['zone_array']);
        for ($j = 0; $j < sizeof($array_of_zones); $j++) {
            $zone = $array_of_zones[$j];
            $zone_coords = json_encode($zone);
    
            $region_id = checkInRegion($zone);
            if ($region_id != 0) {
                $save_query = "INSERT INTO tbl_zones (coordinates, regionID) VALUES ('$zone_coords', $region_id)";
                if (mysqli_query($conn, $save_query)){
                    draw_zone();
                };
            } else {
                echo json_encode("not in region");
            }
        }
    } else if ($act == 0) {

        draw_zone();

    }

?>