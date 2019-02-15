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
            #home_selected{
                background-color:#002246;
                color:white;
            }

            #map{
                height:550px;
            }

            .text{
                text-transform:capitalize;
            }
        </style>

    </head>
    <body style="margin-left:20.4%;margin-right:0.4%">
        <?php include("left_side_nav_bar.html"); ?>
        <?php include("top-nav-bar.html"); ?>

        <?php
            include("../../../db_connect.php");

            // QUERY FOR RESIDENTS
            $active_user_query = "SELECT LocationCoordinate FROM residents WHERE Active = 1 LIMIT 1";
            // QUERY FOR INDUSTRIALS
            // QUERY FOR COMMERCIALS

        ?>
        
        <div id="map"></div>

        <script>
            var map = L.map('map').setView([-20.220740, 57.776270], 12);

            L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);

            var polygons_coords = [], data = "";
            function setLayer() {
                var layer = new XMLHttpRequest();
                layer.onreadystatechange = function(){
                    if (this.readyState == 4 && this.status == 200) {
                        data = JSON.parse(this.responseText);
                        for (var i = 0; i < data[0].length; i++) {
                            polygons_coords.push(data[0][i]);
                        }
                    }
                }
                layer.open("POST", "getmarkers.php", false);
                layer.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                layer.send();
            }

            setLayer();

            for (var j = 0; j < polygons_coords.length; j++) {
                L.polygon(JSON.parse(polygons_coords[j]), {color: 'red', weight: 1}).addTo(map);
            }

            // CHECK IF COORDINATE IS IN ZONE
            function inside(point, vs) {

                var x = point[0];
                var y = point[1];

                var inside = false;
                for (var i = 0, j = vs.length - 1; i < vs.length; j = i++) {
                    var xi = vs[i][0];
                    var yi = vs[i][1];
                    var xj = vs[j][0];
                    var yj = vs[j][1];
                    
                    var intersect = ((yi > y) != (yj > y))
                    && (x < (xj - xi) * (y - yi) / (yj - yi) + xi);
                    if (intersect) inside = !inside;
                }

                return inside;

            };

            for (var c = 0; c < data[1].length; c++) {
                var crds = data[1][c][0].split(",");
                for (var k = 0; k < polygons_coords.length; k++) {
                    if (inside(crds, JSON.parse(polygons_coords[k]))){
                        var mark_coord = "[" + data[1][c][0] + "]";
                        L.marker(JSON.parse(mark_coord)).addTo(map)
                            .bindPopup(createContent(data[1][c]));
                    }
                }
            }

            function createContent(userDataArr){
                // [0] = coordinate
                // [1] = name
                // [2] = address
                var content = "";
                content += "<h2 class='text'>" + userDataArr[1] + "</h2>";
                content += "<h4 class='text'>" + userDataArr[2] + "</h4>";
                content += "<h5 class='text'>" + userDataArr[0] + "</h5>";

                return content;
            }

            // map.fitBounds(polygon[0].getBounds());

            /*
            // CHECK IF COORDINATE IS IN ZONE
            <?php
                function inside($point, $vs) {

                    $x = $point[0];
                    $y = $point[1];

                    $inside = false;
                    for ($i = 0, $j = sizeof($vs) - 1; $i < sizeof($vs); $j = $i++) {
                        $xi = $vs[$i][0];
                        $yi = $vs[$i][1];
                        $xj = $vs[$j][0];
                        $yj = $vs[$j][1];
                        
                        $intersect = (($yi > $y) != ($yj > $y))
                        && ($x < ($xj - $xi) * ($y - $yi) / ($yj - $yi) + $xi);
                        if ($intersect) $inside = !$inside;
                    }

                    return $inside;

                };
            ?>
            */

            /*
            // ROUTING WITH COORDINATES
            var data = [
            

            <?php
 
                // COORDINATES FROM DATABASE MERGED WITH POLYGON FUNCTION
                if ($results = mysqli_query($conn, $active_user_query)){
                    $counter = mysqli_num_rows($results);
                    while($row = mysqli_fetch_assoc($results)){

                        $loc_coords = explode(",", $row['LocationCoordinate']);
                        
                        if (inside($loc_coords, json_decode($coords))) {
                            $coord = $loc_coords;
                        }
                        
                        
                        echo "
                            {
                                'lat': '$coord[0]',
                                'lng': '$coord[1]'
                            },
                        ";
                        

                    };
                };
                
            ?>

            
            ];


            var routeControl = L.Routing.control({
            }).addTo(map);
            routeControl.setWaypoints(data);
            */


        </script>

    </body>
</html>