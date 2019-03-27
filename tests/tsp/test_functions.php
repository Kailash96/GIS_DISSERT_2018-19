<?php
    include("../../Project/db_connect.php");
    include("../../Project/index_files/Pages/Scheduling/functions.php");
    include("tsp.php");
    
    $route = getRoute("Flacq", 45, "Resident", "Organic");

    echo $route[0][0][0] . "<br/>";
    echo $route[0][0][1] . "<br/>";

    $data = array();
    array_push($data, $route[0][0][0]);
   
    $starttime = microtime(true);
    print_r(tsp($data));
    $endtime = microtime(true);

    $duration = $endtime - $starttime;
    echo "<br/><br/>" . $duration . "<br/><br/>";

    $data = array();
    array_push($data, $route[0][0][0]);
    array_push($data, $route[0][0][1]);

    $starttime = microtime(true);
    print_r(tsp($data));
    $endtime = microtime(true);

    $duration = $endtime - $starttime;
    echo "<br/><br/>" . $duration . "<br/><br/>";

    $data = array();
    array_push($data, $route[0][0][0]);
    array_push($data, $route[0][0][1]);
    array_push($data, $route[0][0][2]);

    $starttime = microtime(true);
    print_r(tsp($data));
    $endtime = microtime(true);

    $duration = $endtime - $starttime;
    echo "<br/><br/>" . $duration . "<br/><br/>";

    $data = array();
    array_push($data, $route[0][0][0]);
    array_push($data, $route[0][0][1]);
    array_push($data, $route[0][0][2]);
    array_push($data, $route[0][0][3]);

    $starttime = microtime(true);
    print_r(tsp($data));
    $endtime = microtime(true);

    $duration = $endtime - $starttime;
    echo "<br/><br/>" . $duration . "<br/><br/>";

    $data = array();
    array_push($data, $route[0][0][0]);
    array_push($data, $route[0][0][1]);
    array_push($data, $route[0][0][2]);
    array_push($data, $route[0][0][3]);
    array_push($data, $route[0][0][4]);

    $starttime = microtime(true);
    print_r(tsp($data));
    $endtime = microtime(true);

    $duration = $endtime - $starttime;
    echo "<br/><br/>" . $duration . "<br/><br/>";

    $data = array();
    array_push($data, $route[0][0][0]);
    array_push($data, $route[0][0][1]);
    array_push($data, $route[0][0][2]);
    array_push($data, $route[0][0][3]);
    array_push($data, $route[0][0][4]);
    array_push($data, $route[0][0][5]);

    $starttime = microtime(true);
    print_r(tsp($data));
    $endtime = microtime(true);

    $duration = $endtime - $starttime;
    echo "<br/><br/>" . $duration . "<br/><br/>";

    $data = array();
    array_push($data, $route[0][0][0]);
    array_push($data, $route[0][0][1]);
    array_push($data, $route[0][0][2]);
    array_push($data, $route[0][0][3]);
    array_push($data, $route[0][0][4]);
    array_push($data, $route[0][0][5]);
    array_push($data, $route[0][0][6]);

    $starttime = microtime(true);
    print_r(tsp($data));
    $endtime = microtime(true);

    $duration = $endtime - $starttime;
    echo "<br/><br/>" . $duration . "<br/><br/>";

    $data = array();
    array_push($data, $route[0][0][0]);
    array_push($data, $route[0][0][1]);
    array_push($data, $route[0][0][2]);
    array_push($data, $route[0][0][3]);
    array_push($data, $route[0][0][4]);
    array_push($data, $route[0][0][5]);
    array_push($data, $route[0][0][6]);
    array_push($data, $route[0][0][7]);

    $starttime = microtime(true);
    print_r(tsp($data));
    $endtime = microtime(true);

    $duration = $endtime - $starttime;
    echo "<br/><br/>" . $duration . "<br/><br/>";

    $data = array();
    array_push($data, $route[0][0][0]);
    array_push($data, $route[0][0][1]);
    array_push($data, $route[0][0][2]);
    array_push($data, $route[0][0][3]);
    array_push($data, $route[0][0][4]);
    array_push($data, $route[0][0][5]);
    array_push($data, $route[0][0][6]);
    array_push($data, $route[0][0][7]);
    array_push($data, $route[0][0][8]);

    $starttime = microtime(true);
    print_r(tsp($data));
    $endtime = microtime(true);

    $duration = $endtime - $starttime;
    echo "<br/><br/>" . $duration . "<br/><br/>";

    $data = array();
    array_push($data, $route[0][0][0]);
    array_push($data, $route[0][0][1]);
    array_push($data, $route[0][0][2]);
    array_push($data, $route[0][0][3]);
    array_push($data, $route[0][0][4]);
    array_push($data, $route[0][0][5]);
    array_push($data, $route[0][0][6]);
    array_push($data, $route[0][0][7]);
    array_push($data, $route[0][0][8]);
    array_push($data, $route[0][0][9]);

    $starttime = microtime(true);
    print_r(tsp($data));
    $endtime = microtime(true);

    $duration = $endtime - $starttime;
    echo "<br/><br/>" . $duration . "<br/><br/>";

    // ---------------------------------------------------------- 10

    $data = array();
    array_push($data, $route[0][0][0]);
    array_push($data, $route[0][0][1]);
    array_push($data, $route[0][0][2]);
    array_push($data, $route[0][0][3]);
    array_push($data, $route[0][0][4]);
    array_push($data, $route[0][0][5]);
    array_push($data, $route[0][0][6]);
    array_push($data, $route[0][0][7]);
    array_push($data, $route[0][0][8]);
    array_push($data, $route[0][0][9]);
    array_push($data, $route[0][0][10]);

    $starttime = microtime(true);
    print_r(tsp($data));
    $endtime = microtime(true);

    $duration = $endtime - $starttime;
    echo "<br/><br/>" . $duration . "<br/><br/>";



?>