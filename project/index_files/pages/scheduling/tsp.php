<?php


    $data = json_decode($_POST['data']);

    $completed = array();
    $optimized_route = array();
    $grid = array();
    $n = 0; // NUMBER OF VILLAGES;
    $total = 0;

    function least($c) {
        global $n;
        global $grid;
        global $completed;
        global $total;

        $nc = $n;
        $min = $total * 2;
        $kmin = 0;

        for ($i = 0; $i < $n; $i++) {
            if (($grid[$c][$i] != 0) && ($completed[$i] == 0)) {
                if (($grid[$c][$i] + $grid[$i][$c]) < $min) {
                    $min = $grid[$i][0] + $grid[$c][$i];
                    $kmin = $grid[$c][$i];
                    $nc = $i;
                }
            }
        }

        return $nc;

    }

    function mincost($city) {
        global $completed;
        global $optimized_route;
        global $n;

        $completed[$city] = 1;
        array_push($optimized_route, $city);
        $ncity = least($city);

        if ($ncity == $n) {            
            return;
        }
        mincost($ncity);
    }
    
    function getDistance($origin, $destination) {
        global $total;
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
        $subtotal = round($c * $EARTH_RADIUS * 1000);
        $total += $subtotal;
        return $subtotal;

    }

     // SETS THE GRID OF DISTANCES
     function setDistanceGrid($route) {
        global $completed;
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

    function tsp($route, $amount) {
        global $optimized_route;
        global $n;
        global $grid;
        global $completed;
        $n = sizeof($route);
        setDistanceGrid($route);
        mincost(0);

        echo json_encode($optimized_route);

    }

    tsp($data[0][0], $data[0][3]);

?>