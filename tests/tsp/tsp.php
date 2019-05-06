<?php

<<<<<<< HEAD
    $order = array();
    $grid = array();
    $completed = array();
    $route = ["1,1", "1,4", "4,1", "4,4"];
    travellingSalesmen($route, 0);


    // RETURNS AN ARRAY OF OPTIMIZED ROUTING AND REARRANGED WASTE AMOUNT ARRAY
    function travellingSalesmen($route, $amount){
        setDistanceGrid($route); // SET THE GRID OF ALL DISTANCES
        $nc = sizeof($route);
        mincost(0);

        print_r($GLOBALS['order']);
        // return ARRAY(ROUTE, AMOUNT);
    }

    // SETS THE GRID OF DISTANCES
    function setDistanceGrid($route) {
        $numberofhouses = sizeof($route); // GET THE NUMBER OF HOUSES
        for ($i = 0; $i < $numberofhouses; $i++) {
            $distance_row = array(); // THE DISTANCE LIST ROWS
            for ($j = 0; $j < $numberofhouses; $j++) {
                array_push($distance_row, getDistance($route[$i], $route[$j]));
            }
            array_push($GLOBALS['grid'], $distance_row);
            array_push($GLOBALS['completed'], 0);
            unset($distance_row);
=======
    $grid = array(
        array(0, 25, 8, 20),
        array(25, 0, 10, 2),
        array(8, 10, 0, 5),
        array(20, 2, 5, 0)
    );
    $n = 4; // NUMBER OF VILLAGES;
    $completed = array(0, 0, 0, 0);
    $optimized_route = array();

    function least($c) {
        global $n;
        global $grid;
        global $completed;
        $nc = 4;
        $min = 1000000;
        $kmin = 0;

        for ($i = 0; $i < $n; $i++) {
            if (($grid[$c][$i] != 0) && ($completed[$i] == 0)) {
                if ($grid[$c][$i] + $grid[$i][$c] < $min) {
                    $min = $grid[$i][0] + $grid[$c][$i];
                    $kmin = $grid[$c][$i];
                    $nc = $i;
                }
            }
>>>>>>> tsp
        }

        return $nc;

    }

<<<<<<< HEAD
    function getDistance($origin, $destination) {
        // RETURN DISTANCE
        $lon1 = deg2rad($origin[2]);
        $lat1 = deg2rad($origin[0]);
        $lon2 = deg2rad($destination[2]);
        $lat2 = deg2rad($destination[0]);
        
        $deltaLat = $lat2 - $lat1;
        $deltaLon = $lon2 - $lon1;
    
        $a = pow(sin($deltaLat/2), 2) + cos($lat1) * cos($lat2) * pow(sin($deltaLon/2), 2);
        $c = 2 * asin(sqrt($a));
        $EARTH_RADIUS = 6371;
        return $c * $EARTH_RADIUS * 1000;
    }

    function least($c) {
        $sum = 0; // SUM OF ALL DISTANCES
        for ($s = 0; $s < sizeof($GLOBALS['grid']); $s++) {
            for ($r = 0; $r < sizeof($GLOBALS['grid']); $r++) {
                $sum += $GLOBALS['grid'][$s][$r];
            }
        }
        
        $nc = 4;
        $min = 10000000; //$sum;
        $kmin = 0;
        for ($i = 0; $i < sizeof($GLOBALS['grid']); $i++) {
            if (($GLOBALS['grid'][$c][$i] != 0) && ($GLOBALS['completed'] == 0)) {
                if (($GLOBALS['grid'][$c][$i] + $GLOBALS['grid'][$i][$c]) < $min) {
                    $kmin = $GLOBALS['grid'][$c][$i];
                    $nc = $i;
                }
            }
        }
        return $nc;
    }

    function mincost($city) {
        $ncity = 0;
        $GLOBALS['completed'][$city] = 1;
        array_push($GLOBALS['order'], ($city+1));
        $ncity = least($city);
        if ($ncity == 4) {
            $ncity = 0;
            array_push($GLOBALS['order'], ($ncity+1));
            return;
        }
        mincost($ncity);
=======
    function mincost($city) {
        global $completed;
        global $optimized_route;
        $completed[$city] = 1;
        array_push($optimized_route, ($city+1));
        $ncity = least($city);

        if ($ncity == 4) {
            $ncity = 0;
            array_push($optimized_route, ($ncity+1));
            return;
        }
        mincost($ncity);
    }

    function tsp() {
        mincost(0);
>>>>>>> tsp
    }

    tsp();
    print_r($optimized_route);

    echo "php Version: " . phpversion();

?>