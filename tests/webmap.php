<!HTML5>
<html>
    <head>
        <!-- LEAFLET -->
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.3.4/dist/leaflet.css"
        integrity="sha512-puBpdR0798OZvTTbP4A8Ix/l+A4dHDD0DGqYW6RQ+9jxkRFclaxxQb/SJAWZfWAkuyeQUytO7+7N4QKrDh+drA=="
        crossorigin=""/>
        <script src="https://unpkg.com/leaflet@1.3.4/dist/leaflet.js"
        integrity="sha512-nMMmRyTVoLYqjP9hrbed9S+FzjZHW5gY1TWCHA5ckwXZBadntCNs8kEqAWdrb9O7rxbCaA4lKTIWjDXZxflOcA=="
        crossorigin=""></script>

        <!-- ESRI LEAFLET -->
        <script src="https://unpkg.com/esri-leaflet@2.2.3/dist/esri-leaflet.js"
        integrity="sha512-YZ6b5bXRVwipfqul5krehD9qlbJzc6KOGXYsDjU9HHXW2gK57xmWl2gU6nAegiErAqFXhygKIsWPKbjLPXVb2g=="
        crossorigin=""></script>
        <!-- GEOCODING -->
        <link rel="stylesheet" href="https://unpkg.com/esri-leaflet-geocoder@2.2.13/dist/esri-leaflet-geocoder.css"
        integrity="sha512-v5YmWLm8KqAAmg5808pETiccEohtt8rPVMGQ1jA6jqkWVydV5Cuz3nJ9fQ7ittSxvuqsvI9RSGfVoKPaAJZ/AQ=="
        crossorigin="">
        <script src="https://unpkg.com/esri-leaflet-geocoder@2.2.13/dist/esri-leaflet-geocoder.js"
        integrity="sha512-zdT4Pc2tIrc6uoYly2Wp8jh6EPEWaveqqD3sT0lf5yei19BC1WulGuh5CesB0ldBKZieKGD7Qyf/G0jdSe016A=="
        crossorigin=""></script>
        
        <style>
            #map { height:100%; }
        </style>
    </head>
    <body style="margin:0;">
        <div style="border:2px solid black;padding:2px;width:700px;height:450px">
            <div id="map"></div>
        </div>
        <script>        
            var map = L.map('map', {
                center: [-20.197960, 57.721996],
                zoom: 12
            });

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://osm.org/copyright">OpenStreetMap</a> contributors',
                maxZoom: 18
            }).addTo(map);

            var geocodeService = L.esri.Geocoding.geocodeService();

            map.on('click', function(e) {
                geocodeService.reverse().latlng(e.latlng).run(function(error, result) {
                    L.marker(result.latlng).addTo(map).bindPopup(result.address.Match_addr).openPopup();
                });
            });

            // GEOCODE CONTROL
            var searchControl = L.esri.Geocoding.geosearch({position:'topright'}).addTo(map);

            var results = L.layerGroup();

            searchControl.on('results', function(data){
                results.clearLayers();
                for (var i = data.results.length - 1; i >= 0; i--) {
                    results.addLayer(L.marker(data.results[i].latlng));
                }
            });
            results.addTo(map);

            /*

            var data = [

            {
                "title": 'Chennai',
                "lat": '-20.191340',
                "lng": '57.718990',
                "description": '',
                "flag":'1'
            }
            ,
            {
            "title": 'Ramapuram',
            "lat": '-20.206120',
            "lng": '57.749620',
            "description": '',

            },

            {
                "title": 'Kanchipuram',
                "lat": '-20.220740',
                "lng": '57.776270',
                "description": '',
                "flag":'1'
            },

            ];

            var routeControl = L.Routing.control({

            }).addTo(map);
            routeControl.setWaypoints(data);

            */

            L.Routing.control({
                waypoints: [
                    L.latLng(-20.220740, 57.776270),
                    L.latLng(-20.206120, 57.749620)
                ]
            }).addTo(map);
        </script>
    </body>
</html>