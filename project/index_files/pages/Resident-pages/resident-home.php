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
            <table class="bins_box">
                <tr>
                    <td align="center">
                        <h3 style="color:grey;">Organic Waste</h3>
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
                        <img src="img/organic_bin.png" style="width:160px;" />
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
                        <input type="text" value="0" id="domestic_level" />
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