<!DOCTYPE html>
<html>
    <head>
        <title>Home | Binswiper</title>
        <link rel="stylesheet" href="../../css_files/style.css" />
        <link rel="stylesheet" href="../../js_files/script.js" />

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
                border-left:4px solid #002246;
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
        </style>

    </head>
    <body>
        <?php include("admin-left_side_nav_bar.php"); ?>
        <?php include("admin-top-nav-bar.html"); ?>

        <?php
            include("../../../db_connect.php");

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
            
            <?php
                
                // temp for dcof region to be changes to session[collectorsID] on login
                $getPolygonCoords_query = "SELECT coordinates FROM tbl_region";
                if ($results = mysqli_query($conn, $getPolygonCoords_query)) {
                    while ($row = mysqli_fetch_assoc($results)) {
                        $coords = $row['coordinates'];
                        echo "
                            var polygon = L.polygon(" . $coords . ", {color: 'red', weight: 1});
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
                    }
                }
                save.open("POST", "admin_save_region.php", true);
                save.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                save.send("coords=" + JSON.stringify(regionArray) + "&collectors_id=" + collector_id + "&region_name=" + region_name);

                regionArray.length = 0; // empty the array

            }

            function save_zone(){
                var store_zones = new XMLHttpRequest();
                store_zones.onreadystatechange = function(){
                    if (this.readyState == 4 && this.status == 200) {
                        var response = JSON.parse(this.responseText);
                        console.log(response);
                    }
                }
                store_zones.open("POST", "admin_save_zones.php", true);
                store_zones.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                store_zones.send("zone_array=" + JSON.stringify(zoneArray));
            }

            function submit_changes(){
                var region = document.getElementById("region").checked;
                var zone = document.getElementById("zone").checked;

                if (region) {
                    $("#board").fadeIn();
                } else if (zone) {
                    // save in table zone
                    save_zone();
                }

            }

            function cancel(){
                $("#board").fadeOut();
            }
        </script>
        
        <div style="z-index:2;position:fixed;top:200px;right:10px;background-color:white;display:block;width:200px;box-shadow:0 0 2px black;padding:8px">
            <input type="radio" name="zone_opt" id="region" value="region" checked /> Set Region<br/><br/>
            <input type="radio" name="zone_opt" id="zone" onchange="cancel()" value="zone" /> Set Zone<br/><br/>
            <input type="button" value="Submit Changes" onclick="submit_changes()" />
        </div>

        <div class="board" id="board">
            <b style="font-size:14px;">Region Name</b><br/>
            <input type="text" name="region_name" id="region_name" Placeholder="Enter Region Name" /><br/><br/>
            <b style="font-size:14px;">Waste Collector Assignment:</b><br/>
            <select id="collector">
                <option selected disabled>-- District Council --</option>
                <?php
                    $get_from_dc_query = "SELECT DCID, Name FROM districtcouncil";
                    if ($data = mysqli_query($conn, $get_from_dc_query)) {
                        while ($row = mysqli_fetch_assoc($data)) {
                            echo "<option value=" . $row['DCID'] . ">" . $row['Name'] . "</option>";
                        }
                    }
                ?>
                <option disabled>-- Municipality --</option>
                <?php
                    $get_from_mp_query = "SELECT MID, Name FROM municipality";
                    if ($data = mysqli_query($conn, $get_from_mp_query)) {
                        while ($row = mysqli_fetch_assoc($data)) {
                            echo "<option value=" . $row['MID'] . ">" . $row['Name'] . "</option>";
                        }
                    }
                ?>
                <option disabled>-- Recyclers --</option>
                <?php
                    $get_from_rc_query = "SELECT RegNo, Name FROM contractors";
                    if ($data = mysqli_query($conn, $get_from_rc_query)) {
                        while ($row = mysqli_fetch_assoc($data)) {
                            echo "<option value=" . $row['RegNo'] . ">" . $row['Name'] . "</option>";
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