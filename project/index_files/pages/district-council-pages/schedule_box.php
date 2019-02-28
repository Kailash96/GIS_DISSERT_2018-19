<?php
    include("../../../db_connect.php");

    $schedule_box = '
    <table border="0" cellspacing="0" width="100%" class="schedule_table">
        <tr>
            <td style="border-bottom:1px solid black;border-right:0;border-left:0;"></td>
            <td style="border-top:1px solid black;border-right:0" align="center" width="48%"><b>Shift A</b></td>
            <td style="border-top:1px solid black" align="center" width="48%"><b>Shift B</b></td>
        </tr>
        <tr>
            <td width="4%" style="border-right:0">Zones</td>
            <td style="border-right:0">
                <div class="timeline">
                    <div style="border-left:0">5:00</div>
                    <div>6:00</div>
                    <div>7:00</div>
                    <div>8:00</div>
                    <div>9:00</div>
                </div>
            </td>
            <td>
                <div class="timeline">
                    <div style="border-left:0">10:00</div>
                    <div>11:00</div>
                    <div>12:00</div>
                    <div>13:00</div>
                    <div>14:00</div>
                </div>
            </td>
        </tr>
        ';
        $zones = "";

        $getZones = "SELECT * FROM tbl_zones WHERE regionID = 1";
        if ($myResults = mysqli_query($conn, $getZones)) {
            while ($myZones = mysqli_fetch_assoc($myResults)){
                $zoneID = $myZones['zoneID'];
                $zones .= "
                    <tr>
                        <td align='center' style='border-right:0'>" . $zoneID . "</td>
                        <td colspan='2'>
                            <div class='duration_holder' id='schedule_bar'>";
                                
                                $getScheduleQuery = "SELECT * FROM tbl_schedule WHERE zoneID = $zoneID ORDER BY sID ASC";
                                if (mysqli_num_rows($rslt = mysqli_query($conn, $getScheduleQuery)) > 0) {
                                    $total_width = 0;
                                    while ($rw = mysqli_fetch_assoc($rslt)) {
                                        $width = $rw['Duration'] * 10;
                                        $total_width += $width;
                                        $zones .= "
                                            <div style='width:" . $width . "%;background-color:#0095D1;color:white;border-left:1px solid black;border-top:1px solid black;border-bottom:1px solid black;'>" . $rw['truckID'] . "</div>
                                        ";
                                    }
                                    if ($total_width <= 100) {
                                        $empty_slot_width = 100 - $total_width;
                                        $zones .= "<div id='" . $zoneID . "' onclick='select_slot(this.id)' style='width:" . $empty_slot_width . "%'>Empty Slot</div>";
                                    }
                                } else {
                                    $zones .= "<div id='" . $zoneID . "' onclick='select_slot(this.id)' style='border:0;width:100%'>Empty Slot</div>";
                                }
                            
                $zones .= "</div>
                        </td>
                    </tr>
                ";
            }
        }

        $schedule_box .= $zones;

    $schedule_box .= "</table>";

    echo json_encode($schedule_box);
?>