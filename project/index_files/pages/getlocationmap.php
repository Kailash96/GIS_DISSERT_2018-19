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
  <div class="map-holder" style="position:relative">
    <div style="display:flex;flex-direction:column;position:absolute;top:10px;right:10px;z-index:2">
      <input type="hidden" name="country" value="Mauritius" />
      <select class="input-box" name="region" onchange="validate_step_2()" required>
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
      <!-- <input type="text" name="region" placeholder="Region" autocomplete="off" style="width:100%;text-transform:capitalize" class="input-box" required /> -->
      <input type="text" name="address" onkeyup="validate_step_2()" placeholder="Address" autocomplete="off" style="width:100%;text-transform:capitalize" class="input-box" required /><br/>
      <input type="button" onclick="searchLoc('Mauritius', address.value, region.value)" value="Set my Location" class="submit_button" style="background-color:white;padding:8px 0;margin:0;width:100%" /><br/>
      <input type="submit" class="submit_button" name="reg" value="Register" style="background-color:white;width:100%" />
    </div>
    <div id="map" style="z-index:1"></div>
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

            // var result_layer = L.layerGroup().addTo(map);
            // FULLY FUNCTIONAL
            var prevMarker = "";
            function searchLoc(country_val, address_val, region_val){
              if (validate_step_2()){
                // GEOCODE
                L.esri.Geocoding.geocode().text(address_val + ' ' + region_val + ' ' + country_val).run(function(err, result, response){
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

              }
              
              
            };
            
        </script>
  </body>
</html>