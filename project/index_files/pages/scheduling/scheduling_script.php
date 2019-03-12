<?php
    include("../../../db_connect.php");
    // ignore_user_abort(true);
    // set_time_limit(0);

    // GET TOTAL AMOUNT OF WASTE IN ONE ZONE
    function planTheRoute($waste_type, $zone, $category){
        global $conn;
        $getTotalQuery =
            "SELECT
                tbl_waste_gen.generatorID,
                tbl_waste_gen.getDate,
                tbl_waste_gen.getTime,
                tbl_waste_gen.$waste_type,
                tbl_generator.zoneID,
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
            GROUP BY
                tbl_waste_gen.generatorID
            ORDER BY
                tbl_waste_gen.getDate DESC
            ";

        $general_array = array();
        $route_array = array();
        $total_house = 0;
        $total_waste = 0;
        if ($getCoordsAmountQuery = mysqli_query($conn, $getTotalQuery)){
            while ($coordsAmount = mysqli_fetch_assoc($getCoordsAmountQuery)) {
                $total_house++;
                $total_waste += $coordsAmount[$waste_type];
                array_push($route_array, $coordsAmount['LocationCoordinate']);
            }
        };
        
        array_push($general_array, array($total_house, $total_waste, $route_array));

        return $general_array;
    }

    // planTheRoute(wasteType, zone, Category)
    
    
    print_r(planTheRoute("Domestic", 45, "Resident"));

    $general_route_array = array();
    
    $loopRegionQuery = "SELECT * FROM tbl_Region";
    if ($regioning = mysqli_query($conn, $loopRegionQuery)) {
        while ($region = mysqli_fetch_assoc($regioning)) {

            $region_ID = $region['regionID'];
            $loopZoneQuery = "SELECT * FROM tbl_zone WHERE regionID = $region_ID";
            if ($zoning = mysqli_query($conn, $loopZoneQuery)) {
                while ($zone = mysqli_fetch_assoc($zoning)) {

                    $zone_ID = $zone['zoneID'];
                    array_push($general_route_array, array(planTheRoute("Domestic", $zone_ID, "Resident"), $zone_ID, $region_ID, "Resident"));
                    array_push($general_route_array, array(planTheRoute("Domestic", $zone_ID, "Commercial"), $zone_ID, $region_ID, "Commercial"));
                    array_push($general_route_array, array(planTheRoute("Domestic", $zone_ID, "Industrial"), $zone_ID, $region_ID, "Industrial"));

                }
            }

        }
    }

    print_r($general_route_array); // to verify       

?>