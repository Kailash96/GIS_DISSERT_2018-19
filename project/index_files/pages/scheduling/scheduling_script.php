<?php
    include("../../../db_connect.php");
    include("functions.php");
    // ignore_user_abort(true);
    // set_time_limit(0);    
    $act = $_POST['act'];

    if ($act == "getRoute"){

        $tbl_route_array = array();
        $category_array = array("Resident", "Commercial", "Industrial");
        $waste_type_array = array("Domestic", "Plastic", "Paper", "Other");

        $region_query = "SELECT * FROM tbl_region";
        if ($regioning = mysqli_query($conn, $region_query)) {
            while ($region_rw = mysqli_fetch_assoc($regioning)) {

                $region_ID = $region_rw['regionID'];
                $zone_query = "SELECT * FROM tbl_zones WHERE regionID = $region_ID";
                if ($zoning = mysqli_query($conn, $zone_query)) {
                    while ($zone_rw = mysqli_fetch_assoc($zoning)) {
                        
                        for ($i = 0; $i < sizeof($category_array); $i++) {

                            for ($j = 0; $j < sizeof($waste_type_array); $j++) {

                                array_push(
                                    $tbl_route_array,
                                    array(
                                        // getRoute($region_rw['regionName'], $zone_rw['zoneID'], $category_array[$i], $waste_type_array[$j]),
                                        getRoute("Flacq", 45, "Resident", "Domestic"),
                                        $zone_rw['zoneID'],
                                        $region_rw['regionName'],
                                        $category_array[$i],
                                        $waste_type_array[$j]
                                    )
                                );

                            }

                        }

                    }

                }

            }
        }

        // REARRANGING DATA
        $tbl_route_arranged_array = array();
        for ($a = 0; $a < sizeof($tbl_route_array); $a++) {
            array_push($tbl_route_arranged_array, array($tbl_route_array[$a][0][0][0], $tbl_route_array[$a][0][0][1], $tbl_route_array[$a][0][0][2], $tbl_route_array[$a][1], $tbl_route_array[$a][2], $tbl_route_array[$a][3], $tbl_route_array[$a][4]));
        }

        echo json_encode($tbl_route_arranged_array);
    }

?>