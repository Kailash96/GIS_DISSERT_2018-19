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

           .fillslotbox{
               border:1px solid black;
           }

           .timeline{
               display:flex;
               flex-direction:row;
               width:100%;
           }

           .timeline div{
               width:20%;
               text-align:center;
               border-left:1px solid black;
           }

           .schedule_table td{
               border-right:1px solid black;
               border-left:1px solid black;
               border-bottom:1px solid black;
           }

           .duration_holder{
                display:flex;
                flex-direction:row;
                cursor:pointer;
                height:50px;
           }

           .duration_holder div:hover{
               background-color:#00A1E7;
           }

           .duration_holder div{
               border-left:1px solid black;
               box-sizing:border-box;
               padding:2px;
               background-color:#74FFA6;
           }

        </style>
        <script type="text/javascript">
            function draw_schedule_box(){
                var draw = new XMLHttpRequest();
                draw.onreadystatechange = function(){
                    if (this.readyState == 4 && this.status == 200) {
                        var schedule_box = JSON.parse(this.responseText);
                        document.getElementById("schedule_box").innerHTML = schedule_box;
                    }
                }
                draw.open("POST", "schedule_box.php", true);
                draw.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                draw.send();
            }

            function select_slot(slot_zone){
                console.log(slot_zone);
                document.getElementById("zone").value = slot_zone;
            }

            function save_schedule(day, zone, route, truck, duration){
                var save = new XMLHttpRequest();
                save.onreadystatechange = function(){
                    if (this.readyState == 4 && this.status == 200) {
                        var success = JSON.parse(this.responseText);
                        console.log(success);
                    }
                }
                save.open("POST", "save_schedule.php", true);
                save.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                save.send("day=" + day + "&zone=" + zone + "&route=" + route + "&truck=" + truck + "&duration=" + duration);
            }
        </script>
    </head>
    <body onload="draw_schedule_box()">
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
                        
                        <!-- SCHEDULE BOX -->
                        <div id="schedule_box"></div>

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
            <select id="duration">
                <option value="1">1hr</option>
                <option value="2">2hrs</option>
                <option value="3">3hrs</option>
                <option value="4">4hrs</option>
                <option value="5">5hrs</option>
            </select>
            <input type="button" value="Submit" onclick="save_schedule(day.value, zone.value, route.value, truck.value, duration.value)" />
        </div>

    </body>
</html>