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
            .calendar_day_view_banner{
                display:grid;
                border:1px solid black;
                padding:10px;
                width:1050px;
            }

            .calendar_day_view_banner > div {
                border:1px solid black;
            }

            .calendar_day_view{
                height:570px;
                overflow-y:auto;
                white-space:wrap;
                text-overflow:hidden;
                display:grid;
                border:1px solid black;
                padding:10px;
                grid-template-columns:50px 159px 159px 159px 159px 159px 159px;
                width:1050px;
            }

            #day_calendar_container{
                
            }
        </style>
        <script type="text/javascript">
            function day_view(day){
                $("#week_calendar_container").fadeOut(100);
            }
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
            <div class="calendar_day_view_banner" style="grid-template-columns:50px 100px 100px 100px 100px 100px 100px 100px 100px 100px 100px 100px 100px 100px 100px 100px">
                <div>zones</div>
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
            </div>

            <!-- DAY CALENDAR VIEW -->
            <div class="calendar_day_view">
            </div>

        </div>

    </body>
</html>