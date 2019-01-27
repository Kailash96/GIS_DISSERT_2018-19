<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="initial-scale=1, maximum-scale=1,user-scalable=no"/>
    <title>Simple Map</title>
    <link rel="stylesheet" href="https://js.arcgis.com/3.27/esri/css/esri.css">
    <style>
      html, body, #map {
        height: 100%;
        margin: 0;
        padding: 0;
      }
    </style>
    <script src="https://js.arcgis.com/3.27/"></script>
    <script>
      var map;

      require([
          "esri/map",
          "dojo/domReady!",
          "esri/graphic"
        ], function(Map, Graphic) {
        
            map = new Map("map", {
            basemap: "osm",  //For full list of pre-defined basemaps, navigate to http://arcg.is/1JVo6Wd
            center: [-111.4453125,37.96875], // longitude, latitude
            zoom: 11
            });

            var myPolygon = {"geometry":{"rings":[[[-115.3125,37.96875],[-111.4453125,37.96875],
            [-99.84375,36.2109375],[-99.84375,23.90625],[-116.015625,24.609375],
            [-115.3125,37.96875]]],"spatialReference":{"wkid":4326}},
            "symbol":{"color":[0,0,0,64],"outline":{"color":[0,0,0,255],
            "width":1,"type":"esriSLS","style":"esriSLSSolid"},
            "type":"esriSFS","style":"esriSFSSolid"}};
            
            var gra = new Graphic(myPolygon);

            map.graphics.add(gra);
        
        });
    </script>
  </head>

  <body>
    <div id="map"></div>
  </body>
</html>