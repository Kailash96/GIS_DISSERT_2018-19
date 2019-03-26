<?php

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
        }

        return $nc;

    }

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
    }

    tsp();
    print_r($optimized_route);

    echo "php Version: " . phpversion();

?>