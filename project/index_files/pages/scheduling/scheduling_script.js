function schedule(){
    var getCoords = new XMLHttpRequest();
    getCoords.onreadystatechange = function(){
        if (this.readyState == 4 && this.status == 200){
            var response = JSON.parse(this.responseText);
            console.log(response);
        }
    }
    getCoords.open("POST", "scheduling_script.php", true);
    getCoords.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    getCoords.send();
}