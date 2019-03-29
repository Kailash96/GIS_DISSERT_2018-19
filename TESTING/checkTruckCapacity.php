<?php

    function setTrip($truckCapacity, $tripBuilder, $truck, $category, $tbl_route_ID){

        $tripArray = array();
        $tracker = $truckCapacity;
        $tripPath = array();
        $total_waste_per_trip = 0;

        for ($b = 0; $b < sizeof($tripBuilder); $b++) {
            if ($tracker >= $tripBuilder[0][1][$b]) {
                array_push($tripPath, $tripBuilder[0][0][$b]);
                $tracker = $tracker - $tripBuilder[0][1][$b];
                $total_waste_per_trip += $tripBuilder[0][1][$b];
            } else {
                array_push($tripArray, array($tripPath, $truck, $total_waste_per_trip, $tbl_route_ID));
                unset($tripPath); // RESET THE ARRAY FOR NEXT TRIP
                $tripPath = array();
                $tracker = $truckCapacity; // RESET THE TRUCK CAPACITY COUNTER FOR NEW TRIP
                array_push($tripPath, $tripBuilder[0][0][$b]);
                $tracker = $tracker - $tripBuilder[0][1][$b];
                $total_waste_per_trip = 0;
                $total_waste_per_trip += $tripBuilder[0][1][$b];
            }
        }
        array_push($tripArray, array($tripPath, $truck, $total_waste_per_trip, $tbl_route_ID));
        return $tripArray;
    }

    echo "<pre>";
    echo "Path with waste capacity:<br/><br/>";
    echo "A => 10, B => 20, C => 20 D => 20<br/><br/>";
    echo "Truck Capacity: 40<br/>";
    echo "Trip 1<br/>";
    $trial1 = array("A", "B");
    print_r($trial1);
    echo "Trip 2<br/>";
    $trial2 = array("C", "D");
    print_r($trial2);

?>