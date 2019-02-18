<?php
    include("../../../db_connect.php");

    $array_of_zones = json_decode($_POST['zone_array']);

    /*
    function inside($point, $vs) {

        $x = $point[0];
        $y = $point[1];
    
        $inside = false;
        for ($i = 0, $j = sizeof($vs) - 1; $i < sizeof($vs); $j = $i++) {
            $xi = $vs[$i][0];
            $yi = $vs[$i][1];
            $xj = $vs[$j][0];
            $yj = $vs[$j][1];
            
            $intersect = (($yi > $y) != ($yj > $y))
            && ($x < ($xj - $xi) * ($y - $yi) / ($yj - $yi) + $xi);
            if ($intersect) $inside = !$inside;
        }
    
        return $inside;
    };
    */

    /*
    function checkInRegion($individualZone) {
        $flag = false;

        $region_query = "SELECT * FROM tbl_region";
        
        if ($my_result = mysqli_query($GLOBALS['conn'], $region_query)) {
 
            
            while ($row = mysqli_fetch_assoc($my_result)) {

                
                for ($a = 0; $a < sizeof($individualZone); $a++) {
                    $flag = inside($individual[$a], $row['coordinates']);
                }
            
            }

        }


        echo json_encode();
        
    }
    
    for ($j = 0; $j < sizeof($array_of_zones); $j++) {
        $zone = $array_of_zones[$j];

        checkInRegion($zone);
        // if true then return regionID and store in database with $zone
        //$save_query = "INSERT INTO tbl_zones (coordinates, regionID) VALUES ('$value', '$regionID')";
        //mysqli_query($conn, $save_query);

    }
    */

    /*
    function myTest(){
        $region_query = "SELECT * FROM tbl_region";
        $test = "hello world";
        if ($my_result = mysqli_query($conn, $region_query)) {
            
            
            while ($row = mysqli_fetch_assoc($my_result)) {
                $test = $row['coordinates'];
            }
            
        }
        return $test;
    }
    */

    echo json_encode($array_of_zones[0]);

?>