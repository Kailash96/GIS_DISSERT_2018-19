function getLocations(){
    var getCoords = new XMLHttpRequest();
    getCoords.onreadystatechange = function(){
        if (this.readyState == 4 && this.status == 200){
            var getData = JSON.parse(this.responseText);

            // travellingSalesman(getData);
            console.log(getData);
            
        }
    }
    getCoords.open("POST", "scheduling_script.php", true);
    getCoords.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    getCoords.send("act=getRoute");

}

function travellingSalesman(data) {
    var tsp = new XMLHttpRequest();
    tsp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var response = JSON.parse(this.responseText);
            save_tbl_route(response);
        }
    }
    tsp.open("POST", "tsp.php", true);
    tsp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    tsp.send("data=" + JSON.stringify(data));
}

function save_tbl_route(datatosave){

    var savetodb = new XMLHttpRequest();
    savetodb.onreadystatechange = function(){
        if (this.readyState == 4 && this.status == 200) {
            var response = JSON.parse(this.responseText);
            if (response != "error") {
                var response = JSON.parse(this.responseText);
                if (response == 1){
                    tripMaker();
                }
            }
        }
    }
    savetodb.open("POST", "scheduling_script.php", true);
    savetodb.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    savetodb.send("act=savetodb" + "&data=" + JSON.stringify(datatosave));

}

function tripMaker(){

    var setup = new XMLHttpRequest();
    setup.onreadystatechange = function(){
        if (this.readyState == 4 && this.status == 200) {
            var tripArray = JSON.parse(this.responseText);
            configure_trip(tripArray);
        }
    }
    setup.open("POST", "scheduling_script.php", true);
    setup.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    setup.send("act=setTrips");

}

// GET TRIP ARRAY, CALCULATES DURATION OF EACH TRIPS AND STORES TO DB
function configure_trip(trip_array){

    var trip = [];
    // lOOP FOR EACH TRIP
    for (var t = 0; t < trip_array.length; t++) {
        var total_duration = 0;
        var total_distance = 0;
        // LOOP FOR EACH COORDINATE IN THE TRIP
        for (var TA = 1; TA < trip_array[t][0].length; TA++) {
            var pointA = trip_array[t][0][TA - 1].split(",");
            var pointB = trip_array[t][0][TA].split(",");
            var collection_delay = 3; // 3MINS COLLECTION TIME BUFFER
            total_duration = (getDuration(pointA, pointB) + collection_delay); // IN MINS
            total_distance += getDistance(pointA, pointB) / 1000; // IN KM
        }

        if (total_duration == 0) {
            total_duration = 3; // COLLECTION DELAY
        }

        trip.push([]);
        trip[t].push(trip_array[t][0], trip_array[t][1], trip_array[t][2], trip_array[t][3], trip_array[t][0].length, total_duration, total_distance);
    }

    save_to_tbl_trips(trip);
}

function getDuration(point1, point2) {
    const speed = 30; // 50 km/hr
    // change distance to KM
    var distance = getDistance(point1, point2) / 1000;
    var duration = distance / speed;
    duration = duration * 60; // CONVERT TO MINS
    return duration;
}

function getDistance(origin, destination) {
    // return distance in meters
    var lon1 = toRadian(origin[1]),
        lat1 = toRadian(origin[0]),
        lon2 = toRadian(destination[1]),
        lat2 = toRadian(destination[0]);

    var deltaLat = lat2 - lat1;
    var deltaLon = lon2 - lon1;

    var a = Math.pow(Math.sin(deltaLat/2), 2) + Math.cos(lat1) * Math.cos(lat2) * Math.pow(Math.sin(deltaLon/2), 2);
    var c = 2 * Math.asin(Math.sqrt(a));
    var EARTH_RADIUS = 6371;
    return c * EARTH_RADIUS * 1000;
}

function toRadian(degree) {
    return degree*Math.PI/180;
}

function save_to_tbl_trips(trips_array) {
    var trips = new XMLHttpRequest();
    trips.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var response = JSON.parse(this.responseText);

            if (response == 1) {
                update_schedule();
            }

        }
    }
    trips.open("POST", "scheduling_script.php", true);
    trips.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    trips.send("act=saveTrips" + "&trips=" + JSON.stringify(trips_array));
}

function update_schedule() {
    var workingHrs = 120; // IN MINS (2HOURS)
    var startTime = "5:00"; // 5am

    var schedule = new XMLHttpRequest();
    schedule.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            var response = JSON.parse(this.responseText);
            console.log(response);
        }
    }
    schedule.open("POST", "scheduling_script.php", true);
    schedule.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    schedule.send("act=scheduling" + "&workingHours=" + workingHrs + "&starttime=" + startTime);

}