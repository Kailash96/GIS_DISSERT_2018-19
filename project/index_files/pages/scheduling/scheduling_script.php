<?php
    include("../../../db_connect.php");
    include("functions.php");


    // FETCHES ALL THE DATA OF USERS WHERE WASTES ARE TO BE COLLECTED
    function fetchData() {
        global $conn;
        $store = array();
        $category_array = array("Resident", "Commercial", "Industrial");
        $waste_type_array = array("Organic", "Plastic", "Paper", "Other");
        $regionQuery = "SELECT * FROM tbl_region";
        if ($regioning = mysqli_query($conn, $regionQuery)) {
            while ($region = mysqli_fetch_assoc($regioning)) {
                $regionID = $region['regionID'];
                $zoneQuery = "SELECT * FROM tbl_zones WHERE regionID = $regionID";
                if ($zoning = mysqli_query($conn, $zoneQuery)) {
                    while ($zone = mysqli_fetch_assoc($zoning)) {
                        for ($i = 0; $i < sizeof($category_array); $i++) {
                            for ($j = 0; $j < sizeof($waste_type_array); $j++) {
                                $store = array_merge($store, getRoute($region['regionName'], $zone['zoneID'], $category_array[$i], $waste_type_array[$j]));
                            }
                        }
                    }
                }
            }
        }
        saveTable($store);
    }

    // STORE IN DB
    function saveTable($store) {
        global $conn;
        for ($s = 0; $s < sizeof($store); $s++) {
            $location = $store[$s][0];
            $amount = $store[$s][1];
            $date = $store[$s][2];
            $wastetype = $store[$s][3];
            $generatorID = $store[$s][4];
            $status = $store[$s][5];
    
            $storeQuery = "INSERT INTO tbl_route_full_region (Locations, Amount, DateRecorded, WasteType, GeneratorID, Status)
                VALUES ('$location', $amount, '$date', '$wastetype', '$generatorID', $status)
            ";
            
            if (!mysqli_query($conn, $storeQuery)) {
                break;
            }
        }
    }

    // fetchData();

    function buildTruck() {
        global $conn;
        $truckArray = array();
        $getTruckQuery = "SELECT * FROM tbl_trucks INNER JOIN tbl_collectors WHERE tbl_collectors.CollectorID = tbl_trucks.OwnerID";
        if ($getTrucks = mysqli_query($conn, $getTruckQuery)) {
            while ($trucks = mysqli_fetch_assoc($getTrucks)) {
                array_push($truckArray, array(
                    $trucks['PlateNumber'],
                    $trucks['Capacity'],
                    $trucks['Category'],
                    $trucks['RegionName'],
                    $trucks['WorkingHours'], // TIME LEFT
                    $trucks['Status']
                ));
            }
        }
        return $truckArray;
    }
    $trucks = buildTruck(); // CREATES TRUCK ARRAY GLOBALLY

    function nextTruck($category, $region, $capacity) {
        global $trucks;
        $truckRow = -1;
        for ($i = 0; $i < sizeof($trucks); $i++) {
            if (($trucks[$i][2] == $category) && ($trucks[$i][5] == 1) && ($trucks[$i][3] == $region) && ($trucks[$i][1] == $capacity)) {
                $trucks[$i][5] = 0;
                $truckRow = $i;
                return $truckRow;
            }
        }
        return $truckRow;
    }

    function resetTruckStatus($category, $region, $capacity) {
        global $trucks;
        for ($i = 0; $i < sizeof($trucks); $i++) {
            if (($trucks[$i][2] == $category) && ($trucks[$i][5] == 0) && ($trucks[$i][3] == $region) && ($trucks[$i][1] == $capacity)) {
                $trucks[$i][5] = 1;
            }
        }
    }

    function distance($origin, $destination) {
        $origin = explode(",", $origin);
        $destination = explode(",", $destination);
        // return distance in meters
        $lon1 = deg2rad($origin[1]);
        $lat1 = deg2rad($origin[0]);
        $lon2 = deg2rad($destination[1]);
        $lat2 = deg2rad($destination[0]);
    
        $deltaLat = $lat2 - $lat1;
        $deltaLon = $lon2 - $lon1;
    
        $a = pow(sin($deltaLat/2), 2) + cos($lat1) * cos($lat2) * pow(sin($deltaLon/2), 2);
        $c = 2 * asin(sqrt($a));
        $EARTH_RADIUS = 6371;
        return $c * $EARTH_RADIUS * 1000;
    }

    function getDuration($point1, $point2) {
        $speed = 30; // 50 km/hr
        // change distance to KM
        $distance = distance(json_decode($point1), json_decode($point2)) / 1000;
        $duration = $distance / $speed;
        $duration = $duration * 3600; // CONVERT TO SECONDS FOR MORE PRECISION
        return $duration;
    }

    function setTrips() {
        global $conn;
        global $trucks;
        $changeZone = false;
        $today = date("Y-m-d");
        $tripArray = array();
        $regionQuery = "SELECT * FROM tbl_region";
        if ($regioning = mysqli_query($conn, $regionQuery)) {
            while ($region = mysqli_fetch_assoc($regioning)) {
                $truckCapacity = 0;
                $timeLeft = 0;
                $tripNumber = 1;
                $totalAmount = 0;
                $currentLocation = 0;
                $regionID = $region['regionID'];
                $zones = "SELECT * FROM tbl_zones WHERE regionID = $regionID";
                if ($zoning = mysqli_query($conn, $zones)) {
                    while ($zoner = mysqli_fetch_assoc($zoning)) {
                        if ($totalAmount <= 0) {
                            $crrzone = $zoner['zoneID'];
                            $setTotalAmountQuery = "SELECT SUM(Amount) FROM tbl_route_full_region INNER JOIN tbl_generator ON tbl_generator.GeneratorID = tbl_route_full_region.GeneratorID WHERE zoneID = $crrzone";
                            // GET TOTAL AMOUNT FOR EACH ZONE
                            $totalAmount = mysqli_fetch_assoc(mysqli_query($conn, $setTotalAmountQuery));
                        }
                        $zoneID = $zoner['zoneID'];
                        $getTripQuery = "SELECT * FROM tbl_route_full_region INNER JOIN tbl_generator ON tbl_route_full_region.GeneratorID = tbl_generator.GeneratorID WHERE tbl_generator.zoneID = $zoneID AND WasteType = 'Organic' AND Status = 0";
                        if ($tripready = mysqli_query($conn, $getTripQuery)) {
                            while ($trip = mysqli_fetch_assoc($tripready)) {
                                if (($truckCapacity <= 0) || ($timeLeft <= 0)) {
                                    $truckRowFetched = nextTruck($trip['Category'], $trip['region'], 5000); // FETCH BIG TRUCK CAPACITY: 5000
                                    if ($truckRowFetched >= 0) { // TRUCK EXISTS
                                        $truckCapacity = $trucks[$truckRowFetched][1];
                                        $timeLeft = $trucks[$truckRowFetched][4];
                                        $noTruck = false;
                                    } else {
                                        $noTruck = true;
                                        break;
                                    }
                                }
                                if ($currentLocation == 0) {
                                    $nextLocation = $trip['Locations'];
                                    $currentLocation = $nextLocation;
                                } else {
                                    $currentLocation = $nextLocation;
                                    $nextLocation = $trip['Locations'];
                                }
                                $collectionTime = 180; // 3MINS (180 SECS)
                                $duration = getDuration(json_encode($currentLocation), json_encode($nextLocation)) + $collectionTime;
                                $flag = true;
                                while ($flag) {
                                    if ($duration <= $timeLeft) {
                                        if ($trip['Amount'] <= $truckCapacity) {
                                            $truckCapacity -= $trip['Amount'];
                                            $genID = $trip['GeneratorID'];
                                            $setStatusQuery = "UPDATE tbl_route_full_region SET Status = 1 WHERE GeneratorID = '$genID'";
                                            mysqli_query($conn, $setStatusQuery); // SET STATUS OF COLLECTED TO 1
                                            $totalAmount -= $trip['Amount'];
                                            array_push($tripArray, array(
                                                $trip['Locations'],
                                                $duration,
                                                $tripNumber,
                                                $trip['zoneID']
                                            ));
                                            $flag = false;
                                        } else {
                                            // TIME TAKEN TO DROP TO TRANSFER STATION
                                            $timeLeft -= 0.75; // 45 MINS (O.75 HOURS)
                                            $truckCapacity = $trucks[$truckRowFetched][1]; // RESET TRUCK CAPACITY
                                            $tripNumber++;
                                            $flag = true;
                                            if ($totalAmount <= ((1 / 2) * $truckCapacity)) {
                                                $flag = false;
                                                $changeZone = true;
                                            }
                                        }
                                    } else {
                                        $truckRowFetched = nextTruck($trip['Category'], $trip['region'], 5000); // FETCH BIG TRUCK CAPACITY:5000
                                        if ($truckRowFetched < 0) { // NO TRUCK
                                            $today = date("Y-m-d", strtotime($today . ' +1 day'));
                                            $checkDay = strtotime($today);
                                            $day = date("l", $checkDay);
                                            if ($day == "Sunday") {
                                                $today = date("Y-m-d", strtotime($today . ' +1 day'));
                                            }
                                            resetTruckStatus($trip['Category'], $trip['region'], 5000);
                                            $timeLeft = 8;
                                            $flag = false; // true; // temp - should be true ---------------------------------------------------------
                                        }
                                        $tripNumber = 1;
                                        
                                    }
                                    if ($changeZone) {
                                        break;
                                    }
                                }
                            }
                        }
                        if ($noTruck) {
                            break;
                        }
                    }
                }
            }
        }
        return $tripArray;
    }

    echo "<pre>";
    print_r(setTrips());

?>