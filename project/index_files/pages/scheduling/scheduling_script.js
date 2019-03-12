function schedule(){
    var getCoords = new XMLHttpRequest();
    getCoords.onreadystatechange = function(){
        if (this.readyState == 4 && this.status == 200){
            var getRoute = JSON.parse(this.responseText);
            console.log(getRoute[0][1]);
            // save to db()
        }
    }
    getCoords.open("POST", "scheduling_script.php", true);
    getCoords.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    getCoords.send("act=getRoute");
}