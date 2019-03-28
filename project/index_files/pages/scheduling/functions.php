<?php

    include("tsp.php");
    function getRoute($region, $zone, $category, $waste_type){
        $route_amount_full_region = array();
        $amount = 0;
        if ($waste_type == "Organic") {
            $amount = 0;
        } else if ($waste_type == "Plastic") {
            $amount = 40;
        } else if ($waste_type == "Paper") {
            $amount = 40;
        } else if ($waste_type == "Other") {
            $amount = 40;
        }
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
                tbl_waste_gen.$waste_type > $amount
            AND
                tbl_generator.Category = '$category'
            AND
                tbl_generator.Region = '$region'
            GROUP BY
                tbl_waste_gen.generatorID
            ORDER BY
                tbl_waste_gen.getDate DESC
            ";

        if ($result = mysqli_query($conn, $generalQuery)) {
            while ($row = mysqli_fetch_assoc($result)) {
                array_push($route_amount_full_region, array(
                        $row['LocationCoordinate'],
                        $row[$waste_type],
                        date("Y-m-d"),
                        $waste_type,
                        $row['GeneratorID'],
                        0
                    )
                );
            }
        }

        // OPTIMIZE ROUTE
        return tsp(json_encode($route_amount_full_region));
        
    }