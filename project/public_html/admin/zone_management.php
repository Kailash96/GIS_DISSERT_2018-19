<!DOCTYPE html>
<html>
    <head>
        <title>Home | Binswiper</title>
        <link rel="stylesheet" href="../index_files/css_files/style.css" />
        <script type="text/javascript" src="../index_files/js_files/script.js" /></script>
        <script type="text/javascript" src="../index_files/js_files/admin_script.js" /></script>

        <!-- JQUERY -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

        <!-- MAP CSS AND JAVASCRIPT -->
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.4.0/dist/leaflet.css"
        integrity="sha512-puBpdR0798OZvTTbP4A8Ix/l+A4dHDD0DGqYW6RQ+9jxkRFclaxxQb/SJAWZfWAkuyeQUytO7+7N4QKrDh+drA=="
        crossorigin=""/>
        <script src="https://unpkg.com/leaflet@1.4.0/dist/leaflet.js"
        integrity="sha512-QVftwZFqvtRNi0ZyCtsznlKSWOStnDORoefr1enyq5mVL4tmKB3S/EnC3rRJcxCPavG10IcrVGSmPh6Qw5lwrg=="
        crossorigin=""></script>

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/1.0.4/leaflet.draw.css"/>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/1.0.4/leaflet.draw.js"></script>

        <style>
            #zone_mngt_selected{
                background-color:#DCDCDC;
                border-left:4px solid #009DC4;
            }

            #map{
                height:615px;
                margin-top:52px;
                z-index:0;
                box-shadow:0 0 4px black;
            }

            .board{
                background-color:white;
                border:1px solid black;
                position:fixed;
                top:300px;
                left:550px;
                padding:20px;
                border-radius:4px;
                display:none;
            }
            
            .board h4{
                margin:0;
            }

            .board > input[type=text]{
                box-sizing:border-box;
                border:1px solid black;
                padding:2px 4px;
                width:300px;
                border-radius:2px;
                height:30px;
            }

            input[type=button]{
                border:1px solid black;
                background-color:white;
                padding:4px 8px;
                border-radius:3px;
                cursor:pointer;
                float:right;
                width:120px;
                margin:0 0 0 8px;
            }

            input[type=button]:hover{
                box-shadow:0 0 2px black;
            }

            #on{
                display:none;
            }

            #no_zone_users_counter{
                border:1px solid red;
                background-color:red;
                color:white;
                padding:0 5px;
                border-radius:3px;
            }
        </style>

    </head>
    <body onload="save_zone(0)">
        <?php include("admin-left_side_nav_bar.php"); ?>
        <?php include("admin-top-nav-bar.html"); ?>

        <?php
            include("../../config/db_connect.php");

            // QUERY FOR RESIDENTS
            $active_user_query = "SELECT LocationCoordinate FROM tbl_residents WHERE Active = 1";
            // QUERY FOR INDUSTRIALS
            // QUERY FOR COMMERCIALS

        ?>

        <div id="map"></div>

        <script>
            var map = L.map('map').setView([-20.220740, 57.776270], 12);

            L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);

            function select(event) {
                var selection = event.target.options.id;
                console.log(selection);
            }
            
            <?php
                
                // temp for dcof region to be changes to session[collectorsID] on login
                // SETS THE REGION
                $getPolygonCoords_query = "SELECT * FROM tbl_region";
                if ($results = mysqli_query($conn, $getPolygonCoords_query)) {
                    while ($row = mysqli_fetch_assoc($results)) {
                        $coords = $row['coordinates'];
                        $label = $row['regionName'];
                        $id = $row['regionID'];
                        echo "
                            var polygon = L.polygon(" . $coords . ", {color: 'blue', weight: 1, label: '" . $label . "', id: '" . $id . "'});
                            polygon.on('click', select);
                            polygon.addTo(map);
                        ";
                    }
                }
                
            ?>

            // map.fitBounds(polygon.getBounds());

            // Initialise the FeatureGroup to store editable layers
            var editableLayers = new L.FeatureGroup();
            map.addLayer(editableLayers);

            var drawPluginOptions = {
                position: 'topright',
                draw: {
                    polygon: {
                    allowIntersection: false, // Restricts shapes to simple polygons
                    drawError: {
                        color: '#e1e100', // Color the shape will turn when intersects
                        message: '<strong>Oh snap!<strong> you can\'t draw that!' // Message that will show when intersect
                    },
                    shapeOptions: {
                        color: '#bada55'
                    }
                    },
                    polyline:false,
                    circle: false, // Turns off this drawing tool
                    rectangle: false,
                    marker:false,
                    circlemarker:false
                },
                edit: {
                    featureGroup: editableLayers, //REQUIRED!!
                    remove: false,
                }
            };

            // Initialise the draw control and pass it the FeatureGroup of editable layers
            var drawControl = new L.Control.Draw(drawPluginOptions);
            map.addControl(drawControl);

            var editableLayers = new L.FeatureGroup();
            map.addLayer(editableLayers);


            var regionArray = [], zoneArray = [];

            map.on('draw:created', function(e) {
                var type = e.layerType,
                    layer = e.layer;

                if (type == 'polygon') {
                    var points= layer._latlngs;
                    var cFormat = "[";
                    var i;
                    for (i = 0; i < points[0].length; i++) {
                        cFormat += "[" + points[0][i].lat + "," + points[0][i].lng;
                        if (i != (points[0].length - 1)) {
                            cFormat += "],";
                        } else {
                            cFormat += "]";
                        }
                    }
                    cFormat += "]";
                    regionArray.push(cFormat);
                    zoneArray.push(JSON.parse(cFormat));
                }
                editableLayers.addLayer(layer);
            });

            
            function save_changes(collector_id, region_name){

                var save = new XMLHttpRequest();
                save.onreadystatechange = function(){
                    if (this.readyState == 4 && this.status == 200) {
                        console.log("success");
                        cancel();
                        alert("New Region/Zone created Successfully!");
                        window.location.reload();
                    }
                }
                save.open("POST", "admin_save_region.php", true);
                save.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                save.send("coords=" + JSON.stringify(regionArray) + "&collectors_id=" + collector_id + "&region_name=" + region_name);

                regionArray.length = 0; // empty the array

            }

            
            var polygon = [];
            function save_zone(act){
                var data;
                if (act == 0){
                    data = "act=" + act;
                } else {
                    data = "zone_array=" + JSON.stringify(zoneArray) + "&act=" + act;
                }

                var store_zones = new XMLHttpRequest();
                store_zones.onreadystatechange = function(){
                    if (this.readyState == 4 && this.status == 200) {
                        var draw_zone = JSON.parse(this.responseText);
                        for (var r = 0; r < polygon.length; r++) {
                            map.removeLayer(polygon[r]);
                        }
                        for (var z = 0; z < draw_zone.length; z++) {
                            polygon[z] = L.polygon(JSON.parse(draw_zone[z]), {color: 'red', weight: 1});
                            polygon[z].addTo(map);
                        }
                    }
                }
                store_zones.open("POST", "admin_save_zones.php", true);
                store_zones.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                store_zones.send(data);
            }

            
            function submit_changes(){
                var region = document.getElementById("region").checked;
                var zone = document.getElementById("zone").checked;

                if (region) {
                    $("#board").fadeIn();
                } else if (zone) {
                    // save in table zone
                    save_zone(1);
                    var zoneAssignment = new XMLHttpRequest();
                    zoneAssignment.onreadystatechange = function(){
                        // to redraw markers function redraw_markers() -> need region parameter
                    }
                    zoneAssignment.open("POST", "checkZoneAssignment.php", true);
                    zoneAssignment.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                    zoneAssignment.send();
                }

            }

            function cancel(){
                $("#board").fadeOut();
            }

            
            var marker = [];
            function redraw_markers(region){
                var getmarkers = new XMLHttpRequest();
                getmarkers.onreadystatechange = function(){
                    if (this.readyState == 4 && this.status == 200){
                        var coordinates = JSON.parse(this.responseText);
                        for (var i = 0; i < coordinates.length; i++) {
                            var coordsbreak = coordinates[i].split(",");
                            marker.push(L.marker([coordsbreak[0], coordsbreak[1]]).addTo(map));
                        }
                    }
                }
                getmarkers.open("POST", "no_zone_markers.php", true);
                getmarkers.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                getmarkers.send("region=" + region);
            }

            
            function toggle_switch(opt, region){
                if (opt == "off") {
                    $("#on").css('display','block');
                    $("#off").css('display','none');

                    redraw_markers(region);
                } else {
                    $("#off").css('display', 'block');
                    $("#on").css('display', 'none');

                    for (var i = 0; i < marker.length; i++) {
                        map.removeLayer(marker[i]);
                    }
                    marker.length = 0;
                }
            }

        </script>
        
        <table style="background-color:white;font-size:14px;z-index:2;position:fixed;top:200px;right:10px;width:350px;box-shadow:0 0 2px black;border-radius:3px" cellspacing="0">
            <tr>
                <td>
                    <!-- ZONING ISSUES -->
                    <div style="padding:10px">
                        <select style="border:1px solid black;padding:4px;width:100%;" id="regioning">
                            <option selected="true" disabled="true">Select Region</option>
                            <option value="Flacq">Flacq</option>
                            <option value="Grand Port">Grand Port</option>
                            <option value="Moka">Moka</option>
                            <option value="Pamplemousses">Pamplemousses</option>
                            <option value="Plaines Wilhiems">Plaines Wilhiems</option>
                            <option value="Port Louis">Port Louis</option>
                            <option value="Riviere Du Rempart">Riviere Du Rempart</option>
                            <option value="Riviere Noire">Riviere Noire</option>
                            <option value="Savanne">Savanne</option>
                        </select>

                        <br/><br/>
                        Show/Hide users without zones <span id="no_zone_users_counter">0</span><br/>
                        <i class="fa fa-toggle-off" id="off" style="color:red;font-size:24px;cursor:pointer" onclick="toggle_switch(this.id, regioning.value)"></i>
                        <i class="fa fa-toggle-on" id="on" style="color:green;font-size:24px;cursor:pointer" onclick="toggle_switch(this.id, regioning.value)"></i>
                    </div>

                    <!-- DRAW ZONES OR REGIONS -->
                    <div style="background-color:white;">
                        <input type="radio" name="zone_opt" id="region" value="region" checked /> Set Region<br/><br/>
                        <input type="radio" name="zone_opt" id="zone" onchange="cancel()" value="zone" /> Set Zone<br/><br/>
                        <input type="button" value="Submit Changes" onclick="submit_changes()" />
                    </div>
                </td>
            </tr>
        </table>

        <div class="board" id="board">
            <b style="font-size:14px;">Region Name</b><br/>
            <input type="text" name="region_name" id="region_name" Placeholder="Enter Region Name" /><br/><br/>
            <b style="font-size:14px;">Waste Collector Assignment:</b><br/>
            <select id="collector">
                <option selected disabled>-- District Council --</option>
                <?php
                    $get_from_dc_query = "SELECT CollectorID, Name FROM tbl_collectors WHERE Category = 'District Council'";
                    if ($data = mysqli_query($conn, $get_from_dc_query)) {
                        while ($row = mysqli_fetch_assoc($data)) {
                            echo "<option value=" . $row['CollectorID'] . ">" . $row['Name'] . "</option>";
                        }
                    }
                ?>
                <option disabled>-- Municipality --</option>
                <?php
                    $get_from_mp_query = "SELECT CollectorID, Name FROM tbl_collectors WHERE Category = 'Municipality'";
                    if ($data = mysqli_query($conn, $get_from_mp_query)) {
                        while ($row = mysqli_fetch_assoc($data)) {
                            echo "<option value=" . $row['CollectorID'] . ">" . $row['Name'] . "</option>";
                        }
                    }
                ?>
                <option disabled>-- Recyclers --</option>
                <?php
                    $get_from_rc_query = "SELECT RegNo, Name FROM tbl_contractors WHERE Category = 'Contractors'";
                    if ($data = mysqli_query($conn, $get_from_rc_query)) {
                        while ($row = mysqli_fetch_assoc($data)) {
                            echo "<option value=" . $row['CollectorID'] . ">" . $row['Name'] . "</option>";
                        }
                    }
                ?>
            </select>
            <br/><br/>
            <input type="button" value="Save Changes" onclick="save_changes(collector.value, region_name.value)" />
            <input type="button" value="Cancel" onclick="cancel()" />
        </div>
    </body>
</html>