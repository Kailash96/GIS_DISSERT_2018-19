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
        $waste_type_array = array("Organic", "Plastic", "Paper", "Other");

        $region_query = "SELECT * FROM tbl_region";
        if ($regioning = mysqli_query($conn, $region_query)) {
            while ($region_rw = mysqli_fetch_assoc($regioning)) {
                $region_ID = $region_rw['regionID'];
                $zone_query = "SELECT * FROM tbl_zones WHERE regionID = $region_ID";
                if ($zoning = mysqli_query($conn, $zone_query)) {

                    while ($zone_rw = mysqli_fetch_assoc($zoning)) {

                        for ($c = 0; $c < sizeof($category_array); $c++) {

                            for ($w = 0; $w < sizeof($waste_type_array); $w++) {
                                $region_name = $region_rw['regionName'];
                                $zone_ID = $zone_rw['zoneID'];
                                $getRoute = getRoute($region_name, $zone_ID, $category_array[$c], $waste_type_array[$w]);
                                if ($getRoute > 0) {
                                    array_push(
                                        $tbl_route_array,
                                        array(
                                            $getRoute,
                                            // getRoute("Flacq", 45, "Resident", "Organic"), // column Domestic changed to Organic to fix bugs
                                            $zone_ID,
                                            $region_name,
                                            $category_array[$c],
                                            $waste_type_array[$w]
                                        )
                                    );
                                }
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
            $zone = $data[$i][4];
            $region = $data[$i][5];
            $category = $data[$i][6];
            $waste_type = $data[$i][7];
            $waste_amount_per_user = json_encode($data[$i][3]);

            $today = date("Y-m-d");

            $savetodb_query = 
            "INSERT INTO
                tbl_route_per_zone
                (Route_Path, AmountPerHouse, Total_Houses, Total_Waste, Zone, RegionName, Category, Waste_Type, Date_Created)
            VALUES
                ('$route_path', '$waste_amount_per_user', $total_houses, $total_waste, $zone, '$region', '$category', '$waste_type', '$today')
            ";

            if (mysqli_query($conn, $savetodb_query)) {
                $success_count++;
            } else {
                $fail_count++;
            };

        }

        if ($success_count == sizeof($data)) {
            echo json_encode(1);
        } else {
            echo json_encode(0);
        }

    } else if ($act == "setTrips") {

        // GET ALL THE TRUCKS
        $all_trucks_array = array();
        $getAllTrucksQuery = "SELECT * FROM tbl_trucks INNER JOIN tbl_collectors ON tbl_collectors.CollectorID = tbl_trucks.OwnerID WHERE Status = 1";
        if ($getAllTrucks = mysqli_query($conn, $getAllTrucksQuery)) {
            while ($allTrucks = mysqli_fetch_assoc($getAllTrucks)) {
                array_push($all_trucks_array, array($allTrucks['Category'], $allTrucks['WasteType'], $allTrucks['RegionName'], $allTrucks['Capacity'], $allTrucks['PlateNumber'], 1));
            }
        }

        // SETUP OF AN ARRAY TO KEEP TRACK OF WHICH TRUCK HAS ALREADY BEEN ASSIGNED A ZONE
        // KEEPING TRACK HELPS THE LOOP TO CHOOSE THE NEXT AVAILABLE TRUCK INSTEAD OF UNAVAILABLE ONE
        $allTrucksArrayRearranged = array();
        for ($r = 0; $r < sizeof($all_trucks_array); $r++) {
            if (sizeof($allTrucksArrayRearranged) < 1) {
                array_push($allTrucksArrayRearranged, array($all_trucks_array[$r][0], $all_trucks_array[$r][1], $all_trucks_array[$r][2], 1, 1));
            } else {
                for ($j = 0; $j < sizeof($allTrucksArrayRearranged); $j++) {
                    if (($all_trucks_array[$r][0] == $allTrucksArrayRearranged[$j][0]) && ($all_trucks_array[$r][1] == $allTrucksArrayRearranged[$j][1]) && ($all_trucks_array[$r][2] == $allTrucksArrayRearranged[$j][2])) {
                        $allTrucksArrayRearranged[$j][3] = $allTrucksArrayRearranged[$j][3] + 1;
                        $allTrucksArrayRearranged[$j][4] = $allTrucksArrayRearranged[$j][4] + 1;
                    } else {
                        array_push($allTrucksArrayRearranged, array($all_trucks_array[$r][0], $all_trucks_array[$r][1], $all_trucks_array[$r][2], 1, 1));
                    }
                }
            }
        }

        $tripArray = array();
        $today = date("Y-m-d");
        $loopTblRouteQuery = "SELECT * FROM tbl_route_per_zone WHERE Date_Created = '$today'";
        if ($getPath = mysqli_query($conn, $loopTblRouteQuery)) {
            while ($path = mysqli_fetch_assoc($getPath)) {

                $tripBuilderArray = array();

                $path_array = json_decode($path['Route_Path']);
                $waste_amount = json_decode($path['AmountPerHouse']);
                for ($i = 0; $i < sizeof($path_array); $i++) {
                    array_push($tripBuilderArray, array($path_array[$i], $waste_amount[$i]));
                }

                $truckRankAssigned = createTrips($tripBuilderArray, $path['RegionName'], $path['Category'], $path['Waste_Type'], $all_trucks_array, $path['RPZ_ID']);

                if ($truckRankAssigned > -1) {
                    $all_trucks_array[$truckRankAssigned][5] = 0;
                    for ($c = 0; $c < sizeof($allTrucksArrayRearranged); $c++) {
                        if (($all_trucks_array[$truckRankAssigned][0] == $allTrucksArrayRearranged[$c][0]) && ($all_trucks_array[$truckRankAssigned][1] == $allTrucksArrayRearranged[$c][1]) && ($all_trucks_array[$truckRankAssigned][2] == $allTrucksArrayRearranged[$c][2])) {
                            $allTrucksArrayRearranged[$c][4] = $allTrucksArrayRearranged[$c][4] - 1;
                            if ($allTrucksArrayRearranged[$c][4] < 1) {
                                $allTrucksArrayRearranged[$c][4] = $allTrucksArrayRearranged[$c][3];
                                for ($reset = 0; $reset < sizeof($all_trucks_array); $reset++) {
                                    if (($all_trucks_array[$reset][0] == $allTrucksArrayRearranged[$c][0]) && ($all_trucks_array[$reset][1] == $allTrucksArrayRearranged[$c][1]) && ($all_trucks_array[$reset][2] == $allTrucksArrayRearranged[$c][2])) {
                                        $all_trucks_array[$reset][5] = 1;
                                    }
                                }
                            }
                            break;
                        }
                    }
                }

            }
        }
        
        echo json_encode($tripArray);

    } else if ($act == "saveTrips") {
        $trips = json_decode($_POST['trips']);

        $flag = 0;
        for ($t = 0; $t < sizeof($trips); $t++) {
            $tripPath = json_encode($trips[$t][0]);
            $truckID = $trips[$t][1];
            $total_waste_amount = $trips[$t][2];
            $routeID = $trips[$t][3];
            $numOfHouses = $trips[$t][4];
            $duration = $trips[$t][5];
            $distance = $trips[$t][6];

            $saveQuery =
                "INSERT INTO
                    tbl_trips (Trips, NumberOfHouses, Waste_amount, Duration_hrs, Distance_km, RouteID, TruckID)
                 VALUES ('$tripPath', $numOfHouses, $total_waste_amount, $duration, $distance, $routeID, '$truckID')
                ";

            if (!mysqli_query($conn, $saveQuery)) {
                $flag = 0;
                break;
            } else {
                $flag = 1;
            }
        }

        echo json_encode($flag);

    } else if ($act == "scheduling") {

        $schedule = array();
        $dateTracker = "2019-03-18"; // should be monday's date
        $endDate = "2019-03-24"; // should be sunday's date
        define("WORKING_HOURS", $_POST['workingHours']); // setting $working_hours to constant variable

        $timeLeft = WORKING_HOURS;
        define("START_TIME", $_POST['starttime']); // setting START_TIME to constant variable
        $startTracker = START_TIME;
        $endTime = START_TIME;
        $zoneTracker = 0;

        $getTrucksQuery = "SELECT * FROM tbl_trucks";
        if ($getTrucks = mysqli_query($conn, $getTrucksQuery)) {
            while ($trucks = mysqli_fetch_assoc($getTrucks)) {
                $truck_ID = $trucks['PlateNumber'];
                
                // loop in tbl_trips where truck = selected;
                $getTripsQuery = "SELECT * FROM tbl_trips INNER JOIN tbl_route_per_zone ON tbl_trips.RouteID = tbl_route_per_zone.RPZ_ID WHERE TruckID = '$truck_ID'";
                if ($getTrips = mysqli_query($conn, $getTripsQuery)) {
                    while ($trips = mysqli_fetch_assoc($getTrips)) {

                        $current_zone = $trips['Zone'];
                        $duration = $trips['Duration_hrs'];
                        $flag = false; // set to true to break while loop
                        
                        while (!$flag) {
                            if ($duration <= $timeLeft) {
                                $timeLeft -= $duration;
                                if ($zoneTracker == $current_zone) {
                                    $timestamp = strtotime($endTime) + ($duration * 3600);
                                    $endTime = date('H:i', $timestamp);
                                } else {
                                    if ($zoneTracker != 0) {
                                        $unixtimestamp = strtotime($dateTracker);
                                        $day = date("l", $unixtimestamp);
                                        array_push($schedule, array($zoneTracker, $startTracker, $endTime, $truck_ID, $dateTracker, $day));
                                    }
                                    $zoneTracker = $current_zone;
                                    $startTracker = $endTime;
                                    $timestamp = strtotime($endTime) + ($duration * 3600);
                                    $endTime = date('H:i', $timestamp);
                                }
                                $flag = true;
                            } else {
                                $dateTracker = date('Y-m-d', strtotime("+1 day", strtotime($dateTracker)));
                                if ($dateTracker == $endDate) {
                                    $dateTracker = date('Y-m-d', strtotime("+1 day", strtotime($dateTracker))); // set to monday
                                    $endDate = date('Y-m-d', strtotime("+7 day", strtotime($endDate))); // next sunday
                                }
                                $timeLeft = WORKING_HOURS;
                                $startTracker = START_TIME;
                                $endTime = START_TIME;
                                $flag = false;
                            }
                        }
                    }

                }
            }
        }

        echo json_encode($schedule);

    }

?>