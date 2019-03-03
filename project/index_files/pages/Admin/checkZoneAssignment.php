<?php
    include("../../../db_connect.php");

    function zoneCheck($point, $vs) {

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

    $flag = true;
    $fetch_no_zone_query = "SELECT * FROM tbl_residents";
    if ($result = mysqli_query($conn, $fetch_no_zone_query)) {
        while ($nozoner = mysqli_fetch_assoc($result)) {
            
            $userNIC = $nozoner['NIC'];
            $zone_loop_query = "SELECT * FROM tbl_zones";
            if (mysqli_num_rows($zonify = mysqli_query($conn, $zone_loop_query)) > 0) {
                while ($zone = mysqli_fetch_assoc($zonify)) {

                    $in_zone_ID = $zone['zoneID'];
                    $format = "[" . $nozoner['LocationCoordinate'] . "]";

                    if (zoneCheck(json_decode($format), json_decode($zone['coordinates']))) {
                        
                        $updateQuery = "UPDATE tbl_residents SET zoneID = $in_zone_ID WHERE NIC = '$userNIC'";
                        if (mysqli_query($conn, $updateQuery)){
                            $flag = true;
                            break;
                        };

                    } else {
                        // using flag to prevent repeated table update for more efficient processing power
                        $flag = false;
                    }

                }
            } else {
                $flag = false;
            }

            if (!$flag) {
                $updateQuery = "UPDATE tbl_residents SET zoneID = 0 WHERE NIC = '$userNIC'";
                mysqli_query($conn, $updateQuery);
            }

        }
    }
?>