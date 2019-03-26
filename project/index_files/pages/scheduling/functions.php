<?php

    function getRoute($region, $zone, $category, $waste_type){
        global $conn;
        $generalQuery =
            "SELECT
                tbl_generator.GeneratorID,
                tbl_waste_gen.generatorID,
                tbl_waste_gen.getDate,
                tbl_waste_gen.getTime,
                tbl_waste_gen.$waste_type,
                tbl_generator.zoneID,
                tbl_generator.Region,
                tbl_generator.LocationCoordinate
            FROM
                tbl_waste_gen
            INNER JOIN
                tbl_generator
            ON
                tbl_waste_gen.generatorID = tbl_generator.GeneratorID
            WHERE
                tbl_waste_gen.getDate
            IN
                (
                    SELECT
                        MAX(getDate)
                    FROM
                        tbl_waste_gen
                    GROUP BY
                        generatorID
                )
            AND
                tbl_waste_gen.getTime
            IN
                (
                    SELECT
                        MAX(getTime)
                    FROM
                        tbl_waste_gen
                    GROUP BY
                        generatorID
                )
            AND
                tbl_generator.zoneID = $zone
            AND
                tbl_waste_gen.$waste_type > 0
            AND
                tbl_generator.Category = '$category'
            AND
                tbl_generator.Region = '$region'
            GROUP BY
                tbl_waste_gen.generatorID
            ORDER BY
                tbl_waste_gen.getDate DESC
            ";

            $route_array = array();
            $numOfHouses = 0;
            $total_waste = 0;
            $data_array = array();
            $wasteAmountPerUser = array();

            if ($getResult = mysqli_query($conn, $generalQuery)) {
                while ($row = mysqli_fetch_assoc($getResult)) {
                    $location = $row['LocationCoordinate'];
                    $waste_amount = json_decode($row[$waste_type]);
                    if ($category == "Resident") {
                        // CONVERT AMOUNT TO KG (ACTURALLY IN %)
                        $waste_amount_in_kg = ($waste_amount / 100) * 20;
                    } else {
                        // CONVERT AMOUNT TO KG (ACTURALLY IN %)
                        $waste_amount_in_kg = ($waste_amount / 100) * 80;
                    }
                    array_push($route_array, $location);
                    array_push($wasteAmountPerUser, $waste_amount_in_kg);
                    $numOfHouses++;
                    $total_waste += $waste_amount_in_kg;
                }
            }

            if (sizeof($route_array) > 0) {
                // $tsp = travellingSalesman($route_array, $wasteAmountPerUser);
                // $optimized_route = $tsp[0];
                // $optimized_route_waste_amount = $tsp[1];
                // array_push($data_array, array($optimized_route, $numOfHouses, $total_waste, $optimized_route_waste_amount));
                array_push($data_array, array($route_array, $numOfHouses, $total_waste, $wasteAmountPerUser));
                return $data_array;
            } else {
                return 0;
            }

    }

    function createTrips($trip_builder_array, $regionName, $category, $wasteType, $allTrucks, $tbl_route_ID){

        for ($t = 0; $t < sizeof($allTrucks); $t++) {
            if ($allTrucks[$t][5] == 1) {
                if (($allTrucks[$t][0] == $category) && ($allTrucks[$t][1] == $wasteType) && ($allTrucks[$t][2] == $regionName)) {
                    setTrip($allTrucks[$t][3], $trip_builder_array, $allTrucks[$t][4], $category, $tbl_route_ID);
                    return $t;
                } 
            }
        }
        return -1;
    }

    function setTrip($truckCapacity, $tripBuilder, $truck, $category, $tbl_route_ID){

        global $tripArray;
        $tracker = $truckCapacity;
        $tripPath = array();
        $total_waste_per_trip = 0;

        for ($b = 0; $b < sizeof($tripBuilder); $b++) {
            if ($tracker >= $tripBuilder[$b][1]) {
                array_push($tripPath, $tripBuilder[$b][0]);
                $tracker = $tracker - $tripBuilder[$b][1];
                $total_waste_per_trip += $tripBuilder[$b][1];
            } else {
                array_push($tripArray, array($tripPath, $truck, $total_waste_per_trip, $tbl_route_ID));
                unset($tripPath); // RESET THE ARRAY FOR NEXT TRIP
                $tripPath = array();
                $tracker = $truckCapacity; // RESET THE TRUCK CAPACITY COUNTER FOR NEW TRIP
                array_push($tripPath, $tripBuilder[$b][0]);
                $tracker = $tracker - $tripBuilder[$b][1];
                $total_waste_per_trip = 0;
                $total_waste_per_trip += $tripBuilder[$b][1];
            }
        }
        array_push($tripArray, array($tripPath, $truck, $total_waste_per_trip, $tbl_route_ID));

    }

    $grid = array();
    $completed = array();
    // RETURNS AN ARRAY OF OPTIMIZED ROUTING AND REARRANGED WASTE AMOUNT ARRAY
    function travellingSalesmen($route, $amount){
        setDistanceGrid($route); // SET THE GRID OF ALL DISTANCES

        
        // return ARRAY(ROUTE, AMOUNT);
    }

    // SETS THE GRID OF DISTANCES
    function setDistanceGrid($route) {
        global $grid;
        $numberofhouses = sizeof($route); // GET THE NUMBER OF HOUSES
        for ($i = 0; $i < $numberofhouses; $i++) {
            $distance_row = array(); // THE DISTANCE LIST ROWS
            for ($j = 0; $j < $numberofhouses; $j++) {
                array_push($distance_row, getDistance($route[$i], $route[$j]));
            }
            array_push($grid, $distance_row);
            array_push($completed, 0);
            unset($distance_row);
        }
    }

    function getDistance($origin, $destination) {
        // RETURN DISTANCE
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

    function least($c) {
        
    }

?>