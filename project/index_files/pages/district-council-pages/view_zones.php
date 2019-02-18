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
                background-color:#DCDCDC;
                border-left:4px solid #009DC4;
            }

            #map{
                height:615px;
                margin-top:52px;
                z-index:0;
                box-shadow:0 0 4px black;
            }
        </style>

    </head>
    <body>
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
                if ($results = mysqli_query($GLOBALS['conn'], $getZonesCoords_query)) {
                    while ($row = mysqli_fetch_assoc($results)) {
                        $coords = $row['coordinates'];
                        echo "
                            var zones = L.polygon(" . $coords . ", {color: 'red', weight: 1});
                            zones.addTo(map);
                        ";
                    }
                }
                
            ?>

            map.fitBounds(region.getBounds());

        </script>
    </body>
</html>