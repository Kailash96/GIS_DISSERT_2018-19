<?php
    include("../../../db_connect.php");
    
    $commercialCount = 0;
    $industrialCount = 0;
    $residentsCount = 0;

    $queryResidents = "SELECT * FROM residents WHERE Active = 0";
    
    if ($result = mysqli_query($conn, $queryResidents)){
        $residentsCount = mysqli_num_rows($result);
    } else {
        echo 'no result';
    }

    $numOfReq = $residentsCount + $commercialCount + $industrialCount;
?>

<script type="text/javascript">
    function update(){
        var current_value = <?php echo $numOfReq; ?>;
        var countValue = 0;
        if (window.XMLHttpRequest){
            xmlhttp = new XMLHttpRequest();
        } else {
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function(){
            if (this.readyState == 4 && this.status == 200){
                var countedValue = this.responseText;
                if ((countedValue > 0) && (countValue != current_value)){
                    document.getElementById("counter").style.visibility = "visible";
                    document.getElementById("counter").innerHTML = countedValue;
                    countValue = countedValue;
                } else {
                    document.getElementById("counter").style.visibility = "hidden";
                }                  
            }
        }
        xmlhttp.open("POST", "checkRequest.php", true);
        xmlhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xmlhttp.send("checker=" + current_value);
    }
    setInterval(update, 1000);
</script>


<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<div class="left-nav-bar">
    <h1 style="padding:10px 0;margin:0;background-color:#002246;color:white"><i class="fa fa-trash-o"></i> Binswiper</h1>
    <h3 style="color:green">Administrator</h3>
    Navigations
    <ul>
        <li><a href="admin-home.php" id="home_selected"><i class="fa fa-home" id="home"></i> Home</a></li>
        <li><a href="register_new_user.php" id="register_selected"><i class="fa fa-address-book-o" id="registeruser"></i> Register New User</a></li>
        <li><a href=""><i class="fa fa-group"></i> User Management</a></li>
        <li><a href=""><i class="fa fa-bell-o"></i> Requests <span style="background-color:red;padding:0px 6px 0px 5px;border-radius:3px;color:white;" id="counter"></span></a></li>
        <li><a href="register-employee.php" id="register-employee_selected"><i class="fa fa-address-card-o"></i> Employee Management</a></li>
        <li><a href=""><i class="fa fa-cogs"></i> Settings</a></li>
    </ul>
</div>