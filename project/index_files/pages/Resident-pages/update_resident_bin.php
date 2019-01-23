<?php
    include("../../../db_connect.php");

    $userID = $_POST['user_id'];

    $data = "";
    $type_query = "SELECT DISTINCT Type FROM bins WHERE GeneratorID = '$userID'";
    if ($results = mysqli_query($conn, $type_query)) {
        while ($row = mysqli_fetch_assoc($results)) {
            $data .= "
                <div class='bins_box'>
                    <h3 style='margin:0;text-transform:capitalize;'>" . $row['Type'] . "</h3>";

                $type = $row['Type'];
                $capacity_query = "SELECT DISTINCT Capacity FROM bins WHERE GeneratorID = '$userID' AND Type = '$type'";

                if ($capacity_results = mysqli_query($conn, $capacity_query)) {
                    while ($capacity_row = mysqli_fetch_assoc($capacity_results)) {
                        $bin_capacity = $capacity_row['Capacity'];

                        $data .= "
                            <div class='bins_box' style='font-size:14px;'>
                                Capacity: " . $capacity_row['Capacity'] . " Liters<br/><br/>";
                                $numberofbins_query = "SELECT NoOfBins FROM bins WHERE GeneratorID = '$userID' AND Type = '$type' AND Capacity = $bin_capacity";
                                if ($numOfBin_results = mysqli_query($conn, $numberofbins_query)) {
                                    while ($numOfBins_row = mysqli_fetch_assoc($numOfBin_results)) {
                                        $numberOfBins = $numOfBins_row['NoOfBins'];

                                        for ($i = 0; $i < $numberOfBins; $i++) {
                                            $data .= "
                                                <div style='display:inline-block;width:300px'>
                                                    <i class='fa fa-trash-o' style='font-size:100px;'></i>
                                                    <div style='height:20px;border:1px solid black;width:100%'>
                                                        <div style='background-color:#002246;height:20px;' id='" . $type . $bin_capacity . "_" . $i . "'></div>
                                                    </div>
                                                </div>
                                            ";
                                        }

                                        $data .= "
                                            <br/><br/>
                                            <form onsubmit='levelup(theuserid.value, thetype.value, thecapacity.value, thenum.value, level.value)'>
                                                <input type='hidden' value='" . $userID . "' id='theuserid' />
                                                <input type='hidden' value='" . $type . "' id='thetype' />
                                                <input type='hidden' value='" . $bin_capacity . "' id='thecapacity' />
                                                <input type='hidden' value='" . $numberOfBins . "' id='thenum' />
                                                <input type='text' placeholder='Waste Level in Liters' id='level' required />
                                                <input type='submit' value='Submit' />
                                            </form>
                                            <div id='" . $type . $bin_capacity . "'></div>
                                        ";
                                    }
                                }
                        $data .= "
                            </div>
                        ";
                    }
                }

            $data .= "
                </div>
            ";
        }
    }

    echo json_encode($data);
?>