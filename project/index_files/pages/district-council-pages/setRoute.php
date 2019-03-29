<?php
    include("../../../db_connect.php");
    $query = "SELECT * FROM tbl_trips";
    if ($results = mysqli_query($conn, $query)) {
        while ($route = mysqli_fetch_assoc($results)) {
            
        }
    }
?>