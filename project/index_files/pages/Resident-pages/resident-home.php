<!DOCTYPE HTML>
<html>
    <head>
        <title>Home | Binswiper</title>
        <?php include("../../../db_connect.php"); ?>
        <?php
            session_start();
            if (!isset($_SESSION['userID'])) {
                header('location: ../../../index.php');
            } else {
                $userid = $_SESSION['userID'];
                $user_zone = $_SESSION['zone'];
                $user_category = $_SESSION['category'];
                if (isset($_GET['logout'])) {
                    $offline = "UPDATE tbl_generators_login SET Status = 0 WHERE GeneratorID = '$userid'";
                    mysqli_query($conn, $offline);
                    session_destroy();
                    header("Refresh:0");
                }
            }
        ?>
        <link type="text/css" rel="stylesheet" href="../../css_files/resident-css.css" />
        <script type="text/javascript" src="../../js_files/script.js" /></script>

        <link type="text/css" rel="stylesheet" href="../../css_files/circle.css" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <style>
            .bins_box{
                box-shadow:0 0 4px #002246;
                padding:8px 10px;
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
                margin-right:50px;
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
                border:1px solid #A0A0A0;
                background-color:white;
                padding:0 8px;
                border-radius:4px;
                cursor:pointer;
                width:40px;
                height:34px;
                color:#A0A0A0;
                outline:none;
            }

            .button_inc_dec:hover{
                border:2px solid green;
                color:green;
            }

            #savechanges{
                display:none;
            }

            #changessaved{
                display:none;
            }

            /* Notifications */

            .notification {
                display: inline-block;
                position: relative;
                padding: 0.2em;
                border-radius: 0.2em;
                font-size: 1.1em;
            }

            .notification::before, 
            .notification::after {
                color: #004876;
                text-shadow: 0 1px 3px rgba(0, 0, 0, 0.3);
            }

            .notification::before {
                display: block;
                content: "\f0f3";
                font-family: "FontAwesome";
                transform-origin: top center;
            }

            .notification::after {
                font-family: Arial;
                font-size: 0.7em;
                position: absolute;
                top: -16px;
                left: 12px;
                padding: 3px 5px 3px 4px;
                line-height: 100%;
                border: 2px #fff solid;
                border-radius: 6px;
                background: red;
                color:white;
                opacity: 0;
                content: attr(data-count);
                opacity: 0;
                -webkit-transform: scale(0.5);
                transform: scale(0.5);
                transition: transform, opacity;
                transition-duration: 0.3s;
                transition-timing-function: ease-out;
            }

            .notification.notify::before {
                -webkit-animation: ring 1.5s ease;
                animation: ring 1.5s ease;
            }

            .notification.show-count::after {
                -webkit-transform: scale(1);
                transform: scale(1);
                opacity: 1;
            }

            @-webkit-keyframes ring {
                0% {
                    -webkit-transform: rotate(35deg);
                }
                12.5% {
                    -webkit-transform: rotate(-30deg);
                }
                25% {
                    -webkit-transform: rotate(25deg);
                }
                37.5% {
                    -webkit-transform: rotate(-20deg);
                }
                50% {
                    -webkit-transform: rotate(15deg);
                }
                62.5% {
                    -webkit-transform: rotate(-10deg);
                }
                75% {
                    -webkit-transform: rotate(5deg);
                }
                100% {
                    -webkit-transform: rotate(0deg);
                }
            }

            @keyframes ring {
                0% {
                    -webkit-transform: rotate(35deg);
                    transform: rotate(35deg);
                }
                12.5% {
                    -webkit-transform: rotate(-30deg);
                    transform: rotate(-30deg);
                }
                25% {
                    -webkit-transform: rotate(25deg);
                    transform: rotate(25deg);
                }
                37.5% {
                    -webkit-transform: rotate(-20deg);
                    transform: rotate(-20deg);
                }
                50% {
                    -webkit-transform: rotate(15deg);
                    transform: rotate(15deg);
                }
                62.5% {
                    -webkit-transform: rotate(-10deg);
                    transform: rotate(-10deg);
                }
                75% {
                    -webkit-transform: rotate(5deg);
                    transform: rotate(5deg);
                }
                100% {
                    -webkit-transform: rotate(0deg);
                    transform: rotate(0deg);
                }
            }
        </style>
        <script>
            function notify(count){
                count = count || 0;
                var el = document.querySelector('.notification');
                el.setAttribute('data-count', count);
                el.classList.remove('notify');
                el.offsetWidth = el.offsetWidth;
                el.classList.add('notify');
                el.classList.add('show-count');
            }
        </script>

    </head>
    <input type="hidden" value="<?php echo $_SESSION['userID']; ?>" id='userid' />
    <body style="padding:70px 45px;" onload="level_update(userid.value, 'citizen', 0), notify(4);">
        <!-- TOP BAR -->
        <div class="top-bar">
            <h1 style="display:inline-block;margin:8px 0;"><i class='fa fa-trash'></i> Binswiper</h1>
            <!-- OPTIONS CONTAINER -->
            <div style="float:right;display:block-inline;margin-top:20px;">
                <span id="savechanges" class="button" onclick="level_update(userid.value, 'citizen', 1)"><i class="fa fa-database" style="color:red;"></i> Save Changes?</span>
                <span style="cursor:default;color:green;border:2px solid green;border-radius:4px" id="changessaved" class="button">Changes Saved <i class="fa fa-check-square-o"></i></span>
                <span style="margin-right:50px;text-transform:capitalize"><i class="fa fa-user-circle-o"></i> <?php echo $_SESSION['username'] ?></span>
                <div style="display:inline-block;margin-right:20px">
                    <div class="notification"></div>
                </div>
                <a href="" style="color:#002246;text-decoration:none;margin-right:50px;"><i class="fa fa-wrench"></i> Settings</a>
                <a href="?logout=logout" style="color:#002246;text-decoration:none;"><i class="fa fa-sign-out"></i> Logout</a>
            </div>
        </div>

        <?php
            // GET COLLECTION DATES
            // ORGANIC
            $nextCollectionOrganic = "SELECT * FROM tbl_schedule WHERE Zone = $user_zone AND Category = '$user_category' AND SchedulingDate = (SELECT MAX(SchedulingDate) FROM tbl_schedule WHERE Zone = $user_zone) LIMIT 1";
            if ($organic_date = mysqli_query($conn, $nextCollectionOrganic)) {
                $organic_d = mysqli_fetch_assoc($organic_date)['CollectionDate'];
            }

        ?>

        <!-- All Bins -->
        <div class="all_bins_container">
            <!-- Domestic Bin Box -->
            <table class="bins_box" border="0">
                <tr>
                    <td align="center">
                        <h3 style="color:white;margin:0;background-color:grey;display:block;border-radius:3px;padding:5px 0">Organic Waste</h3>
                    </td>
                    <td style="font-size:14px;padding-left:14px">
                        Previous Collection:
                        <div style="font-size:18px;color:blue">
                            <i class="fa fa-calendar"></i> 16 Feb 2019
                        </div>
                    </td>
                    <td style="font-size:14px">
                        Next Collection:
                        <div style="font-size:18px;color:red">
                            <i class="fa fa-calendar"></i> <?php echo date("D, d M Y", strtotime($organic_d)); ?>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td align="center" rowspan="3">
                        <img src="img/organic_bin.png" style="width:160px;" />
                    </td>
                    <td style="width:200px;padding-left:14px;font-size:16px;" rowspan="2">
                        <i class='fa fa-trash'></i> capacity: 20kg<br/><br/>
                        Status<br/>
                        <span style="font-size:40px;" id="domestic_bin_status">
                            0/20 kg
                        </span>
                    </td>
                    <td>
                        <div class="c100" id="domestic_circle" style="margin:8px 0 4px 4px">
                            <span id="domestic_level_p">0%</span>
                            <div class="slice">
                                <div class="bar"></div>
                                <div class="fill"></div>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="button" value="- 1" onclick="inc_dec_level('domestic', domestic_level.value, 0)" class="button_inc_dec" />
                        <input type="hidden" value="0" id="domestic_prev_level" />
                        <input type="number" style="width:40px;" min="0" max="20" onkeyup="save_request()" onchange="range_check_update('domestic', domestic_prev_level.value, this.value)" value="0" id="domestic_level" />
                        <input type="button" value="+ 1" onclick="inc_dec_level('domestic', domestic_level.value, 1)" class="button_inc_dec" /> kg
                    </td>
                </tr>
            </table>

            <!-- Plastic Bin Box -->
            <table class="bins_box" border="0">
                <tr>
                    <td align="center">
                        <h3 style="color:white;margin:0;background-color:#E27525;display:block;border-radius:3px;padding:5px 0">Plastic Waste</h3>
                    </td>
                    <td style="font-size:14px;padding-left:14px">
                        Previous Collection:
                        <div style="font-size:18px;color:blue">
                            <i class="fa fa-calendar"></i> 16 Feb 2019
                        </div>
                    </td>
                    <td style="font-size:14px">
                        Next Collection:
                        <div style="font-size:18px;color:red">
                            <i class="fa fa-calendar"></i> 16 Feb 2019
                        </div>
                    </td>
                </tr>
                <tr>
                    <td align="center" rowspan="3">
                        <img src="img/plastic_bin.png" style="width:160px;" />
                    </td>
                    <td style="width:200px;padding-left:14px;font-size:16px;" rowspan="2">
                        <i class='fa fa-trash'></i> capacity: 20kg<br/><br/>
                        Status<br/>
                        <span style="font-size:40px;" id="plastic_bin_status">
                            0/20 kg
                        </span>
                    </td>
                    <td>
                        <div class="c100" id="plastic_circle" style="margin:8px 0 4px 4px">
                            <span id="plastic_level_p">0%</span>
                            <div class="slice">
                                <div class="bar"></div>
                                <div class="fill"></div>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="button" value="- 1" onclick="inc_dec_level('plastic', plastic_level.value, 0)" class="button_inc_dec" />
                        <input type="hidden" value="0" id="plastic_prev_level" />
                        <input type="number" style="width:40px;" min="0" max="20" onkeyup="save_request()" onchange="range_check_update('plastic', plastic_prev_level.value, this.value)" value="0" id="plastic_level" />
                        <input type="button" value="+ 1" onclick="inc_dec_level('plastic', plastic_level.value, 1)" class="button_inc_dec" /> kg
                    </td>
                </tr>
            </table>

            <!-- Paper Bin Box -->
            <table class="bins_box" border="0">
                <tr>
                    <td align="center">
                        <h3 style="color:white;margin:0;background-color:#278DC7;display:block;border-radius:3px;padding:5px 0">Paper Waste</h3>
                    </td>
                    <td style="font-size:14px;padding-left:14px">
                        Previous Collection:
                        <div style="font-size:18px;color:blue">
                            <i class="fa fa-calendar"></i> 16 Feb 2019
                        </div>
                    </td>
                    <td style="font-size:14px">
                        Next Collection:
                        <div style="font-size:18px;color:red">
                            <i class="fa fa-calendar"></i> 16 Feb 2019
                        </div>
                    </td>
                </tr>
                <tr>
                    <td align="center" rowspan="3">
                        <img src="img/paper_bin.png" style="width:160px;" />
                    </td>
                    <td style="width:200px;padding-left:14px;font-size:16px;" rowspan="2">
                        <i class='fa fa-trash'></i> capacity: 20kg<br/><br/>
                        Status<br/>
                        <span style="font-size:40px;" id="paper_bin_status">
                            0/20 kg
                        </span>
                    </td>
                    <td>
                        <div class="c100" id="paper_circle" style="margin:8px 0 4px 4px">
                            <span id="paper_level_p">0%</span>
                            <div class="slice">
                                <div class="bar"></div>
                                <div class="fill"></div>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="button" value="- 1" onclick="inc_dec_level('paper', paper_level.value, 0)" class="button_inc_dec" />
                        <input type="hidden" value="0" id="paper_prev_level" />
                        <input type="number" style="width:40px;" min="0" max="20" onkeyup="save_request()" onchange="range_check_update('paper', paper_prev_level.value, this.value)" value="0" id="paper_level" />
                        <input type="button" value="+ 1" onclick="inc_dec_level('paper', paper_level.value, 1)" class="button_inc_dec" /> kg
                    </td>
                </tr>
            </table>

            <!-- Other Bin Box -->
            <table class="bins_box" border="0">
                <tr>
                    <td align="center">
                        <h3 style="color:white;margin:0;background-color:red;display:block;border-radius:3px;padding:5px 0">Other Waste</h3>
                    </td>
                    <td style="font-size:14px;padding-left:14px">
                        Previous Collection:
                        <div style="font-size:18px;color:blue">
                            <i class="fa fa-calendar"></i> 16 Feb 2019
                        </div>
                    </td>
                    <td style="font-size:14px">
                        Next Collection:
                        <div style="font-size:18px;color:red">
                            <i class="fa fa-calendar"></i> 16 Feb 2019
                        </div>
                    </td>
                </tr>
                <tr>
                    <td align="center" rowspan="3">
                        <img src="img/other_bin.png" style="width:160px;" />
                    </td>
                    <td style="width:200px;padding-left:14px;font-size:16px;" rowspan="2">
                        <i class='fa fa-trash'></i> capacity: 20kg<br/><br/>
                        Status<br/>
                        <span style="font-size:40px;" id="other_bin_status">
                            0/20 kg
                        </span>
                    </td>
                    <td>
                        <div class="c100" id="other_circle" style="margin:8px 0 4px 4px">
                            <span id="other_level_p">0%</span>
                            <div class="slice">
                                <div class="bar"></div>
                                <div class="fill"></div>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="button" value="- 1" onclick="inc_dec_level('other', other_level.value, 0)" class="button_inc_dec" />
                        <input type="hidden" value="0" id="other_prev_level" />
                        <input type="number" style="width:40px;" min="0" max="20" onkeyup="save_request()" onchange="range_check_update('other', other_prev_level.value, this.value)" value="0" id="other_level" />
                        <input type="button" value="+ 1" onclick="inc_dec_level('other', other_level.value, 1)" class="button_inc_dec" /> kg
                    </td>
                </tr>
            </table>

        </div>
    </body>
</html>