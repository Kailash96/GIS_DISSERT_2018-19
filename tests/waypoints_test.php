<!DOCTYPE HTML>
<html>
<head>

<link rel="stylesheet" href="https://unpkg.com/leaflet@1.4.0/dist/leaflet.css"
   integrity="sha512-puBpdR0798OZvTTbP4A8Ix/l+A4dHDD0DGqYW6RQ+9jxkRFclaxxQb/SJAWZfWAkuyeQUytO7+7N4QKrDh+drA=="
   crossorigin=""/>
   <script src="https://unpkg.com/leaflet@1.4.0/dist/leaflet.js"
   integrity="sha512-QVftwZFqvtRNi0ZyCtsznlKSWOStnDORoefr1enyq5mVL4tmKB3S/EnC3rRJcxCPavG10IcrVGSmPh6Qw5lwrg=="
   crossorigin=""></script>

   <link rel="stylesheet" href="https://unpkg.com/leaflet@1.2.0/dist/leaflet.css" />
<link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine@latest/dist/leaflet-routing-machine.css" />
<script src="https://unpkg.com/leaflet@1.2.0/dist/leaflet.js"></script>
<script src="https://unpkg.com/leaflet-routing-machine@latest/dist/leaflet-routing-machine.js"></script>
   <style>
    #map { height: 500px; }
   </style>
</head>
<body>
        

<div id="map"></div>
<script>
    var map = L.map('map').setView([-20.220740, 57.776270], 13);

    L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);


    var data = [

{
    "lat": '-20.191340',
    "lng": '57.718990'
},

{
    "lat": '-20.206120',
    "lng": '57.749620'
},

{
    "lat": '-20.220740',
    "lng": '57.776270'
},

{
    "lat": '-20.213680',
    "lng": '57.702260'
},

{
    "lat": '-20.227010',
    "lng": '57.742130'
},

];
    var routeControl = L.Routing.control({
    }).addTo(map);
    routeControl.setWaypoints(data);

</script>

</body>
</html>