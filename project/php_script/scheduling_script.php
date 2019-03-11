<?php
    include("../db_connect.php");
    // ignore_user_abort(true);
    // set_time_limit(0);

    // GET TOTAL AMOUNT OF WASTE IN ONE ZONE
    function getTotalInZone($waste_type, $zone){
        global $conn;
        $getTotalQuery =
            "SELECT
                tbl_waste_gen.generatorID,
                tbl_waste_gen.getDate,
                tbl_waste_gen.getTime,
                tbl_waste_gen.$waste_type,
                tbl_generator.zoneID
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
            GROUP BY
                tbl_waste_gen.generatorID
            ORDER BY
                tbl_waste_gen.getDate DESC
            ";

        $total_waste = 0;
        if ($getTotal = mysqli_query($conn, $getTotalQuery)){
            while ($total = mysqli_fetch_assoc($getTotal)) {
                $total_waste += $total[$waste_type];
            }
        };
        return $total_waste;
    }

    // echo getTotalInZone("Domestic", 45);

    



?>