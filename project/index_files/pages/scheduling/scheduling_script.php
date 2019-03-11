<?php
    include("../db_connect.php");
    // ignore_user_abort(true);
    // set_time_limit(0);

    // GET TOTAL AMOUNT OF WASTE IN ONE ZONE
    function getTotalInZone($waste_type, $zone, $category){
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
                tbl_generator.Category = $category
            GROUP BY
                tbl_waste_gen.generatorID
            ORDER BY
                tbl_waste_gen.getDate DESC
            ";

        $route_array = array();
        if ($getCoordsAmountQuery = mysqli_query($conn, $getTotalQuery)){
            while ($coordsAmount = mysqli_fetch_assoc($getCoordsAmountQuery)) {
                array_push($route_array, array($coordsAmount['LocationCoordinate'], $coordsAmount[$waste_type]));
            }
        };
        return $route_array;
    }

    // getTotalInZone(wasteType, zone, Category)
    // print_r(getTotalInZone("Domestic", 45, "Resident"));

        

?>