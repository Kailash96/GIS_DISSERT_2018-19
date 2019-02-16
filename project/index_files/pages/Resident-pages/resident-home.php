<!DOCTYPE HTML>
<html>
    <head>
        <title>Home | Binswiper</title>
        <link type="text/css" rel="stylesheet" href="../../css_files/resident-css.css" />
        <link type="text/css" rel="stylesheet" href="../../css_files/circle.css" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <?php
            session_start();
            if (!isset($_SESSION['userID'])) {
                header('location: ../../../index.php');
            }
        ?>
        <style>
            .bins_box{
                box-shadow:0 0 4px #002246;
                padding:10px;
                margin:10px 10px;
                border-radius:3px;
                width:48%;
            }

            .bins_box > div h3{
                margin:0;
            }

            .button{
                background-color:white;
                border:1px solid red;
                cursor:pointer;
                padding:5px 10px;
                border-radius:3px;
                color:red;
            }

            .all_bins_container{
                display:flex;
                flex-wrap: wrap;
            }

            input[type=number]::-webkit-inner-spin-button, 
            input[type=number]::-webkit-outer-spin-button { 
                -webkit-appearance: none;
            }

            input[type=number]{
                text-align:center;
                outline:none;
                height:34px;
                border-radius:3px;
                border:1px solid #A0A0A0;
            }

            .button_inc_dec{
                border:2px solid #A0A0A0;
                background-color:white;
                padding:0 8px;
                border-radius:4px;
                cursor:pointer;
                width:40px;
                height:35px;
                color:#A0A0A0;
                outline:none;
            }

            .button_inc_dec:hover{
                border:2px solid green;
                color:green;
            }
        </style>
        <script>
            function level_update(user_id, act){
                var data_send = "userID=" + user_id + "&act=" + act;

                if (act == 1) {
                    var domestic_level = document.getElementById("domestic_level").value;
                    var plastic_level = document.getElementById("plastic_level").value;
                    var paper_level = document.getElementById("paper_level").value;
                    var other_level = document.getElementById("other_level").value;

                    data_send += "&domestic_level=" + domestic_level + "&plastic_level=" + plastic_level + "&paper_level=" + paper_level + "&other_level=" + other_level;
                }

                var fetch_update = new XMLHttpRequest();
                fetch_update.onreadystatechange = function(){
                    if (this.readyState == 4 && this.status == 200) {
                        var data = JSON.parse(this.responseText);
                        if (data[0] == "false"){
                            // data[1] = domestic level
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
                
            }
        </script>
    </head>
    <input type="hidden" value="<?php echo $_SESSION['userID']; ?>" id='userid' />
    <body style="padding:70px 45px;" onload="level_update(userid.value, 0)">
        <!-- TOP BAR -->
        <div class="top-bar">
            <h1 style="display:inline-block;margin:8px 0;"><i class='fa fa-trash'></i> Binswiper</h1>
            <!-- OPTIONS CONTAINER -->
            <div style="float:right;display:block-inline;margin-top:20px;">
                <input type='button' value="Save Changes" class="button" onclick="level_update(userid.value, 1)" />
                <span style="margin-right:50px;text-transform:capitalize"><i class="fa fa-user-circle-o"></i> <?php echo $_SESSION['username'] ?></span>
                <a href="" style="color:#002246;text-decoration:none;margin-right:50px;"><i class="fa fa-wrench"></i> Settings</a>
                <a href="?logout=logout" style="color:#002246;text-decoration:none;"><i class="fa fa-sign-out"></i> Logout</a>
                <?php
                    if (isset($_GET['logout'])) {
                        session_destroy();
                        header("Refresh:0");
                    }
                ?>
            </div>
        </div>

        <h3>My Bins</h3>
        
        <!-- All Bins -->
        <div class="all_bins_container">
            <!-- Domestic Bin Box -->
            <table class="bins_box" border="1">
                <tr>
                    <td align="center">
                        <h3 style="color:white;margin:0;background-color:grey;display:block;border-radius:3px;padding:4px 0">Organic Waste</h3>
                    </td>
                    <td>
                        Collection Date:
                        <div style="font-size:20px;color:green">
                            <i class="fa fa-calendar"></i> 16 Feb 2019
                        </div>
                    </td>
                    <td></td>
                </tr>
                <tr>
                    <td align="center" rowspan="3">
                        <img src="img/organic_bin.png" style="width:160px;" />
                    </td>
                    <td>
                        <div class="c100" id="domestic_circle" style="margin-left:20px">
                            <span id="domestic_level_p">0%</span>
                            <div class="slice">
                                <div class="bar"></div>
                                <div class="fill"></div>
                            </div>
                        </div>
                    </td>
                    <td>
                    </td>
                </tr>
                <tr>
                    <td rowspan="2"><i class='fa fa-trash'></i> capacity: 20kg</td>
                </tr>
                <tr>
                    <td align="center">
                        <input type="button" value="- 1" onclick="inc_dec_level('domestic', domestic_level.value, 0)" class="button_inc_dec" />
                        <input type="hidden" value="0" id="domestic_prev_level" />
                        <input type="number" style="width:40px;" min="0" max="20" onchange="range_check_update('domestic', domestic_prev_level.value, this.value)" value="0" id="domestic_level" />
                        <input type="button" value="+ 1" onclick="inc_dec_level('domestic', domestic_level.value, 1)" class="button_inc_dec" /> kg
                    </td>
                </tr>
            </table>

            <!-- Plastic Bin Box -->
            <table class="bins_box">
                <tr>
                    <td align="center">
                        <h3 style="color:grey;">Plastic Waste</h3>
                    </td>
                    <td style="font-size:13px;color:red;" align="center">
                        Not Saved!
                    </td>
                    <td align="right" style="font-size:14px;">
                        Collection Date: -- | --
                    </td>
                </tr>
                <tr>
                    <td align="center">
                        <img src="img/plastic_bin.png" style="width:160px;" />
                    </td>
                    <td style="width:33.3%;padding:0 0 0 6.5%;text-align:center">
                        <div class="c100 p25">
                            <span id="plastic_level_p">0%</span>
                            <div class="slice">
                                <div class="bar"></div>
                                <div class="fill"></div>
                            </div>
                        </div>
                    </td>
                    <td>
                        capacity: 20kg
                        <input type="text" value="0" id="plastic_level" />
                    </td>
                </tr>
            </table>

            <!-- Paper Bin Box -->
            <table class="bins_box">
                <tr>
                    <td align="center">
                        <h3 style="color:grey;">Paper Waste</h3>
                    </td>
                    <td style="font-size:13px;color:red;" align="center">
                        Not Saved!
                    </td>
                    <td align="right" style="font-size:14px;">
                        Collection Date: -- | --
                    </td>
                </tr>
                <tr>
                    <td align="center">
                        <img src="img/paper_bin.png" style="width:160px;" />
                    </td>
                    <td style="width:33.3%;padding:0 0 0 6.5%;text-align:center">
                        <div class="c100 p25">
                            <span id="domestic_level_p">0%</span>
                            <div class="slice">
                                <div class="bar"></div>
                                <div class="fill"></div>
                            </div>
                        </div>
                    </td>
                    <td>
                        capacity: 20kg
                        <input type="text" value="0" id="paper_level" />
                    </td>
                </tr>
            </table>

            <!-- Other Bin Box -->
            <table class="bins_box">
                <tr>
                    <td align="center">
                        <h3 style="color:grey;">Other Waste</h3>
                    </td>
                    <td style="font-size:13px;color:red;" align="center">
                        Not Saved!
                    </td>
                    <td align="right" style="font-size:14px;">
                        Collection Date: -- | --
                    </td>
                </tr>
                <tr>
                    <td align="center">
                        <img src="img/other_bin.png" style="width:160px;" />
                    </td>
                    <td style="width:33.3%;padding:0 0 0 6.5%;text-align:center">
                        <div class="c100 p25">
                            <span id="other_level_p">0%</span>
                            <div class="slice">
                                <div class="bar"></div>
                                <div class="fill"></div>
                            </div>
                        </div>
                    </td>
                    <td>
                        capacity: 20kg
                        <input type="text" value="0" id="other_level" />
                    </td>
                </tr>
            </table>

        </div>
    </body>
</html>