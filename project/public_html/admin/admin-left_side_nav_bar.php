<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<style>
    #counter{
        visibility:hidden;
    }

    #notif_icon{
        display:none;
    }
</style>
<script type="text/javascript">
    var current_value = 0;
    function update(){
        if (window.XMLHttpRequest){
            xmlhttp = new XMLHttpRequest();
        } else {
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function(){
            if (this.readyState == 4 && this.status == 200){
                var dataValue = JSON.parse(this.responseText);
                if ((dataValue[0] > 0) && (dataValue[0] != current_value)){
                    document.getElementById("counter").style.visibility = "visible";
                    document.getElementById("counter").innerHTML = dataValue[0];
                    current_value = dataValue[0];
                    if (document.getElementById("LORequests")) {
                        // DISPLAY LIST OF DATA
                        document.getElementById("LORequests").innerHTML = dataValue[1];
                    }
                } else if (dataValue[0] == 0) {
                    document.getElementById("counter").style.visibility = "hidden";
                }                  
            }
        }
        // RETRIEVE FROM CHECKREQUEST.PHP PAGE
        xmlhttp.open("POST", "checkRequest.php", true);
        xmlhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xmlhttp.send("checker=" + current_value);
    }

    // EXECUTE UPDATE FUNCTION EVERY 2 SECONDS
    setInterval(update, 2000);

    function getNoZone(){
        var nozoner = new XMLHttpRequest();
        nozoner.onreadystatechange = function(){
            if (this.readyState == 4 && this.status == 200){
                var counter = JSON.parse(this.responseText);
                if (counter > 0) {
                    $("#notif_icon").fadeIn();
                    if (document.getElementById("no_zone_users_counter")) {
                        document.getElementById("no_zone_users_counter").innerHTML = counter;
                    }
                }
            }
        }
        nozoner.open("POST", "count_no_zoner.php", true);
        nozoner.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        nozoner.send();
    }
    getNoZone();
</script>

<div class="left-nav-bar">
    <img src="../index_files/img/logo.jpg" style="width:200px;" />
    <h4 style="color:#00802D;display:inline-block;width:164px;padding:3px 3px 4px 3px;border-radius:3px;box-shadow:0 0 2px black"><i style="color:#00802D;margin-right:12px" class="fa fa-user-o"></i>Administrator</h4>
    <ul>
        <li><a href="admin-home.php" id="home_selected"><i class="logo_space fa fa-bar-chart"></i> Dashboard</a></li>
        <li><a href="user-management.php" id="user_mngt_selected"><i class="logo_space fa fa-group"></i> User Management</a></li>
        <li><a href="collectors.php" id="collectors_selected"><i class="logo_space fa fa-child"></i> Collectors</a></li>
        <li><a href="zone_management.php" id="zone_mngt_selected"><i class="logo_space fa fa-map-o"></i> Regions / zones <i class="material-icons" id='notif_icon' style='font-size:13px;color:red'>&#xe7f7;</i></a></li>
        <li><a href="requests_management.php" id="requests_selected"><i class="logo_space fa fa-bell-o"></i> Requests <span style="background-color:red;padding:0px 6px 0px 5px;border-radius:3px;color:white;" id="counter"></span></a></li>
        <li><a href="register-employee.php" id="register-employee_selected"><i class="logo_space fa fa-address-card-o"></i> Manage Employee</a></li>
    </ul>
</div>