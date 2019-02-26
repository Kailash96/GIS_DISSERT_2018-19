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
           
           .tr td{
                width:16.7%;
                text-align:center;
           }

           .tr td h4{
               margin:0;
               border:1px solid black;
               padding:8px 0;
               border-radius:3px 3px 0 0;
               cursor:pointer;
           }

           .tr td h4:hover{
               background-color:#DCDCDC;
           }

           .slots{
               cursor:pointer;
               background-color:#45FF66;
           }

           .slots:hover{
               background-color:#00B9E3;
           }

           .fillslotbox{
               border:1px solid black;
           }

        </style>
        <script type="text/javascript">
            function schedule(slot){
                var data = slot.split("_");
                document.getElementById("zone").value = data[2];
                document.getElementById("shift").value = data[1];
                console.log(slot);
                console.log(data[0]);
                console.log(data[1]);
                console.log(data[2]);
            }

            function save_schedule(day, zone, shift, route, truck){
                var save = new XMLHttpRequest();
                save.onreadystatechange = function () {
                    if (this.readyState == 4 && this.status == 200) {
                        var response = JSON.parse(this.responseText);
                        if (response == true){
                            location.reload();
                        }
                    }
                }
                save.open("POST", "save_schedule.php", true);
                save.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                save.send("day=" + day + "&zone=" + zone + "&shift=" + shift + "&route=" + route + "&truck=" + truck);
            }
        </script>
    </head>
    <body>
        <?php include("left_side_nav_bar.html"); ?>
        <?php include("top-nav-bar.html"); ?>

        <div style="padding:20px;">
            
            <table border="0" width="100%" cellspacing="0">
                <tr class="tr">
                    <td><h4>Monday</h4></td>
                    <td><h4>Tuesday</h4></td>
                    <td><h4>Wednesday</h4></td>
                    <td><h4>Thursday</h4></td>
                    <td><h4>Friday</h4></td>
                    <td><h4>Saturday</h4></td>
                </tr>
                <tr>
                    <td colspan="6">
                        <br/>
                        <table border="1" cellspacing="0" width="100%">
                            <tr>
                                <td></td>
                                <td colspan="2" align="center">Morning</td>
                                <td colspan="2" align="center">Afternoon</td>
                            </tr>
                            <tr>
                                <td width="4%">Zones</td>
                                <td align="center" width='24%'><b>Shift A</b></td>
                                <td align="center" width='24%'><b>Shift B</b></td>
                                <td align="center" width='24%'><b>Shift C</b></td>
                                <td align="center" width='24%'><b>Shift D</b></td>
                            </tr>
                            <?php
                                $zones = "";

                                $getZones = "SELECT tbl_zones.zoneID AS zoneID, tbl_schedule.Day AS day, tbl_schedule.truckID AS truckID, tbl_schedule.Shift_A AS shift_a, tbl_schedule.Shift_B AS shift_b, tbl_schedule.Shift_C AS shift_c, tbl_schedule.Shift_D AS shift_d FROM tbl_zones LEFT JOIN tbl_schedule ON tbl_zones.zoneID = tbl_schedule.zoneID WHERE regionID = 1 ORDER BY tbl_zones.zoneID ASC"; // region ID should be changed according to region
                                if ($myResults = mysqli_query($conn, $getZones)) {
                                    while ($myZones = mysqli_fetch_assoc($myResults)){
                                        $zones .= "
                                            <tr>
                                                <td align='center'>" . $myZones['zoneID'] . "</td>
                                                <td>";
                                                if ($myZones['shift_a'] > 0) {
                                                    $zones .= $myZones['truckID'];
                                                } else {
                                                    $zones .= "
                                                        <div onclick='schedule(this.id)' id='M_A_" . $myZones['zoneID'] . "' class='slots'>slot 1</div>
                                                    ";
                                                }
                                        $zones .= "
                                                </td>
                                                <td>";
                                                if ($myZones['shift_b'] > 0) {
                                                    $zones .= $myZones['truckID'];
                                                } else {
                                                    $zones .= "<div onclick='schedule(this.id)' id='M_B_" . $myZones['zoneID'] . "' class='slots'>slot 2</div>";
                                                }
                                        $zones .= "
                                                </td>
                                                <td id='A_sft_B_z_" . $myZones['zoneID'] . "'>";
                                                if ($myZones['shift_c'] > 0) {
                                                    $zones .= $myZones['truckID'];
                                                } else {
                                                    $zones .= "<div onclick='schedule(this.id)' id='A_C_" . $myZones['zoneID'] . "' class='slots'>slot 3</div>";
                                                }
                                        $zones .= "
                                                </td>
                                                <td id='A_sft_B_z_" . $myZones['zoneID'] . "'>";
                                                if ($myZones['shift_d'] > 0) {
                                                    $zones .= $myZones['truckID'];
                                                } else {
                                                    $zones .= "<div onclick='schedule(this.id)' id='A_D_" . $myZones['zoneID'] . "' class='slots'>slot 4</div>";
                                                }
                                        $zones .= "
                                                </td>
                                            </tr>
                                        ";
                                    }
                                }

                                echo $zones;
                            ?>
                        </table>

                    </td>
                </tr>
            </table>

        </div>

        <!-- fill slot box -->
        <div class="fillslotbox">
            Day: Monday<br/><br/>
            Slot Selected: Morning Shift A<br/>
            <input type="hidden" id="day" value="Monday" /> <!-- temp -->
            <input type="hidden" id="zone" value="" />
            <input type="hidden" id="shift" value="" />
            <input type="hidden" id="route" value="1" />
            <select id='truck'>
                <?php
                    $data = "";
                    $getTrucksQuery = "SELECT * FROM tbl_trucks";
                    if ($getTrucks = mysqli_query($conn, $getTrucksQuery)) {
                        while ($trucks = mysqli_fetch_assoc($getTrucks)) {
                            $data .= "<option value='" . $trucks['PlateNumber'] . "'>" . $trucks['PlateNumber'] . "</option>";
                        }
                    }
                    echo $data;
                ?>
            </select>
            <input type="button" value="Submit" onclick="save_schedule(day.value, zone.value, shift.value, route.value, truck.value)" />
        </div>

    </body>
</html>