function schedule(){
    var getCoords = new XMLHttpRequest();
    getCoords.onreadystatechange = function(){
        if (this.readyState == 4 && this.status == 200){
            var getData = JSON.parse(this.responseText);

            // REARRANGE ROUTE IN OPTIMIZED ROUTE
            // TO REARRANGE array amount along with location array;
            // function optimizeRoute(); should return an array to send in save_tbl_route function

            // SAVE IN DB
            save_tbl_route(getData);
            
            // only for testing
            // tripMaker(0);
        }
    }
    getCoords.open("POST", "scheduling_script.php", true);
    getCoords.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    getCoords.send("act=getRoute");

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
            var response = JSON.parse(this.responseText);
            if (response == 1) {
                configure_trip();
            }
        }
    }
    setup.open("POST", "scheduling_script.php", true);
    setup.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    setup.send("act=setTrips");

}

// GET TRIP ARRAY AND CALCULATES DURATION OF EACH TRIPS
function configure_trip(){
    var getTrips = new XMLHttpRequest();
    getTrips.onreadystatechange = function(){
        if (this.readyState == 4 && this.status == 200){
            var trip_array = JSON.parse(this.responseText);
            console.log(trip_array);
        }
    }
    getTrips.open("POST", "scheduling_script.php", true);
    getTrips.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    getTrips.send("act=getTrips");
}