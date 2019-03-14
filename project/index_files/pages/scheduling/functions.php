<?php

    function getRoute($region, $zone, $category, $waste_type){
        global $conn;
        $generalQuery =
            "SELECT
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
                    array_push($route_array, $location);
                    array_push($wasteAmountPerUser, json_decode($row[$waste_type]));
                    $numOfHouses++;
                    $total_waste += $row[$waste_type];
                }
            }

            array_push($data_array, array($route_array, $numOfHouses, $total_waste, $wasteAmountPerUser));

            return $data_array;

    }

    $tripArray = array();
    function createTrips($trip_builder_array, $regionName, $category, $wasteType, $zone, $allTrucks){
        for ($t = 0; $t < sizeof($allTrucks); $t++) {
            if ($allTrucks[$t][5] == 1) {
                if (($allTrucks[$t][0] == $category) && ($allTrucks[$t][1] == $wasteType) && ($allTrucks[$t][2] == $regionName)) {
                    setTrip($allTrucks[$t][3], $trip_builder_array, $allTrucks[$t][4], $zone);
                    return $t;
                } 
            }
        }
        return -1;
    }

    function setTrip($truckCapacity, $tripBuilder, $truck, $truckZone){

        global $tripArray;
        $tracker = $truckCapacity;
        $tripCount = 0;
        $tripPath = array();

        for ($b = 0; $b < sizeof($tripBuilder); $b++) {
            if ($tracker > $tripBuilder[$b][1]) {
                $tracker = $tracker - $tripBuilder[$b][1];
                array_push($tripPath, $tripBuilder[$b][0]);
            } else {
                $tripCount++;
                $tracker = $truckCapacity;
                unset($tripPath);
                $tripPath = array();
                array_push($tripPath, $tripBuilder[$b][0]);
                $tracker = $truckCapacity - $tripBuilder[$b][1];
                array_push($tripArray, array($tripCount, $tripPath, $truck, $truckZone));
            }
        }
    }

?>