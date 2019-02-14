<!DOCTYPE html>
<html>
    <head>
        <title>Home | Binswiper</title>
        <link rel="stylesheet" href="../../css_files/style.css" />

        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.4.0/dist/leaflet.css"
        integrity="sha512-puBpdR0798OZvTTbP4A8Ix/l+A4dHDD0DGqYW6RQ+9jxkRFclaxxQb/SJAWZfWAkuyeQUytO7+7N4QKrDh+drA=="
        crossorigin=""/>
        <script src="https://unpkg.com/leaflet@1.4.0/dist/leaflet.js"
        integrity="sha512-QVftwZFqvtRNi0ZyCtsznlKSWOStnDORoefr1enyq5mVL4tmKB3S/EnC3rRJcxCPavG10IcrVGSmPh6Qw5lwrg=="
        crossorigin=""></script>

        <style>
            #home_selected{
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

            var polygon = [];
            function setLayer() {
                var layer = new XMLHttpRequest();
                layer.onreadystatechange = function(){
                    if (this.readyState == 4 && this.status == 200) {
                        var data = JSON.parse(this.responseText);
                        // for (var i = 0; i < data[1].length; i++) {
                            var polygons = L.polygon(data[1][1], {color: 'red', weight: 1});
                            polygons.addTo(map);
                        // }
                    }
                }
                layer.open("POST", "getmarkers.php", true);
                layer.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                layer.send();
            }
            
            function setPolygon(){
                for (var i = 0; i < polygon.length; i++) {
                    // polygon[i].addTo(map);
                    console.log(polygon[i]);
                };
            }

            setLayer();

            /*
            <?php
                // temp for dcof region to be changes to session[collectorsID] on login
                $getPolygonCoords_query = "SELECT coordinates FROM zone WHERE collectorsID = 'DCOF'";
                if ($results = mysqli_query($conn, $getPolygonCoords_query)) {
                    while ($row = mysqli_fetch_assoc($results)) {
                        $coords = $row['coordinates'];
                        echo "
                            polygon.push(L.polygon(" . $coords . ", {color: 'red', weight: 1}));
                            zone_coords.push(" . $coords . ");
                        ";
                    }
                }

            ?>

            */

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