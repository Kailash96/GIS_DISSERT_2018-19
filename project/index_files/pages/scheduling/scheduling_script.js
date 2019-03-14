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
                tripMaker(response);
            }
        }
    }
    savetodb.open("POST", "scheduling_script.php", true);
    savetodb.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    savetodb.send("act=savetodb" + "&data=" + JSON.stringify(datatosave));

}

function tripMaker(amount_array){

    var setup = new XMLHttpRequest();
    setup.onreadystatechange = function(){
        if (this.readyState == 4 && this.status == 200) {
            var response = JSON.parse(this.responseText);
            console.log(response);
        }
    }
    setup.open("POST", "scheduling_script.php", true);
    setup.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    setup.send("act=setTrips" + "&waste_amount_per_user=" + amount_array);

}