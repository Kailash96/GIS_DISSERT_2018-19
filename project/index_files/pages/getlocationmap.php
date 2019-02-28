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
      #map {
        height:100%;
      }
    </style>
  </head>
  <body>
  <div class="map-holder">
    <div id="map"></div>
  </div>
        <script>
            var map = L.map('map', {
              center: [-20.197960, 57.721996],
              zoom: 12
            });

            // https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://osm.org/copyright">OpenStreetMap</a> contributors',
                maxZoom: 15
            }).addTo(map);
            
            /*
            var geocodeService = L.esri.Geocoding.geocodeService();

            map.on('click', function(e) {
                geocodeService.reverse().latlng(e.latlng).run(function(error, result) {
                    L.marker(result.latlng).addTo(map).bindPopup(result.address.Match_addr).openPopup();
                    console.log(result.latlng);
                });
            });
            */

            // GEOCODE CONTROL
            /*
            var searchControl = L.esri.Geocoding.geosearch({position:'topright'}).addTo(map);

            searchControl.on('results', function(data){
                // results.clearLayers();
                // for (var i = data.results.length - 1; i >= 0; i--) {
                    // results.addLayer(L.marker(data.results[0].latlng));
                    L.marker(data.latlng).addTo(map);
                    console.log(data.latlng);
                // }
                
            });
            */
            // results.addTo(map);
            

            // TRIAL
            /*
            var searchPlace = 'TAGOR ROAD, FLACQ, MAURITIUS';
            L.esri.Geocoding.geocode().text(searchPlace).run(function(err, result, response){
              console.log(result.results[0].latlng);
              L.marker(result.results[0].latlng).addTo(map);
            });
            */

            // var result_layer = L.layerGroup().addTo(map);
            // FULLY FUNCTIONAL
            var prevMarker = "";
            function searchLoc(country_val, address_val, region_val){
              console.log(
                "country: " + country_val,
                "address: " + address_val,
                "region: " + region_val,
              );
              // GEOCODE
              L.esri.Geocoding.geocode().text(address_val + ' ' + region_val + ' ' + country_val).run(function(err, result, response){
                // result_layer.clearLayers();
                console.log(result.results[0].latlng);
                console.log(result.results.length);
                // result_layer.addLayer(
                  if (prevMarker != ""){
                    map.removeLayer(prevMarker);
                  }
                  
                  prevMarker = L.marker(result.results[0].latlng, {draggable:'true'}).addTo(map);
                  var position = prevMarker.getLatLng();
                  var reformat = position.lat + "," + position.lng;
                  map.setView([position.lat, position.lng], 16);
                  setValue(reformat);

                  prevMarker.on('dragend', function(event){
                    position = prevMarker.getLatLng();
                    // function to set value in input type hidden
                    reformat = position.lat + "," + position.lng;
                    map.setView([position.lat, position.lng], 16);
                    setValue(reformat);
                  });
                // );
              });
              
            };
            
        </script>
  </body>
</html>