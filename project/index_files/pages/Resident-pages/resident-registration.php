<!DOCTYPE HTML>
<html>
    <head>
        <title>Resident Registration | Binswiper</title>
        <link type="text/css" rel="stylesheet" href="../../css_files/style.css" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <style>
            *{
                color:#002246;
            }
            .map-holder{
                border:1px solid black;
                padding:2px;
                width:100%;
                height:450px;
                box-sizing:border-box;
            }

            .submit_button{
                background-color:transparent;
                border:1px solid transparent;
                box-shadow:0 0 4px #002246;
                width:150px;
                font-weight:bold;
                border-radius:3px;
                padding:10px 20px;
                cursor:pointer;
                color:#002246;
                font-size:15px;
            }

            .submit_button:hover{
                box-shadow:0 0 8px #002246;
            }

            .input-box{
                width:100%;
                border:1px solid grey;
            }

            .navigation_box{
                font-size:14px;
                border:1px solid #9C9C9C;
                padding:10px 20px;
                margin:10px 0;
                border-radius:3px;
            }

            .navigation_box, .navigation_box b, .navigation_box i{
                color:#9C9C9C;
            }

            #mapping{
                visibility:hidden;
            }

            .active, .active b, .active i{
                color:#008FB9;
                background-color:white;
            }

            #reg_form div{
                text-align:right;
                height:20px;
                color:red;
                font-size:13px;
            }
        </style>
        <script>
            function setValue(coordinates){
                $('[name="locationCoordinate"]').val(coordinates);
            }

            function next(){
                var mapping = document.getElementById("mapping");
                var reg_form = document.getElementById("reg_form");

                mapping.style.visibility = "visible";
                reg_form.style.visibility = "hidden";

                var step1 = document.getElementById("step1");
                var step2 = document.getElementById("step2");

                step1.classList.remove("active");
                step2.classList.add("active");
            }

            function validate(checker_name, input_value){
                if (checker_name == "nic") {
                    if (input_value.match(/[A-z]/i)) {
                        console.log("valid");
                    }
                } else if (checker_name == "fullname") {

                } else if (checker_name == "phone") {

                } else if (checker_name == "email"){

                }
            }
        </script>
        <?php include('../../../log_reg_server.php'); ?>
    </head>
    <body style="margin:0;padding:0;background-color:#F6F6F6">
        <table border="0" width="100%" style="padding:0px 200px;">
            <tr>
                <td colspan="2"><h1><i class="fa fa-trash-o"></i> Join Binswiper</h1>
                The best way to optimize your waste collection at home.</td>
            </tr>
            <tr>
                <td width="50%">
                    <div class="navigation_box active" id="step1">
                        <i class="fa fa-id-badge"></i>
                        <b>Step 1</b><br/>
                        Set up your account
                    </div>
                </td>
                <td width="50%">
                    <div class="navigation_box" id="step2">
                        <i class="fa fa-location-arrow"></i>
                        <b>Step 2</b><br/>
                        Set your location
                    </div>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <form method="POST" onsubmit="<?php $_SERVER['PHP_SELF'] ?>" style="position:relative">
                        <!-- account registration -->
                        <div style="width:50%;" id="reg_form">
                            Create your personal account<br/><br/>
                            <div id="nic_format"></div>            
                            <input type="text" name="nic" placeholder="NIC" onkeyup="validate(this.name, this.value)" style="text-transform:uppercase;" class="input-box" autocomplete="off" required /><br/>
                            <div id="name_format"></div>
                            <input type="text" name="fullname" placeholder="Full Name" onkeyup="validate(this.name, this.value)" style="text-transform:capitalize" class="input-box" autocomplete="off" required /><br/>
                            <div id="phone_format"></div>
                            <input type="number" name="phone" placeholder="Phone" onkeyup="validate(this.name, this.value)" class="input-box" autocomplete="off" required /><br/>
                            <div id="email_format"></div>
                            <input type="text" name="email" placeholder="Email" onkeyup="validate(this.name, this.value)" class="input-box" autocomplete="off" style="text-transform:none" /><br/><br/>

                            <button class="submit_button" onclick="next()">Next <i class="fa fa-toggle-right"></i></button>
                            
                        </div>
                        <!-- mapping -->
                        <div id="mapping" style="position:absolute;top:0;width:100%">
                            <?php include("../getlocationmap.php"); ?>

                            <input type="hidden" name="locationCoordinate" value="" /><br/><br/>
                            
                        </div> 
                    </form>

                    <h5 style="text-align:center">Already a member? <a href="../../../index.php" style="color:#002246">Click here to log in</a></h5>
                </td>
            </tr>
        </table>
    </body>
</html>