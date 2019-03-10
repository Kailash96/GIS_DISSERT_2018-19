<?php

    include("../../../db_connect.php");

    $day_date = $_POST['day_date'];
    $day_date = explode(" ", $day_date);
    $selectedDate = $day_date[2] . "-" . $day_date[1] . "-" . $day_date[0];

    $months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];

    $data = "";

    // DAY CALENDAR VIEW BANNER
    $data .= '
        <div class="navigator_banner">
            <span style="border:1px solid black;cursor:pointer;padding:8px 14px;border-radius:3px" onclick="week_view()">< Back</span>
            <h2 style="display:inline-block;width:300px;text-align:center;padding:0;margin:0"><i class="fa fa-calendar"></i> ' . $day_date[0] . " " . $months[$day_date[1]] . " " . $day_date[2] . '</h2>
            <span style="box-shadow:0 0 2px black;padding:8px 14px;border-radius:3px;background-color:#0082D6;color:white;margin-right:50px;" id="day_display"></span>
            <b onclick="changeDay(this.id)" id="previous"><</b>
            <b onclick="changeDay(this.id)" id="next">></b>
        </div>
        <div style="grid-gap:10px;padding:10px 10px;display:grid;grid-template-columns:50px 1000px;width:1085px;">
        <div style="font-size:14px">
            zones
        </div>
        <div>

            <!-- DAY CALENDAR BANNER -->
            <div class="day_calendar_banner" id="four" style="grid-template-columns:100px 100px 100px 100px 100px 100px 100px 100px 100px 100px 100px 100px 100px 100px 100px 100px;">
                <div>5am</div>
                <div>6am</div>
                <div>7am</div>
                <div>8am</div>
                <div>9am</div>
                <div>10am</div>
                <div>11am</div>
                <div>12pm</div>
                <div>1pm</div>
                <div>2pm</div>
                <div>3pm</div>
                <div>4pm</div>
                <div>5pm</div>
                <div>6pm</div>
                <div>7pm</div>
                <div style="border-right:1px solid black">8pm</div>
            </div>

        </div>

        </div>
    ';


    // DAY CALENDAR VIEW
    $data .= '
        <div class="day_calendar_view" style="grid-template-columns:50px auto">
        <div style="height:540px;overflow:hidden;overflow-y:auto;" id="one">
    ';
        $day_calendar_zone = "";
        $getZones = "SELECT * FROM tbl_zones WHERE regionID = 1";
        if ($zoning_result = mysqli_query($conn, $getZones)) {
            while ($zoning = mysqli_fetch_assoc($zoning_result)) {
                $day_calendar_zone .= "
                    <div style='border-radius:2px;border:1px solid black;height:22px;font-size:14px;margin:0 0 2px 0'>" . $zoning['zoneID'] . "</div>
                ";
            }
        }
        $data .= $day_calendar_zone;

    $data .= '
        </div>
        <div style="overflow:hidden;height:540px;overflow-y:auto;" id="two">
    ';
        // CALENDAR DAY TIME
    $data .= '
        <div class="calendar_day_time" id="three" style="grid-template-columns:100px 100px 100px 100px 100px 100px 100px 100px 100px 100px 100px 100px 100px 100px 100px 100px">
    ';
                $inside_zone = "";
                
                if ($zones_result = mysqli_query($conn, $getZones)) {
                    while ($innerzone = mysqli_fetch_assoc($zones_result)) {
                        
                        $zone_id = $innerzone['zoneID'];
                        $t = array("", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "");
                        $truckData = array("", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "");
                        
                        $getSchedule = "SELECT * FROM tbl_schedule INNER JOIN tbl_trucks ON tbl_schedule.TruckID = tbl_trucks.PlateNumber WHERE Zone = $zone_id AND tbl_schedule.CollectionDate = '$selectedDate' AND Collector = 'District Council'";
                        
                        if ($schedule_result = mysqli_query($conn, $getSchedule)) {
                            while ($schedule_row = mysqli_fetch_assoc($schedule_result)){

                                $start_time = (int)$schedule_row['TimeStart'];
                                $end_time = (int) $schedule_row['TimeEnd'];
                                $duration = $end_time - $start_time;

                                $truckData[$start_time - 5] = $schedule_row['TruckID'];

                                for ($i = $start_time; $i < $end_time; $i++) {
                                    if ($duration > 3) {
                                        $t[$i - 5] = "background-color:#FF3D3D;color:white;padding:1px 10px;text-align:left";
                                    } else if ($duration > 2){
                                        $t[$i - 5] = "background-color:#FF6400;color:white;padding:1px 10px:text-align:left";
                                    } else if ($duration > 1) {
                                        $t[$i - 5] = "background-color:#0046FF;color:white;padding:1px 10px;text-align:left";
                                    } else {
                                        $t[$i - 5] = "background-color:#009BFF;color:white;padding:1px 10px;text-align:left";
                                    }
                                    
                                }

                            }
                        }

                        $inside_zone .= "
                            <div style='border-left:1px solid black;" . $t[0] . "'>" . $truckData[0] . "</div>
                            <div style='" . $t[1] . "'>" . $truckData[1] . "</div>
                            <div style='" . $t[2] . "'>" . $truckData[2] . "</div>
                            <div style='" . $t[3] . "'>" . $truckData[3] . "</div>
                            <div style='" . $t[4] . "'>" . $truckData[4] . "</div>
                            <div style='" . $t[5] . "'>" . $truckData[5] . "</div>
                            <div style='" . $t[6] . "'>" . $truckData[6] . "</div>
                            <div style='" . $t[7] . "'>" . $truckData[7] . "</div>
                            <div style='" . $t[8] . "'>" . $truckData[8] . "</div>
                            <div style='" . $t[9] . "'>" . $truckData[9] . "</div>
                            <div style='" . $t[10] . "'>" . $truckData[10] . "</div>
                            <div style='" . $t[11] . "'>" . $truckData[11] . "</div>
                            <div style='" . $t[12] . "'>" . $truckData[12] . "</div>
                            <div style='" . $t[13] . "'>" . $truckData[13] . "</div>
                            <div style='" . $t[14] . "'>" . $truckData[14] . "</div>
                            <div style='border-right:1px solid black;" . $t[15] . "'>" . $truckData[15] . "</div>
                        ";
                        
                    }
                }

                $data .= $inside_zone;
                
        $data .= '
            </div>
            </div>
            </div>
        ';

    echo json_encode($data);

?>