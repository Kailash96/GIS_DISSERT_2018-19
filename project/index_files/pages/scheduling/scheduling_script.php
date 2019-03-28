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

    fetchData();
?>