<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">

    
    <meta name="viewport" content="initial-scale=1, maximum-scale=1,user-scalable=no">
    <title>Shapes and Symbols</title>

    <link rel="stylesheet" href="https://js.arcgis.com/3.27/esri/css/esri.css">

    <style>
      #info {
        top: 20px;
        color: #444;
        height: auto;
        font-family: arial;
        right: 20px;
        margin: 5px;
        padding: 10px;
        position: absolute;
        width: 115px;
        z-index: 40;
        border: solid 2px #666;
        border-radius: 4px;
        background-color: #fff;
      }
      html, body, #mapDiv {
        padding:0;
        margin:0;
        height:100%;
      }
      button {
        display: block;
      }
    </style>

    <script src="https://js.arcgis.com/3.27/"></script>
    <script>
      var map, tb;

      require([
        "esri/map", "esri/toolbars/draw",
        "esri/symbols/SimpleMarkerSymbol", "esri/symbols/SimpleLineSymbol",
        "esri/symbols/PictureFillSymbol", "esri/symbols/CartographicLineSymbol", 
        "esri/graphic", 
        "esri/Color", "dojo/dom", "dojo/on", "dojo/domReady!"
      ], function(
        Map, Draw,
        SimpleMarkerSymbol, SimpleLineSymbol,
        PictureFillSymbol, CartographicLineSymbol, 
        Graphic, 
        Color, dom, on
      ) {
        map = new Map("mapDiv", {
          basemap: "osm",
          center: [-25.312, 34.307],
          zoom: 3
        });
        map.on("load", initToolbar);

       

        // fill symbol used for extent, polygon and freehand polygon, use a picture fill symbol
        // the images folder contains additional fill images, other options: sand.png, swamp.png or stiple.png
        var fillSymbol = new PictureFillSymbol(
            new SimpleLineSymbol(
            SimpleLineSymbol.STYLE_SOLID,
            new Color('#000'), 
            1
          ), 
          42, 
          42
        );

        function initToolbar() {
          tb = new Draw(map);
          tb.on("draw-end", addGraphic);

          // event delegation so a click handler is not
          // needed for each individual button
          on(dom.byId("info"), "click", function(evt) {
            if ( evt.target.id === "info" ) {
              return;
            }
            var tool = evt.target.id.toLowerCase();
            map.disableMapNavigation();
            tb.activate(tool);
          });
        }

        function addGraphic(evt) {
          //deactivate the toolbar and clear existing graphics 
          tb.deactivate(); 
          map.enableMapNavigation();

          // figure out which symbol to use
          var symbol = fillSymbol;

          map.graphics.add(new Graphic(evt.geometry, symbol));
        }
      });
    </script>
  </head>
  
  <body>
    
    <div id="info">
      <div>Select a shape then draw on map to add graphic</div>
      <button id="Polygon">Polygon</button>
    </div>

    <div id="mapDiv"></div>

  </body>
</html>