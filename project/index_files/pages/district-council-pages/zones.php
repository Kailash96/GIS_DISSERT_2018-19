<!DOCTYPE html>
<html>
    <head>
        <title>Home | Binswiper</title>
        <link rel="stylesheet" href="../../css_files/style.css" />

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
            #zones_selected{
                background-color:#002246;
                color:white;
            }

            #map{
                height:550px;
            }
        </style>

    </head>
    <body style="margin-left:20.4%;margin-right:0.4%">
        <?php include("left_side_nav_bar.html"); ?>
        <?php include("top-nav-bar.html"); ?>

        <?php
            include("../../../db_connect.php");

            // QUERY FOR RESIDENTS
            $active_user_query = "SELECT LocationCoordinate FROM residents WHERE Active = 1";
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
                $getPolygonCoords_query = "SELECT coordinates FROM zone WHERE collectorsID = 'DCOF'";
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


            var mainArray = [];

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
                    mainArray.push(cFormat);
                }
                editableLayers.addLayer(layer);
            });

            function save_changes(){
                var save = new XMLHttpRequest();
                save.onreadystatechange = function(){
                    if (this.readyState == 4 && this.status == 200) {
                        console.log("success");
                    }
                }
                save.open("POST", "save_zones.php", true);
                save.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                save.send("coords=" + JSON.stringify(mainArray));

                mainArray.length = 0; // empty the array
            }
        </script>
        
        <input type="button" value="Save Changes" onclick="save_changes()" />
    </body>
</html>