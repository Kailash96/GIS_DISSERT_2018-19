<!DOCTYPE html>
<html>
    <head>
        <?php include("../../../db_connect.php") ?>
        <link rel="stylesheet" href="../../css_files/style.css" />
        <script src="../../js_files/jquery_lib.js"></script>
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
                border:1px solid black;
                text-align:center;
                cursor:pointer;
            }

            .calendar_week_view_banner > div:hover{
                background-color:#0082D6;
                color:white;
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

            #week_calendar_container{
                display:none; /* temporary */
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
                height:22px;
                font-size:14px;
                margin:0 0 1px 0;
            }
        
        </style>
        <script type="text/javascript">
            function day_view(day){
                $("#week_calendar_container").fadeOut(100);
            }

            $(document).ready(function(){
                $('#one').scroll(function(){
                    var length = $(this).scrollTop();
                    $('#two').scrollTop(length);
                });
            });

            $(document).ready(function(){
                $('#two').scroll(function(){
                    var length = $(this).scrollTop();
                    $('#one').scrollTop(length);
                });
            });

            $(document).ready(function(){
                $('#three').scroll(function(){
                    var length = $(this).scrollLeft();
                    $('#four').scrollLeft(length);
                });
            });

            $(document).ready(function(){
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

            <!-- CALENDAR WEEK VIEW BANNER -->
            <div class="calendar_week_view_banner">
                <div>zones</div>
                <div onclick="day_view(this.id)" id="monday">Mon</div>
                <div onclick="day_view(this.id)" id="tueday">Tue</div>
                <div onclick="day_view(this.id)" id="wednesday">Wed</div>
                <div onclick="day_view(this.id)" id="thursday">Thurs</div>
                <div onclick="day_view(this.id)" id="friday">Fri</div>
                <div onclick="day_view(this.id)" id="saturday">Sat</div>
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
                                <div style='border:0;background-color:#A0A0A0;color:white;height:40px;padding:11px 0'>" . $zones['zoneID'] . "</div>
                                <div>
                            ";
                            
                            $fetch_truck_query = "SELECT * FROM tbl_schedule INNER JOIN tbl_trucks ON tbl_schedule.TruckID = tbl_trucks.PlateNumber WHERE tbl_schedule.Zone = $zoneID AND tbl_trucks.Collector = 'District Council'";
                            if ($zoning = mysqli_query($conn, $fetch_truck_query)) {
                                while ($truck = mysqli_fetch_assoc($zoning)) {
                                    if ($truck['Day'] == "Monday") {
                                        $calendar .= "
                                            <div class='truck_slot' style='text-align:left'>
                                                " . $truck['TruckID'] . "<br/>
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
                                                    " . $truck['TruckID'] . "<br/>
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
                                                    " . $truck['TruckID'] . "<br/>
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
                                                    " . $truck['TruckID'] . "<br/>
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
                                                    " . $truck['TruckID'] . "<br/>
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
                                                    " . $truck['TruckID'] . "<br/>
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
        <div align="center" id="day_calendar_container">

            <!-- DAY CALENDAR VIEW BANNER -->
            <div style="grid-gap:10px;padding:10px 10px;display:grid;grid-template-columns:50px 1000px;width:1085px;">

                <div style='font-size:14px'>
                    zones
                </div>
                <div>

                    <!-- DAY CALENDAR BANNER -->
                    <div class="day_calendar_banner" id="four" style="grid-template-columns:100px 100px 100px 100px 100px 100px 100px 100px 100px 100px 100px 100px 100px 100px 100px;">
                        <div>5am - 6am</div>
                        <div>6am - 7am</div>
                        <div>7am - 8am</div>
                        <div>8am - 9am</div>
                        <div>9am - 10am</div>
                        <div>10am - 11am</div>
                        <div>11am - 12pm</div>
                        <div>12pm - 1pm</div>
                        <div>1pm - 2pm</div>
                        <div>2pm - 3pm</div>
                        <div>3pm - 4pm</div>
                        <div>4pm - 5pm</div>
                        <div>5pm - 6pm</div>
                        <div>6pm - 7pm</div>
                        <div style='border-right:1px solid black;'>7pm - 8pm</div>
                    </div>

                </div>

            </div>

            <!-- DAY CALENDAR VIEW -->
            <div class="day_calendar_view" style="grid-template-columns:50px auto">
                <div style="height:540px;overflow:hidden;overflow-y:auto;" id="one">
                <?php
                    $day_calendar_zone = "";
                    $getZones = "SELECT * FROM tbl_zones WHERE regionID = 1";
                    if ($zoning_result = mysqli_query($conn, $getZones)) {
                        while ($zoning = mysqli_fetch_assoc($zoning_result)) {
                            $day_calendar_zone .= "
                                <div style='border-radius:2px;border:1px solid black;height:22px;font-size:14px;margin:0 0 1px 0'>" . $zoning['zoneID'] . "</div>
                            ";
                        }
                    }
                    echo $day_calendar_zone;
                ?>
                </div>
                <div style="overflow:hidden;height:540px;overflow-y:auto;" id="two">
                    <!-- CALENDAR DAY TIME-->
                    <div class="calendar_day_time" id="three" style="grid-template-columns:100px 100px 100px 100px 100px 100px 100px 100px 100px 100px 100px 100px 100px 100px 100px">
                        <?php
                            $inside_zone = "";
                            if ($zones_result = mysqli_query($conn, $getZones)) {
                                while ($innerzone = mysqli_fetch_assoc($zones_result)) {
                                    $inside_zone .= "
                                        <div></div>
                                        <div></div>
                                        <div></div>
                                        <div></div>
                                        <div></div>
                                        <div></div>
                                        <div></div>
                                        <div></div>
                                        <div></div>
                                        <div></div>
                                        <div></div>
                                        <div></div>
                                        <div></div>
                                        <div></div>
                                        <div></div>
                                    ";
                                }
                            }

                            echo $inside_zone;
                        ?>
                    </div>
                </div>
            </div>

        </div>

    </body>
</html>