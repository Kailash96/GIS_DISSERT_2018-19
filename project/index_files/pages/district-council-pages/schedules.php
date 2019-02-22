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

            .content_box{
                box-shadow:0 0 3px black;
                margin:4px 0;
                border-radius:2px;
                display:flex;
                flex-direction:row;
                flex-wrap:wrap;
                padding:4px;
            }

            .content_box table{
                box-shadow:0 0 2px black;
                border-radius:2px;
                margin:6px 4px;
                display:block;
                width:49.2%;
            }

            .content_box table td{
                padding:4px 8px;
            }
        </style>
    </head>
    <body>
        <?php include("left_side_nav_bar.html"); ?>
        <?php include("top-nav-bar.html"); ?>

        <div style="padding:20px;">
            <h2>Scheduling</h2>
            <table border="0" width="100%">
                <?php
                    $days = array("Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday");
                    $data = "";
                    for ($d = 0; $d < sizeof($days); $d++) {
                        $crr_day = $days[$d];
                        $data .= "
                            <tr>
                                <td style='padding:10px 0;'>
                                    " . $crr_day . "
                                    <div class='content_box'>
                                    ";

                                    $crr_date = date("Y-m-d");
                                    $zones_query = "SELECT DISTINCT zoneID FROM tbl_schedule WHERE Day = '$crr_day' AND sDate >= '$crr_date'";

                                    if ($rslt = mysqli_query($conn, $zones_query)) {
                                        while ($zone = mysqli_fetch_assoc($rslt)) {

                                            $data .= "
                                                <table border='0' style='font-size:13px'>
                                            ";
                                            $zone_id = $zone['zoneID'];
                                            $schedule_query = "SELECT * FROM tbl_schedule WHERE Day = '$crr_day' AND sDate >= '$crr_date' AND zoneID = $zone_id";

                                            if ($schedule_rslt = mysqli_query($conn, $schedule_query)) {
                                                while ($schedule = mysqli_fetch_assoc($schedule_rslt)) {
                                                    $data .= "
                                                        <tr>
                                                            <td width='16.7%'>Truck<br/><b style='font-size:14px'>" . $schedule['truckID'] . "</b></td>
                                                            <td width='16.7%'>Date<br/><b style='font-size:14px'>" . $schedule['sDate'] . "</b></td>
                                                            <td width='16.7%' align='right' rowspan='2'>Zone<br/><b style='font-size:28px'>" . $schedule['zoneID'] . "</b></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Route<br/><b style='font-size:14px'>" . $schedule['routeID'] . "</b></td>
                                                            <td width='16.7%'>Time<br/><b style='font-size:14px'>" . $schedule['sTime'] . "</b></td>
                                                        </tr>
                                                        <tr><td colspan='3'><hr></td></tr>
                                                    ";
                                                }
                                            }

                                            $data .= "
                                                </table>
                                            ";

                                        }
                                    }

                                    $data .= "
                                    </div>
                                </td>
                            </tr>
                        ";
                    }
                    $data .= "</table>";
                    echo $data;
                ?>
            </table>
        </div>

    </body>
</html>