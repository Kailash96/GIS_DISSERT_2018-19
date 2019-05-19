var crr_level_domestic = 0, crr_level_plastic = 0, crr_level_paper = 0, crr_level_other = 0;

function level_update(user_id, generator_type, act){
    var data_send = "userID=" + user_id + "&act=" + act;

    if (act == 1) {
        var bin_capacity = 0;
        if (generator_type == 'citizen') {
            bin_capacity = 20;
        } else {
            bin_capacity = 80;
        }

        var domestic_level = document.getElementById("domestic_level").value;
        crr_level_domestic = domestic_level;

        // CONVERT TO PERCENTAGE
        domestic_level = parseInt((domestic_level / bin_capacity) * 100);

        var plastic_level = document.getElementById("plastic_level").value;
        crr_level_plastic = plastic_level;

        plastic_level = parseInt((plastic_level / bin_capacity) * 100);

        var paper_level = document.getElementById("paper_level").value;
        crr_level_paper = paper_level;
        
        paper_level = parseInt((paper_level / bin_capacity) * 100);
        
        var other_level = document.getElementById("other_level").value;
        crr_level_other = other_level;
        
        other_level = parseInt((other_level / bin_capacity) * 100);

        data_send += "&domestic_level=" + domestic_level + "&plastic_level=" + plastic_level + "&paper_level=" + paper_level + "&other_level=" + other_level;
    }

    var fetch_update = new XMLHttpRequest();
    fetch_update.onreadystatechange = function(){
        if (this.readyState == 4 && this.status == 200) {
            var data = JSON.parse(this.responseText);
            if (data[0] == "false"){
                // data[1] = domestic level
                var domestic_level_in_kg = parseInt((data[1] / 100) * 20);
                
                crr_level_domestic = domestic_level_in_kg;

                // get previous value
                var prev_value_domestic = document.getElementById('domestic_level').value;
                document.getElementById('domestic_level').value = domestic_level_in_kg;
                range_check_update('domestic', prev_value_domestic, domestic_level_in_kg);

                // data[2] = plastic level
                var plastic_level_in_kg = parseInt((data[2] / 100) * 20);

                crr_level_plastic = plastic_level_in_kg;

                // get previous value
                var prev_value_plastic = document.getElementById('plastic_level').value;
                document.getElementById('plastic_level').value = plastic_level_in_kg;
                range_check_update('plastic', prev_value_plastic, plastic_level_in_kg);

                // data[3] = paper level
                var paper_level_in_kg = parseInt((data[3] / 100) * 20);

                crr_level_paper = paper_level_in_kg;

                // get previous value
                var prev_value_paper = document.getElementById('paper_level').value;
                document.getElementById('paper_level').value = paper_level_in_kg;
                range_check_update('paper', prev_value_paper, paper_level_in_kg);

                // data[4] = other level
                var other_level_in_kg = parseInt((data[4] / 100) * 20);

                crr_level_other = other_level_in_kg;

                // get previous value
                var prev_value_other = document.getElementById('other_level').value;
                document.getElementById('other_level').value = other_level_in_kg;
                range_check_update('other', prev_value_other, other_level_in_kg);

            } else {
                // DISPLAY CHANGES SAVED BUTTON
                $("#savechanges").css('display', 'none');
                $("#changessaved").css('display', 'inline');
                setTimeout(function (){
                    $("#changessaved").fadeOut();
                }, 2000);
            }
        }
    }
    fetch_update.open("POST", "update_bin.php", true);
    fetch_update.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    fetch_update.send(data_send);

}

function inc_dec_level(bin_type, crr_value, act){
    var new_value;
    if (act == 1) {
        // increment
        new_value = document.getElementById(bin_type + "_level").value = parseInt(crr_value) + 1;
        range_check_update(bin_type, crr_value, new_value);
        save_request();
    } else {        
        // decrement
        new_value = document.getElementById(bin_type + "_level").value = parseInt(crr_value) - 1;
        range_check_update(bin_type, crr_value, new_value);
        save_request();
    }
}

function range_check_update(bin_type, prev_value, updated_value){
    if (updated_value > 20) {
        document.getElementById(bin_type + "_level").value = 20;
        update_circular_level(bin_type, prev_value, 20);
    } else if (updated_value < 0) {
        document.getElementById(bin_type + "_level").value = 0;
        update_circular_level(bin_type, prev_value, 0);
    } else if (updated_value < parseInt(eval("crr_level_" + bin_type))) {
        document.getElementById(bin_type + "_level").value = eval("crr_level_" + bin_type);
        update_circular_level(bin_type, prev_value, eval("crr_level_" + bin_type));
    } else {
        update_circular_level(bin_type, prev_value, updated_value);
    }
}

function update_circular_level(bin_type, prev_value, updated_value){
    var element = document.getElementById(bin_type + "_circle");

    var prev_percentage_level = parseInt((prev_value / 20) * 100);
    var updated_percentage_level = parseInt((updated_value / 20) * 100);

    document.getElementById(bin_type + "_level_p").innerHTML = updated_percentage_level + "%";
    element.classList.remove("p" + prev_percentage_level);
    element.classList.add("p" + updated_percentage_level);

    document.getElementById(bin_type + "_prev_level").value = updated_value;
    document.getElementById(bin_type + "_bin_status").innerHTML = updated_value + "/20 kg";
    
}

// CHECK IF COORDINATE IS IN ZONE
function inside(point, vs) {

    var x = point[0];
    var y = point[1];

    var inside = false;
    for (var i = 0, j = vs.length - 1; i < vs.length; j = i++) {
        var xi = vs[i][0];
        var yi = vs[i][1];
        var xj = vs[j][0];
        var yj = vs[j][1];
        
        var intersect = ((yi > y) != (yj > y))
        && (x < (xj - xi) * (y - yi) / (yj - yi) + xi);
        if (intersect) inside = !inside;
    }

    return inside;

};

function save_request(){
    $("#savechanges").css('display', 'inline');
    $("#changessaved").css('display', 'none');
}