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
                    document.getElementById("LORequests").innerHTML = dataValue[1];
                } else if (dataValue[0] == 0) {
                    document.getElementById("counter").style.visibility = "hidden";
                }                  
            }
        }
        xmlhttp.open("POST", "checkRequest.php", true);
        xmlhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xmlhttp.send("checker=" + current_value);
    }
    setInterval(update, 100);
</script>


<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<div class="left-nav-bar">
    <img src="../../img/logo.jpg" style="width:200px;" />
    <h4 style="background-color:#00802D;color:white;display:inline-block;width:164px;padding:3px 3px 4px 3px;border-radius:2px;box-shadow:0 0 3px black"><i style="color:white;margin-right:12px" class="fa fa-user-o"></i>Administrator</h4>
    <ul>
        <li><a href="admin-home.php" id="home_selected"><i class="logo_space fa fa-cubes"></i> Dashboard</a></li>
        <li><a href="register_new_user.php" id="register_selected"><i class="logo_space fa fa-address-book-o"></i> Register New User</a></li>
        <li><a href="user-management.php" id="user_mngt_selected"><i class="logo_space fa fa-group"></i> User Management</a></li>
        <li><a href="zone_management.php" id="zone_mngt_selected"><i class="logo_space fa fa-map-o"></i> Zones Management</a></li>
        <li><a href="requests_management.php" id="requests_selected"><i class="logo_space fa fa-bell-o"></i> Requests <span style="background-color:red;padding:0px 6px 0px 5px;border-radius:3px;color:white;" id="counter"></span></a></li>
        <li><a href="register-employee.php" id="register-employee_selected"><i class="logo_space fa fa-address-card-o"></i> Employee Management</a></li>
    </ul>
</div>