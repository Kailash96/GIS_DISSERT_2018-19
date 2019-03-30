<!DOCTYPE html>
<html>
    <head>
        <?php include("../../../../../config/db_connect.php") ?>
        <link rel="stylesheet" href="../../../css_files/style.css" />
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <style>
            #schedule_selected{
                background-color:#DCDCDC;
                border-left:4px solid #009DC4;
            }

            *{
                box-sizing:border-box;
            }

            /* WEEK CALENDAR CLASSES */
            .calendar_week_view_banner{
                display:grid;
                padding:10px;
                grid-template-columns:50px 159px 159px 159px 159px 159px 159px;
                grid-gap:2px;
                width:1050px;
            }

            .calendar_week_view_banner > div{
                text-align:center;
                padding:8px 0;
                border-radius:4px;
            }

            .calendar_week_view_banner > div h2{
                margin:0;
            }

            .calendar_week_view_banner > div:not(:first-child):hover{
                background-color:#D8D8D8;
                cursor:pointer;
            }

            .calendar_week_view{
                height:570px;
                overflow-y:auto;
                white-space:wrap;
                text-overflow:hidden;
                display:grid;
                padding:10px;
                grid-template-columns:50px 159px 159px 159px 159px 159px 159px;
                grid-gap:2px;
                width:1050px;
            }

            .calendar_week_view > div{
                height:116px;
                border-radius:2px;
                background-color:default;
                border:1px solid black;
            }
            
            .truck_slot{
                margin:4px;
                padding:4px;
                background-color:#0082D6;
                border-radius:2px;
                color:white;
                box-shadow:0 0 2px black;
                cursor:pointer;
            }

            /* DAY CALENDAR CLASSES */
            .day_calendar_banner{
                display:grid;
                overflow:hidden;
                overflow-x:auto;
            }

            ::-webkit-scrollbar{
                display:none;
            }

            .day_calendar_banner > div{
                border-left:1px solid black;
                height:20px;
                font-size:14px;
                text-align:left;
                padding-left:4px;
            }

            .day_calendar_view{
                display:grid;
                padding:10px 10px;
                width:1085px;
            }

            .calendar_day_time{
                display:grid;
                overflow:hidden;
                overflow-x:auto;
                padding:0 10px 0 10px;
            }

            .calendar_day_time > div {
                border:1px solid black;
                border-right:0;
                border-left:0;
                height:22px;
                font-size:14px;
                margin:0 0 2px 0;
            }

            .navigator_banner{
                padding:20px;
                text-align:left;
            }

            .navigator_banner > b{
                font-size:22px;
                padding:0 12px 4px 12px;
                border-radius:3px;
                cursor:pointer;
            }

            .navigator_banner > b:hover{
                background-color:#0082D6;
                color:white;
                box-shadow:0 0 1px black;
            }

            #week_calendar_container{
                /* display:none; */
            }

            #calendar_panel{
                display:none;
            }

            .calendar_panel{
                position:fixed;
                top:300px;
                background-color:white;
                padding:10px;
                border:1px solid black;
                left:550px;
                width:400px;
            }

        </style>
        <script type="text/javascript">
            function setDate(){
                var dayArray = [0, 0, 0, 0, 0, 0];
                var months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
                var dt = new Date();
                var crr_day = dt.getDay() - 1;
                var flag = 0;
                var count;
                var fullFormatDate = [0, 0, 0, 0, 0, 0];

                if (crr_day >= 0) {
                    for (var i = 0; i < dayArray.length; i++) {
                        if (crr_day == i) {
                            dayArray[i] = dt.getDate();
                            fullFormatDate[i] = dt.getDate() + " " + months[dt.getMonth()] + " " + dt.getFullYear();
                            flag = i;
                            break;
                        }
                    }
                } else {
                    flag = crr_day;
                }
                

                count = flag;
                for (var j = 0; j < dayArray.length; j++) {
                    if (j < flag) {
                        var thedate = new Date(dt.getTime() - (count * 24 * 60 * 60 * 1000));
                        dayArray[j] = thedate.getDate();
                        fullFormatDate[j] = thedate.getDate() + " " + thedate.getMonth() + " " + thedate.getFullYear();
                        count --;
                    }
                    if (flag < 0) {
                        var thedate = new Date(dt.getTime() + ((count + 2) * 24 * 60 * 60 * 1000));
                        dayArray[j] = thedate.getDate();
                        fullFormatDate[j] = thedate.getDate() + " " + thedate.getMonth() + " " + thedate.getFullYear();
                        count++;
                    } else if (j > flag) {
                        count ++;
                        var thedate = new Date(dt.getTime() + (count * 24 * 60 * 60 * 1000));
                        dayArray[j] = thedate.getDate();
                        fullFormatDate[j] = thedate.getDate() + " " + thedate.getMonth() + " " + thedate.getFullYear();
                    }
                }

                // SET THE DATE UNDER DAY
                for (var dy = 0; dy < dayArray.length; dy++) {
                    var today = dayArray[dy];
                    if (today == dt.getDate()) {
                        document.getElementById("dy_" + dy).innerHTML = "<span style='padding:0 12px 1px 12px;border-radius:2px;box-shadow:0 0 1px black;border-bottom:4px solid #0082D6;'>" + today + "</span>";
                    } else {
                        document.getElementById("dy_" + dy).innerHTML = today;
                    }
                    document.getElementById("dy_date_" + dy).value = fullFormatDate[dy];
                }

                var getMonthYear = months[dt.getMonth()] + " " + dt.getFullYear();
                var prefixes = ['Week 01', 'Week 02', 'Week 03', 'Week 04', 'Week 05'];
                var week = " " + prefixes[Math.floor(dt.getDate() / 7)];
                document.getElementById("week_view_top_month").innerHTML = "<h2 style='margin:20px 100px 0 0;display:inline-block;'>" + getMonthYear + "</h2>" + week;

            }

            function day_view(date_format, day){

                $("#week_calendar_container").fadeOut(100);
                var getDayCalendar = new XMLHttpRequest();
                getDayCalendar.onreadystatechange = function(){
                    if (this.readyState == 4 && this.status == 200) {
                        var data = JSON.parse(this.responseText);
                        document.getElementById("day_calendar_container").innerHTML = data;
                        document.getElementById("day_display").innerHTML = day;
                    }
                }
                getDayCalendar.open("POST", "day_calendar_view.php", true);
                getDayCalendar.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                getDayCalendar.send("day_date=" + date_format);

            }

            function week_view(){
                $("#week_calendar_container").show();
                document.getElementById("day_calendar_container").innerHTML = "";
            }

            $(document).ready(function(){
                $('#one').scroll(function(){
                    var length = $(this).scrollTop();
                    $('#two').scrollTop(length);
                });

                $('#two').scroll(function(){
                    var length = $(this).scrollTop();
                    $('#one').scrollTop(length);
                });

                $('#three').scroll(function(){
                    var length = $(this).scrollLeft();
                    $('#four').scrollLeft(length);
                });

                $('#four').scroll(function(){
                    var length = $(this).scrollLeft();
                    $('#three').scrollLeft(length);
                });
            });

            function calendarPanel(slotID){

                document.getElementById("calendar_panel").style.display = "block";
                var getData = new XMLHttpRequest();
                getData.onreadystatechange = function(){
                    if (this.readyState == 4 && this.status == 200){
                        var data=JSON.parse(this.responseText);
                        document.getElementById("plateNumber").innerHTML = "Plate Number: " + data[0];
                        document.getElementById("total_waste").innerHTML = "Total Waste: " + data[1] + " kg";
                        document.getElementById("nOfHouses").innerHTML = "Number of houses: " + data[2];
                        document.getElementById("trips").innerHTML = "Number of Trips: " + data[3];
                    }
                }
                getData.open("POST", "calendar_panel_data.php", true);
                getData.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                getData.send("slotID=" + slotID);

            }

            function closePanel(){
                document.getElementById("calendar_panel").style.display = "none";
            }
        </script>
    </head>
    <body onload="setDate()">
        <?php include("left_side_nav_bar.html"); ?>
        <?php include("top-nav-bar.html"); ?>

        <!-- WEEK CALENDAR CONTAINER -->
        <div align="center" id="week_calendar_container">
            
            <div style="text-align:left;padding:2px 28px;">
                <span id="week_view_top_month" style="padding:0 24px"></span>
            </div>

            <!-- CALENDAR WEEK VIEW BANNER -->
            <div class="calendar_week_view_banner">
                <div><i class="fa fa-flag-o" style="margin-bottom:10px"></i><br/>zones</div>
                <input type="hidden" value="" id="dy_date_0" />
                <div onclick="day_view(dy_date_0.value, this.id)" id="Monday">Mon <h2 id="dy_0"></h2></div>
                <input type="hidden" value="" id="dy_date_1" />
                <div onclick="day_view(dy_date_1.value, this.id)" id="Tuesday">Tue <h2 id="dy_1"></h2></div>
                <input type="hidden" value="" id="dy_date_2" />
                <div onclick="day_view(dy_date_2.value, this.id)" id="Wednesday">Wed <h2 id="dy_2"></h2></div>
                <input type="hidden" value="" id="dy_date_3" />
                <div onclick="day_view(dy_date_3.value, this.id)" id="Thursday">Thurs <h2 id="dy_3"></h2></div>
                <input type="hidden" value="" id="dy_date_4" />
                <div onclick="day_view(dy_date_4.value, this.id)" id="Friday">Fri <h2 id="dy_4"></h2></div>
                <input type="hidden" value="" id="dy_date_5" />
                <div onclick="day_view(dy_date_5.value, this.id)" id="Saturday">Sat <h2 id="dy_5"></h2></div>
            </div>
            
            <!-- CALENDAR WEEK VIEW -->
            <div class="calendar_week_view">
                <?php
                    $calendar = "";
                    $fetch_zones_query = "SELECT * FROM tbl_zones WHERE regionID = 1";
                    if ($getZones = mysqli_query($conn, $fetch_zones_query)) {
                        while ($zones = mysqli_fetch_assoc($getZones)) {
                            $zoneID = $zones['zoneID'];

                            $calendar .= "
                                    <div style='border:0;'>
                                    <h3 style='margin-top:42px'>" . $zones['zoneID'] . "</h3>
                                    </div>
                                <div>
                            ";
                            
                            $fetch_truck_query = "SELECT * FROM tbl_schedule INNER JOIN tbl_trucks ON tbl_schedule.TruckID = tbl_trucks.PlateNumber WHERE tbl_schedule.Zone = $zoneID AND tbl_trucks.Collector = 'District Council'";
                            if ($zoning = mysqli_query($conn, $fetch_truck_query)) {
                                while ($truck = mysqli_fetch_assoc($zoning)) {
                                    if ($truck['CollectionDate'] == date('Y-m-d', strtotime("Monday"))) {
                                        $calendar .= "
                                            <div class='truck_slot' id='" . $zoneID . "_" . $truck['Day'] . "_" . $truck['TruckID'] . "' style='text-align:left' onclick='calendarPanel(this.id)'>
                                                <i class='fa fa-truck' style='color:white'></i> " . $truck['TruckID'] . "<br/>
                                                <span style='font-size:14px;color:white'>" . $truck['TimeStart'] . " - " . $truck['TimeEnd'] . "</span>
                                            </div>
                                        ";
                                    }
                                }
                            }

                            $calendar .= "</div>
                                <div>";
                                
                                if ($zoning = mysqli_query($conn, $fetch_truck_query)) {
                                    while ($truck = mysqli_fetch_assoc($zoning)) {
                                        if ($truck['CollectionDate'] == date('Y-m-d', strtotime("Tuesday"))) {
                                            $calendar .= "
                                                <div class='truck_slot' id='" . $zoneID . "_" . $truck['Day'] . "_" . $truck['TruckID'] . "' style='text-align:left' onclick='calendarPanel(this.id)'>
                                                    <i class='fa fa-truck' style='color:white'></i> " . $truck['TruckID'] . "<br/>
                                                    <span style='font-size:14px;color:white'>" . $truck['TimeStart'] . " - " . $truck['TimeEnd'] . "</span>
                                                </div>
                                            ";
                                        }
                                    }
                                }

                            $calendar .= "</div>
                                <div>";

                                if ($zoning = mysqli_query($conn, $fetch_truck_query)) {
                                    while ($truck = mysqli_fetch_assoc($zoning)) {
                                        if ($truck['CollectionDate'] == date('Y-m-d', strtotime("Wednesday"))) {
                                            $calendar .= "
                                                <div class='truck_slot' id='" . $zoneID . "_" . $truck['Day'] . "_" . $truck['TruckID'] . "' style='text-align:left' onclick='calendarPanel(this.id)'>
                                                    <i class='fa fa-truck' style='color:white'></i> " . $truck['TruckID'] . "<br/>
                                                    <span style='font-size:14px;color:white'>" . $truck['TimeStart'] . " - " . $truck['TimeEnd'] . "</span>
                                                </div>
                                            ";
                                        }
                                    }
                                }

                            $calendar .= "</div>
                                <div>";
                                
                                if ($zoning = mysqli_query($conn, $fetch_truck_query)) {
                                    while ($truck = mysqli_fetch_assoc($zoning)) {
                                        if ($truck['CollectionDate'] == date('Y-m-d', strtotime("Thursday"))) {
                                            $calendar .= "
                                                <div class='truck_slot' id='" . $zoneID . "_" . $truck['Day'] . "_" . $truck['TruckID'] . "' style='text-align:left' onclick='calendarPanel(this.id)'>
                                                    <i class='fa fa-truck' style='color:white'></i> " . $truck['TruckID'] . "<br/>
                                                    <span style='font-size:14px;color:white'>" . $truck['TimeStart'] . " - " . $truck['TimeEnd'] . "</span>
                                                </div>
                                            ";
                                        }
                                    }
                                }

                            $calendar .= "</div>
                                <div>";
                                
                                if ($zoning = mysqli_query($conn, $fetch_truck_query)) {
                                    while ($truck = mysqli_fetch_assoc($zoning)) {
                                        if ($truck['CollectionDate'] == date('Y-m-d', strtotime("Friday"))) {
                                            $calendar .= "
                                                <div class='truck_slot' id='" . $zoneID . "_" . $truck['Day'] . "_" . $truck['TruckID'] . "' style='text-align:left' onclick='calendarPanel(this.id)'>
                                                    <i class='fa fa-truck' style='color:white'></i> " . $truck['TruckID'] . "<br/>
                                                    <span style='font-size:14px;color:white'>" . $truck['TimeStart'] . " - " . $truck['TimeEnd'] . "</span>
                                                </div>
                                            ";
                                        }
                                    }
                                }

                            $calendar .= "</div>
                                <div>";

                                if ($zoning = mysqli_query($conn, $fetch_truck_query)) {
                                    while ($truck = mysqli_fetch_assoc($zoning)) {
                                        if ($truck['CollectionDate'] == date('Y-m-d', strtotime("Saturday"))) {
                                            $calendar .= "
                                                <div class='truck_slot' id='" . $zoneID . "_" . $truck['Day'] . "_" . $truck['TruckID'] . "' style='text-align:left' onclick='calendarPanel(this.id)'>
                                                    <i class='fa fa-truck' style='color:white'></i> " . $truck['TruckID'] . "<br/>
                                                    <span style='font-size:14px;color:white'>" . $truck['TimeStart'] . " - " . $truck['TimeEnd'] . "</span>
                                                </div>
                                            ";
                                        }
                                    }
                                }

                            $calendar .= "</div>
                            ";
                        }
                    }
                    echo $calendar;
                ?>
            </div>

        </div>

        <!-- DAY CALENDAR CONTAINER -->
        <div align="center" id="day_calendar_container"></div>

        <!-- panel -->
        <div class="calendar_panel" id="calendar_panel">
            <h3 align="right" style="margin:0;padding:0;cursor:pointer" onclick="closePanel()">x</h3>
            <h3 id="plateNumber"></h3>
            <h4 id="total_waste"></h4>
            <h4 id="nOfHouses"></h4>
            <h4 id="trips"></h4>
        </div>
    </body>
</html>