<?php
    include("../../../db_connect.php");
    include("functions.php");

    date_default_timezone_set('Indian/Mauritius');

    // ignore_user_abort(true);
    // set_time_limit(0);    
    $act = $_POST['act'];

    if ($act == "getRoute") {

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
            array_push($tbl_route_arranged_array, array($tbl_route_array[$a][0][0][0], $tbl_route_array[$a][0][0][1], $tbl_route_array[$a][0][0][2], $tbl_route_array[$a][0][0][3], $tbl_route_array[$a][1], $tbl_route_array[$a][2], $tbl_route_array[$a][3], $tbl_route_array[$a][4]));
        }

        echo json_encode($tbl_route_arranged_array);
    
    } else if ($act == "savetodb") {

        $data = json_decode($_POST['data']);

        $success_count = 0;
        $fail_count = 0;

        for ($i = 0; $i < sizeof($data); $i++) {

        
            $route_path = json_encode($data[$i][0]);
            $total_houses = $data[$i][1];
            $total_waste = $data[$i][2];
            $waste_amount_per_user = json_encode($data[$i][3]);
            $zone = $data[$i][4];
            $region = $data[$i][5];
            $category = $data[$i][6];
            $waste_type = $data[$i][7];

            $today = date("Y-m-d");

            $savetodb_query = 
            "INSERT INTO
                tbl_route_per_zone
                (Route_Path, Total_Houses, Total_Waste, Zone, RegionName, Category, Waste_Type, Date_Created)
            VALUES
                ('$route_path', $total_houses, $total_waste, $zone, '$region', '$category', '$waste_type', '$today')
            ";

            if (mysqli_query($conn, $savetodb_query)) {
                $success_count++;
            } else {
                $fail_count++;
            };

        }

        if ($success_count == sizeof($data)) {
            echo json_encode($waste_amount_per_user);
        } else {
            echo json_encode("error");
        }

    } else if ($act == "setTrips") {

        $waste_amount_per_user = json_decode($_POST['waste_amount_per_user']);

        $loopTblRouteQuery = "SELECT * FROM tbl_route_per_zone";
        if ($getPath = mysqli_query($conn, $loopTblRouteQuery)) {
            while ($path = mysqli_fetch_assoc($getPath)) {

                $tripBuilderArray = array();

                $path_array = json_decode($path['Route_Path']);
                for ($i = 0; $i < sizeof($path_array); $i++) {

                    array_push($tripBuilderArray, array($path_array[$i], $waste_amount_per_user[$i], $path['RegionName']));

                }

                createTrips($tripBuilderArray);

            }
        }

        echo json_encode($tripBuilderArray);

    }

?>