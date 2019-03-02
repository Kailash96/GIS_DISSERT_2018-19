<!DOCTYPE HTML>
<html>
    <head>
        <title>Home | Binswiper</title>
        <link type="text/css" rel="stylesheet" href="../../css_files/resident-css.css" />
        <script type="text/javascript" src="../../js_files/script.js" /></script>

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
        </style>

    </head>
    <input type="hidden" value="<?php echo $_SESSION['userID']; ?>" id='userid' />
    <body style="padding:70px 45px;" onload="level_update(userid.value, 'citizen', 0)">
        <!-- TOP BAR -->
        <div class="top-bar">
            <h1 style="display:inline-block;margin:8px 0;"><i class='fa fa-trash'></i> Binswiper</h1>
            <!-- OPTIONS CONTAINER -->
            <div style="float:right;display:block-inline;margin-top:20px;">
                <span id="savechanges" class="button" onclick="level_update(userid.value, 'citizen', 1)"><i class="fa fa-database" style="color:red;"></i> Save Changes?</span>
                <span style="cursor:default;color:green;border:2px solid green;border-radius:4px" id="changessaved" class="button">Changes Saved <i class="fa fa-check-square-o"></i></span>
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
                            <i class="fa fa-calendar"></i> 16 Feb 2019
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