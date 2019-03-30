<?php


    $data = json_decode($_POST['data']);
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

    function tsp($route) {
        global $n;
        global $total;

        $n = sizeof($route);
        $completed = setDistanceGrid($route)[0];
        $grid = setDistanceGrid($route)[1];
        return minDist(0, $completed, $grid);
        $total = 0;
        $n = 0;
    }

    $opt_arranged = array();
    for ($m = 0; $m < sizeof($data); $m++) {
        $opt_route = array();
        $opt_amount = array();
        $opt = tsp($data[$m][0]);
        for ($o = 0; $o < sizeof($opt); $o++){
            array_push($opt_route, $data[$m][0][$opt[$o]]);
            array_push($opt_amount, $data[$m][3][$opt[$o]]);
        }
        array_push($opt_arranged, 
            array(
                $opt_route,
                $data[$m][1],
                $data[$m][2],
                $opt_amount,
                $data[$m][4],
                $data[$m][5],
                $data[$m][6],
                $data[$m][7]
            )
        );
    }

    echo json_encode($opt_arranged);

?>