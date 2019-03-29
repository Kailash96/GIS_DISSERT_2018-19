<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Leaflet Routing Machine Example</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.2.0/dist/leaflet.css" />
    <link rel="stylesheet" href="leaflet-routing-machine.css" />
    <style>
        .map {
            position: absolute;
            width: 100%;
            height: 100%;
        }
    </style>
</head>
<body>
    <div id="map" class="map"></div>
    <script src="https://unpkg.com/leaflet@1.2.0/dist/leaflet.js"></script>
    <script src="leaflet-routing-machine.js"></script>
    <script>
        var map = L.map('map');

        L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}{r}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

        L.Routing.control({
            waypoints: [
                L.latLng(57.74, 11.94),
                L.latLng(57.6792, 11.949)
            ],
            routeWhileDragging: true
        }).addTo(map);
    </script>
</body>
</html>