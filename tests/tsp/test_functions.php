<?php
    include("../../Project/db_connect.php");
    include("../../Project/index_files/Pages/Scheduling/functions.php");
    
    $route = getRoute("Flacq", 45, "Resident", "Organic");

    echo $route[0][0][0];

?>