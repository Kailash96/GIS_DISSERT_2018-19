<!DOCTYPE html>
<html>
    <head>
        <?php include("../../../db_connect.php") ?>
        <link rel="stylesheet" href="../../css_files/style.css" />
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
                border:1px solid black;
                padding:10px;
                grid-template-columns:50px 159px 159px 159px 159px 159px 159px;
                grid-gap:2px;
                width:1050px;
            }

            .calendar_week_view_banner > div{
                text-align:center;
                cursor:pointer;
                padding:8px 0;
                border-radius:4px;
            }

            .calendar_week_view_banner > div h2{
                margin:0;
            }

            .calendar_week_view_banner > div:hover{
                background-color:#D8D8D8;
            }

            .calendar_week_view{
                height:570px;
                overflow-y:auto;
                white-space:wrap;
                text-overflow:hidden;
                display:grid;
                border:1px solid black;
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
                border:1px solid black;
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
        </style>
        <script type="text/javascript">
            function day_view(day){
                $("#week_calendar_container").fadeOut(100);
                var getDayCalendar = new XMLHttpRequest();
                getDayCalendar.onreadystatechange = function(){
                    if (this.readyState == 4 && this.status == 200) {
                        var data = JSON.parse(this.responseText);
                        document.getElementById("day_calendar_container").innerHTML = data;
                    }
                }
                getDayCalendar.open("POST", "day_calendar_view.php", true);
                getDayCalendar.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                getDayCalendar.send("day=" + day);
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

        </script>
    </head>
    <body>
        <?php include("left_side_nav_bar.html"); ?>
        <?php include("top-nav-bar.html"); ?>

        <!-- WEEK CALENDAR CONTAINER -->
        <div align="center" id="week_calendar_container">
            
            <div style="text-align:left;padding:2px 28px;">
                <h2>March 2019</h2>
            </div>

            <!-- CALENDAR WEEK VIEW BANNER -->
            <div class="calendar_week_view_banner">
                <div><i class="fa fa-flag-o" style="margin-bottom:10px"></i><br/>zones</div>
                <div onclick="day_view(this.id)" id="monday">Mon <h2>4</h2></div>
                <div onclick="day_view(this.id)" id="tueday">Tue <h2>5</h2></div>
                <div onclick="day_view(this.id)" id="wednesday">Wed <h2>6</h2></div>
                <div onclick="day_view(this.id)" id="thursday">Thurs <h2>7</h2></div>
                <div onclick="day_view(this.id)" id="friday">Fri <h2>8</h2></div>
                <div onclick="day_view(this.id)" id="saturday">Sat <h2>9</h2></div>
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
                                    if ($truck['Day'] == "Monday") {
                                        $calendar .= "
                                            <div class='truck_slot' style='text-align:left'>
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
                                        if ($truck['Day'] == "Tuesday") {
                                            $calendar .= "
                                                <div class='truck_slot' style='text-align:left'>
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
                                        if ($truck['Day'] == "Wednesday") {
                                            $calendar .= "
                                                <div class='truck_slot' style='text-align:left'>
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
                                        if ($truck['Day'] == "Thursday") {
                                            $calendar .= "
                                                <div class='truck_slot' style='text-align:left'>
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
                                        if ($truck['Day'] == "Friday") {
                                            $calendar .= "
                                                <div class='truck_slot' style='text-align:left'>
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
                                        if ($truck['Day'] == "Saturday") {
                                            $calendar .= "
                                                <div class='truck_slot' style='text-align:left'>
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

    </body>
</html>