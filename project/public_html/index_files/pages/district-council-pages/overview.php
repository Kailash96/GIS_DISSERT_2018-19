<!DOCTYPE html>
<html>
    <head>
        <title>Home | Binswiper</title>
        <link rel="stylesheet" href="../../css_files/style.css" />
        <link rel="stylesheet" href="../../css_files/overview.css" />
        <script src="../../js_files/jquery_lib.js"></script>

        <!-- LEAFLET ROUTING CSS -->
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.2.0/dist/leaflet.css" />
        <link rel="stylesheet" href="../../css_files/leaflet-routing-machine.css" />

        <!-- LEAFLET ROUTING, MARKING ETC -->
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.4.0/dist/leaflet.css" integrity="sha512-puBpdR0798OZvTTbP4A8Ix/l+A4dHDD0DGqYW6RQ+9jxkRFclaxxQb/SJAWZfWAkuyeQUytO7+7N4QKrDh+drA==" crossorigin=""/>
        <script src="https://unpkg.com/leaflet@1.4.0/dist/leaflet.js" integrity="sha512-QVftwZFqvtRNi0ZyCtsznlKSWOStnDORoefr1enyq5mVL4tmKB3S/EnC3rRJcxCPavG10IcrVGSmPh6Qw5lwrg==" crossorigin=""></script>

        <!-- ROUTING MACHINE LOCAL-->
        <script src="../../js_files/leaflet-routing-machine.js"></script>

        <!-- LEAFLET DRAW -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/1.0.4/leaflet.draw.css"/>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/1.0.4/leaflet.draw.js"></script>

        <script>
            $(document).keydown(function(event) {
            if (event.ctrlKey==true && (event.which == '61' || event.which == '107' || event.which == '173' || event.which == '109'  || event.which == '187'  || event.which == '189'  ) ) {
                    event.preventDefault();
                }
                // 107 Num Key  +
                // 109 Num Key  -
                // 173 Min Key  hyphen/underscor Hey
                // 61 Plus key  +/= key
            });

            $(window).bind('mousewheel DOMMouseScroll', function (event) {
                if (event.ctrlKey == true) {
                    event.preventDefault();
                }
            });
        </script>
    </head>
    <body>
        <?php include("left_side_nav_bar.html"); ?>
        <?php include("top-nav-bar.html"); ?>

        <?php include("../../../../config/db_connect.php"); ?>
        
        <div id="map"></div>
        <script src="https://unpkg.com/leaflet@1.2.0/dist/leaflet.js"></script>
        <script src="../../js_files/leaflet-routing-machine.js"></script>

        <script>
            var map = L.map('map').setView([-20.220740, 57.776270], 12);

            L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);

            var redIcon = new L.Icon({
                iconUrl: '../../img/marker-red.png',
                shadowUrl: '../../img/marker-shadow.png',
                iconSize: [25, 41],
                iconAnchor: [12, 41],
                popupAnchor: [1, -34],
                shadowSize: [41, 41]
            });

            var yellowIcon = new L.Icon({
                iconUrl: '../../img/marker-yellow.png',
                shadowUrl: '../../img/marker-shadow.png',
                iconSize: [25, 41],
                iconAnchor: [12, 41],
                popupAnchor: [1, -34],
                shadowSize: [41, 41]
            });

            var greenIcon = new L.Icon({
                iconUrl: '../../img/marker-green.png',
                shadowUrl: '../../img/marker-shadow.png',
                iconSize: [25, 41],
                iconAnchor: [12, 41],
                popupAnchor: [1, -34],
                shadowSize: [41, 41]
            });

            var blueIcon = new L.Icon({
                iconUrl: '../../img/marker-blue.png',
                shadowUrl: '../../img/marker-shadow.png',
                iconSize: [25, 41],
                iconAnchor: [12, 41],
                popupAnchor: [1, -34],
                shadowSize: [41, 41]
            });

            function clear(){
                $("#panel_support").hide();
                $("#usr_panel").slideUp();
            }

            function show(){
                $("#panel_support").show();
                $("#panel_support").click(function(){
                    clear();
                });
                $("#usr_panel").slideDown();
            }

            function popupInfo(){
                var USER_ID = this.options.markerID;
                show();

                var userData = new XMLHttpRequest();
                userData.onreadystatechange = function(){
                    if (this.readyState == 4 && this.status == 200) {
                        var content = JSON.parse(this.responseText);
                        document.getElementById("usr_panel").innerHTML = content;
                    }
                }
                userData.open("POST", "user_data.php", true);
                userData.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                userData.send("userID=" + USER_ID);
            }
            
            <?php
                
                // temp for dcof region to be changes to session[collectorsID] on login
                $getPolygonCoords_query = "SELECT coordinates FROM tbl_region WHERE collectorsID = 'DCOF' LIMIT 1";
                if ($results = mysqli_query($conn, $getPolygonCoords_query)) {
                    while ($row = mysqli_fetch_assoc($results)) {
                        $coords = $row['coordinates'];
                        echo "
                            var region = L.polygon(" . $coords . ", {color: 'blue', weight: 1});
                            region.addTo(map);
                        ";
                    }
                }

                // SETS THE ZONES
                $getZonesCoords_query = "SELECT coordinates FROM tbl_zones";
                if ($results = mysqli_query($conn, $getZonesCoords_query)) {
                    while ($row = mysqli_fetch_assoc($results)) {
                        $coords = $row['coordinates'];
                        echo "
                            var zones = L.polygon(" . $coords . ", {color: 'red', weight: 1});
                            zones.addTo(map);
                        ";
                    }
                }

                // SET MARKERS
                $getCoordsQuery = "SELECT * FROM tbl_generator LEFT JOIN tbl_waste_gen ON (tbl_generator.generatorID = tbl_waste_gen.generatorID) WHERE tbl_generator.Active = 1 AND tbl_generator.region = 'Flacq'"; // to be changed to region = region
                if ($results = mysqli_query($conn, $getCoordsQuery)) {
                    while ($row = mysqli_fetch_assoc($results)) {
                        $binLevelDomestic = $row['Organic'];
                        $binLevelPlastic = $row['Plastic'];
                        $binLevelPaper = $row['Paper'];
                        $binLevelOther = $row['Other'];
                        if (($binLevelDomestic >= 80) || ($binLevelPlastic >= 80) || ($binLevelPaper >= 80) || ($binLevelOther >= 80)) {
                            $iconColor = "redIcon";
                        } else if (($binLevelDomestic >= 50) || ($binLevelPlastic >= 50) || ($binLevelPaper >= 50) || ($binLevelOther >= 50)) {
                            $iconColor = "yellowIcon";
                        } else if (($binLevelDomestic > 0) || ($binLevelPlastic > 0) || ($binLevelPaper > 0) || ($binLevelOther > 0)) {
                            $iconColor = "greenIcon";
                        } else {
                            $iconColor = "blueIcon";
                        }
                        $userID = $row['generatorID'];
                        
                        echo "marker = new L.marker([" . $row['LocationCoordinate'] . "], {markerID:" . json_encode($userID) . ", icon: " . $iconColor . "}).addTo(map).on('click', popupInfo);";
                        
                    }
                }
                
            ?>

            map.fitBounds(region.getBounds());

            function getRoutes() {
                var routing = new XMLHttpRequest();
                routing.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        var route = JSON.parse(this.responseText);
                        formatting(route);
                    }
                }
                routing.open("POST", "setRoute.php", true);
                routing.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                routing.send();
            }

            routes = [];
            function formatting(way) {
                for (var i = 0; i < way.length; i++) {
                    for (var j = 0; j < way[i].length; j++) {
                        routes.push("[" + way[i][j] + "]");
                    }
                    var arr_routes = "[" + routes + "]";
                    addRoute(arr_routes);
                    routes.length = 0;
                }
            }

            // var way = [[-20.143506686462313,57.69015312194824],[-20.144111040432193,57.68946647644043]];
            function addRoute(route) {
                L.Routing.control({
                    waypoints: JSON.parse(route),
                    routeWhileDragging: false,
                    show:false,
                    createMarker: function() { return null; },
                    fitSelectedRoutes: false,
                    addWaypoints: false
                }).addTo(map);
            }
            // addRoute(way);
            getRoutes();

        </script>

        <!-- USER INFORMATION PANEL -->
        <!-- panel support -->
        <div id="panel_support" style="background-color:transparent;width:100%;height:100%;position:fixed;top:0px;">hello</div>
        <!-- panel -->
        <div class="user_panel" id="usr_panel" align="center"></div>
    </body>
</html>