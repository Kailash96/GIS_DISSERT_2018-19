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
        domestic_level = parseInt((domestic_level / bin_capacity) * 100);
        var plastic_level = document.getElementById("plastic_level").value;
        plastic_level = parseInt((plastic_level / bin_capacity) * 100);
        var paper_level = document.getElementById("paper_level").value;
        paper_level = parseInt((paper_level / bin_capacity) * 100);
        var other_level = document.getElementById("other_level").value;
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
                // get previous value
                var prev_value_domestic = document.getElementById('domestic_level').value;
                document.getElementById('domestic_level').value = domestic_level_in_kg;
                range_check_update('domestic', prev_value_domestic, domestic_level_in_kg);
                // data[2] = plastic level
                // data[3] = paper level
                // data[4] = other level
                console.log(data[5]);
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
    } else {
        // decrement
        new_value = document.getElementById(bin_type + "_level").value = parseInt(crr_value) - 1;
        range_check_update(bin_type, crr_value, new_value);
    }             
}

function range_check_update(bin_type, prev_value, updated_value){
    if (updated_value > 20) {
        document.getElementById(bin_type + "_level").value = 20;
        update_circular_level(bin_type, prev_value, 20);
    } else if (updated_value < 0) {
        document.getElementById(bin_type + "_level").value = 0;
        update_circular_level(bin_type, prev_value, 0);
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