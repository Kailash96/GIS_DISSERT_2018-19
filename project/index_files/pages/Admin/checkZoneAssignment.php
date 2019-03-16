<?php
    include("../../../db_connect.php");
    include("phpfunctions.php");

    $flag = true;
    $fetch_no_zone_query = "SELECT * FROM tbl_generator";
    if ($result = mysqli_query($conn, $fetch_no_zone_query)) {
        while ($nozoner = mysqli_fetch_assoc($result)) {
            
            $userNIC = $nozoner['GeneratorID'];
            $zone_loop_query = "SELECT * FROM tbl_zones";
            if (mysqli_num_rows($zonify = mysqli_query($conn, $zone_loop_query)) > 0) {
                while ($zone = mysqli_fetch_assoc($zonify)) {

                    $in_zone_ID = $zone['zoneID'];
                    $format = "[" . $nozoner['LocationCoordinate'] . "]";

                    if (pointinpolygon(json_decode($format), json_decode($zone['coordinates']))) {
                        
                        $updateQuery = "UPDATE tbl_generator SET zoneID = $in_zone_ID WHERE GeneratorID = '$userNIC'";
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
                $updateQuery = "UPDATE tbl_generator SET zoneID = 0 WHERE GeneratorID = '$userNIC'";
                mysqli_query($conn, $updateQuery);
            }

        }
    }
?>