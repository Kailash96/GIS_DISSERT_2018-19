<?php

    $n = 0; // NUMBER OF VILLAGES;
    $total = 0;

    function least($c, $completed, $grid) {
        global $n;
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

    function minDist($city, $completed, $grid) {
        global $n;
        $optimized_route = array();
        $ncity = $city;
        while ($ncity != $n) {
            $completed[$ncity] = 1;
            array_push($optimized_route, $ncity);
            $ncity = least($ncity, $completed, $grid);
            if ($ncity == $n) {
                return $optimized_route;
            }
        }
    }
    
    function getDistance($origin, $destination) {

        global $total;
        $origin = explode(",", $origin[0]);
        $destination = explode(",", $destination[0]);

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
        $distance = round($c * $EARTH_RADIUS * 1000);
        $total += $distance;
        return $distance;

    }

     // SETS THE GRID OF DISTANCES
     function setDistanceGrid($route) {

        $completed = array();
        $grid = array();
        $return = array();
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
        array_push($return, $completed, $grid);
        return $return;

    }

    function rearrange($order, $disorder) {
        $inOrder = array();
        for ($m = 0; $m < sizeof($order); $m++) {
            array_push($inOrder, $disorder[$order[$m]]);
        }
        return $inOrder;
    }

    function tsp($data) {
        global $n;
        global $total;
        $route = json_decode($data);
        $n = sizeof($route);
        $completed = setDistanceGrid($route)[0];
        $grid = setDistanceGrid($route)[1];
        $order = minDist(0, $completed, $grid);
        return rearrange($order, $route);
    }

?>