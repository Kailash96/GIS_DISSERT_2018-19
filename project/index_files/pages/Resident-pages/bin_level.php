<?php
    include("../../../db_connect.php");

    $genID = $_POST['GenID'];
    $capacity = $_POST['cap'];
    $type = $_POST['type'];
    $numOfBins = $_POST['nob'];
    $level = $_POST['level'];

    $total_capacity = $capacity * $numOfBins;
    $percent_level = ($level / $total_capacity) * ($numOfBins * 100);

    $getBinID_query = "SELECT GenBinID FROM bins WHERE Type = '$type' AND Capacity = '$capacity' AND GeneratorID = '$genID' LIMIT 1";
    if ($binID_result = mysqli_query($conn, $getBinID_query)){

        $binID_row = mysqli_fetch_assoc($binID_result);
        $binID = $binID_row['GenBinID'];
        $checkExistence_query = "SELECT * FROM wastes WHERE WasteGenID = '$binID' LIMIT 1";
        if (mysqli_num_rows($getLevel = mysqli_query($conn, $checkExistence_query)) > 0){
            while ($level_row = mysqli_fetch_assoc($getLevel)) {
                $updated_level = $level_row['level'] + ($percent_level - $level_row['level']);
            }
            $set_level_query = "UPDATE wastes SET level = $updated_level WHERE WasteGenID = '$binID'";
        } else {
            $set_level_query = "INSERT INTO wastes (WasteGenID, level) VALUES ($binID, $percent_level)";
            $updated_level = $percent_level;
        }
        mysqli_query($conn, $set_level_query);

        echo json_encode($updated_level);
    }

?>