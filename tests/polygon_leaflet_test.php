<!DOCTYPE html>
<html>
<head>

<title></title>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.0.3/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.0.3/dist/leaflet.js"></script>

<style>
html, body, #map {
  padding: 0;
  margin: 0;
  height: 100%;
  width: 100%;
}
</style>
</head>
 <body>   

<div id="map"></div>
    <script>
        var map = L.map('map').setView([48,-3], 7); 

        // var osm=new L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png',{attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors'});
        var osm=new L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png',{attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors'});
        osm.addTo(map);

        // var marker = L.marker([-20.194824,57.722979]).addTo(map);
        // var marker = L.marker([-20.168215, 57.734981]).addTo(map);


        // var coords =  '[[48,-3],[50,5],[44,11],[48,-3]]';
        var coords =  '[[-20.165590, 57.736680],  [-20.200344,57.757233],  [-20.213680,57.702259], [-20.171716,57.712306], [-20.165590, 57.736680]]';
        var coords_json = JSON.parse(coords);
        // var coords = document.getElementById("coordPolygon").value;

        var polygon = L.polygon(coords_json, {color: 'red'});
        polygon.addTo(map);

        map.fitBounds(polygon.getBounds());

        var popup = L.popup();
        map.on('click', onMapClick);

        
        function onMapClick(e){
            // var contained = polygon.getBounds().contains(e.latlng);
            // var message = contained ? "INSIDE the polygon!" : "NOT inside the polygon.";
            alert(inside([e.latlng.lat, e.latlng.lng], coords_json));
        }

        function inside(point, vs) {
            var x = point[0], y = point[1];

            var inside = false;
            for (var i = 0, j = vs.length - 1; i < vs.length; j = i++) {
                var xi = vs[i][0], yi = vs[i][1];
                var xj = vs[j][0], yj = vs[j][1];

                var intersect = ((yi > y) != (yj > y))
                    && (x < (xj - xi) * (y - yi) / (yj - yi) + xi);
                if (intersect) inside = !inside;
            }

            return inside;
        };

        var polygon = "[[4040958.21,261090.239],[4399737.773,261090.239],  [4399737.773,1004118.285],[4040958.21,1004118.285]]";
        var poly_json = JSON.parse(polygon);

        <!--// The below are two examples.  One of them is inside the other is outside to bounding box
        // inside -->
        test = inside([ 4147263, 646445.066 ], poly_json); // true
        <!-- // outside -->
        <!--
        // test = inside([ 4537048, 694061 ], polygon); // false
        -->
        
    </script>
</body>
</head>
</html>