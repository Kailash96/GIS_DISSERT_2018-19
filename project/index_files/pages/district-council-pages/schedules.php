<!DOCTYPE html>
<html>
    <head>
        <?php include("../../../db_connect.php") ?>
        <link rel="stylesheet" href="../../css_files/style.css" />
        <style>
            #schedule_selected{
                background-color:#DCDCDC;
                border-left:4px solid #009DC4;
            }
        </style>
    </head>
    <body>
        <?php include("left_side_nav_bar.html"); ?>
        <?php include("top-nav-bar.html"); ?>

        <div style="padding:40px;">
            <table border="1" width="100%" cellspacing="0">
                <tr>
                    <td width="10%">zones</td>
                    <td width="15%">Monday</td>
                    <td width="15%">Tuesday</td>
                    <td width="15%">Wednesday</td>
                    <td width="15%">Thursday</td>
                    <td width="15%">Friday</td>
                    <td width="15%">Saturday</td>
                </tr>
                <?php
                    $zoning_query = "SELECT * FROM tbl_zones WHERE regionID = 1";
                    $data = "";
                    $days = array("Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday");
                    if ($results = mysqli_query($conn, $zoning_query)){
                        while ($zone = mysqli_fetch_assoc($results)) {
                            $zoneID = $zone['zoneID'];
                            $data .= "<tr>
                                <td>" . $zoneID . "</td>";

                                for ($d = 0; $d < sizeof($days); $d++) {
                                    $crr_day = $days[$d];
                                    $schedule_query = "SELECT * FROM tbl_schedule WHERE zoneID = $zoneID AND Day = '$crr_day' ORDER BY sDate ASC";
                                    if (($schedule_result = mysqli_query($conn, $schedule_query)) && (mysqli_num_rows(mysqli_query($conn, $schedule_query)) > 0)) {
                                        $data .= "
                                            <td>
                                                <table border='1'>";
                                                    while ($schedule = mysqli_fetch_assoc($schedule_query)) {
                                                        $data .= "
                                                            <tr>
                                                                <td>" . $schedule['truckID'] . "</td>
                                                            </tr>
                                                        ";
                                                    }
                                        $data .= "
                                                </table>
                                            </td>
                                        ";
                                    } else {
                                        $data .= "
                                            <td>Available Slot</td>
                                        ";
                                    }

                                }
                                
                                $data .= "</tr>";
                        }
                    }
                    echo $data;
                ?>
            </table>
        </div>

    </body>
</html>