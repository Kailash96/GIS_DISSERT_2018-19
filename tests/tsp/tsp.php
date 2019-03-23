<?php

    $route = array(
        array()
    );
    travellingSalesmen(0, 0);

    $grid = array();
    $completed = array();
    // RETURNS AN ARRAY OF OPTIMIZED ROUTING AND REARRANGED WASTE AMOUNT ARRAY
    function travellingSalesmen($route, $amount){
        // setDistanceGrid($route); // SET THE GRID OF ALL DISTANCES
        echo $route;

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