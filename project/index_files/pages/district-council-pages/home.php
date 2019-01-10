<!DOCTYPE html>
<html>
    <head>
        <title>Home | Binswiper</title>
        <link rel="stylesheet" href="../../css_files/style.css" />

        <!-- ARCGIS CONNECTION -->
        <link rel="stylesheet" href="https://js.arcgis.com/4.9/esri/css/main.css">
        <script src="https://js.arcgis.com/4.9/"></script>

        <style>
            #viewDiv {
                padding:0;
                margin:0;
                height: 600px;
                width: 1090px;
            }

            #home_selected{
                background-color:#002246;
                color:white;
            }
        </style>

        <script>  
            require([
            "esri/Map",
            "esri/views/MapView",      
            "esri/Graphic",
            "esri/tasks/RouteTask",
            "esri/tasks/support/RouteParameters",
                "esri/tasks/support/FeatureSet",
            "dojo/domReady!"
            ], function(Map, MapView, Graphic, RouteTask, RouteParameters, FeatureSet) {

            var map = new Map({
                basemap: "osm" //"streets-navigation-vector"
            });
            
            var view = new MapView({
                container: "viewDiv",
                map: map,
                center: [57.721996, -20.197960],
                zoom: 15
            });
            
            // To allow access to the route service and prevent the user from signing in, do the Challenge step in the lab to set up a service proxy
            
            var routeTask = new RouteTask({
                url: "https://route.arcgis.com/arcgis/rest/services/World/Route/NAServer/Route_World"
            });

            view.on("click", function(event){
                if (view.graphics.length === 0) {
                addGraphic("start", event.mapPoint);
                } else if (view.graphics.length === 1) {
                addGraphic("finish", event.mapPoint);
                // Call the route service
                getRoute();
                } else {
                view.graphics.removeAll();
                addGraphic("start",event.mapPoint);
                }
            });
            
            function addGraphic(type, point) {
                var graphic = new Graphic({
                symbol: {
                    type: "simple-marker",
                    color: (type === "start") ? "white" : "black",
                    size: "8px"
                },
                geometry: point
                });
                view.graphics.add(graphic);
            }
            
            function getRoute() {
                // Setup the route parameters
                var routeParams = new RouteParameters({
                stops: new FeatureSet({
                    features: view.graphics
                }),
                returnDirections: true
                });
                // Get the route
                routeTask.solve(routeParams).then(function(data) {
                data.routeResults.forEach(function(result) {
                    result.route.symbol = {
                    type: "simple-line",
                    color: [5, 150, 255],
                    width: 3
                    };
                    view.graphics.add(result.route); 
                });
                
                });
            }
            
            });
        </script>
    </head>
    <body>
        <?php include("left_side_nav_bar.html"); ?>
        <?php include("top-nav-bar.html"); ?>
        
        <div id="viewDiv"></div>
    </body>
</html>