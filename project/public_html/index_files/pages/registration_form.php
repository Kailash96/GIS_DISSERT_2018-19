<!DOCTYPE HTML>
<html>
    <head>
        <?php include_once('../../../config/log_reg_server.php'); ?>
        <title>Registration Form | Binswiper</title>
        <link type="text/css" rel="stylesheet" href="../css_files/style.css" />
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

            #next_button{
                display:none;
            }

            input[name='reg'] {
                display:none;
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

            var exist = false;
            function checkindb(nic){
                var check = new XMLHttpRequest();
                check.onreadystatechange = function(){
                    if (this.readyState == 4 && this.status == 200) {
                        exist = JSON.parse(this.responseText);
                    }
                }
                check.open("POST", "checkNIC.php", true);
                check.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                check.send("nic=" + nic);

                return exist;
            }

            function validate(checker_name, input_value){
                var error = true;
                var valid = "<i class='fa fa-check' style='color:green'></i>";

                if (checker_name == "gen_nic") {
                    var nic_error = document.getElementById("gen_nic_format");
                    // CHECK FIRST LETTER
                    if (!input_value.charAt(0).match(/^[a-zA-Z]+$/)) {
                        nic_error.innerHTML = "NIC should start with an alphabet!";
                        $("input[name='gen_nic']").css('border', '1px solid red');
                        error = true;
                    } else if (!input_value.match(/^[A-z0-9]+$/)) {
                        nic_error.innerHTML = "Special characters not allowed!";
                        $("input[name='gen_nic']").css('border', '1px solid red');
                        error = true;
                    }else if ((input_value.length < 14) || (input_value.length > 14)) {
                        nic_error.innerHTML = "NIC should contain 14 characters!"
                        $("input[name='gen_nic']").css('border', '1px solid red');
                        error = true;
                    } else if (checkindb(input_value)) {
                        nic_error.innerHTML = "NIC already registered!"
                        $("input[name='gen_nic']").css('border', '1px solid red');
                        error = true;
                    } else {
                        $("input[name='gen_nic']").css('border', '1px solid green');
                        nic_error.innerHTML = valid;
                        error = false;
                    }
                } else if (checker_name == "gen_id") {
                    var id_error = document.getElementById("gen_format");
                    if (!input_value.match(/^[A-z0-9]+$/)) {
                        id_error.innerHTML = "Special characters not allowed!";
                        $("input[name='gen_id']").css('border', '1px solid red');
                        error = true;
                    } else if (checkindb(input_value)) {
                        id_error.innerHTML = "Reg ID already registered!"
                        $("input[name='gen_id']").css('border', '1px solid red');
                        error = true;
                    } else {
                        $("input[name='gen_id']").css('border', '1px solid green');
                        id_error.innerHTML = valid;
                        error = false;
                    }
                } if (checker_name == "fullname") {
                    var name_error = document.getElementById("full_name_format");
                    if (input_value == "") {
                        name_error.innerHTML = "Field cannot be empty!";
                        $("input[name='fullname']").css('border', '1px solid red');
                        error = true;
                    } else if (!input_value.match(/^[a-zA-Z \b]+$/)) {
                        name_error.innerHTML = "Name should contain Only letters!";
                        $("input[name='fullname']").css('border', '1px solid red');
                        error = true;
                    } else {
                        name_error.innerHTML = valid;
                        $("input[name='fullname']").css('border', '1px solid green');
                        error = false;
                    }
                } else if (checker_name == "surname") {
                    var name_error = document.getElementById("last_format");
                    if (input_value == "") {
                        name_error.innerHTML = "Field cannot be empty!";
                        $("input[name='surname']").css('border', '1px solid red');
                        error = true;
                    } else if (!input_value.match(/^[a-zA-Z]+$/)) {
                        name_error.innerHTML = "Name should contain Only letters!";
                        $("input[name='surname']").css('border', '1px solid red');
                        error = true;
                    } else {
                        name_error.innerHTML = valid;
                        $("input[name='surname']").css('border', '1px solid green');
                        error = false;
                    }
                } else if (checker_name == "firstname") {
                    var name_error = document.getElementById("first_format");
                    if (input_value == "") {
                        name_error.innerHTML = "Field cannot be empty!";
                        $("input[name='surname']").css('border', '1px solid red');
                        error = true;
                    } else if (!input_value.match(/^[a-zA-Z]+$/)) {
                        name_error.innerHTML = "Name should contain Only letters!";
                        $("input[name='firstname']").css('border', '1px solid red');
                        error = true;
                    } else {
                        name_error.innerHTML = valid;
                        $("input[name='firstname']").css('border', '1px solid green');
                        error = false;
                    }
                }else if (checker_name == "phone") {
                    var name_error = document.getElementById("phone_format");
                    if (!input_value.match(/^[0-9]+$/)) {
                        name_error.innerHTML = "Only numerical value accepted!";
                        $("input[name='phone']").css('border', '1px solid red');
                        error = true;
                    } else if ((input_value.charAt(0) == 5) && ((input_value.length < 8) || (input_value.length > 8))) {
                        name_error.innerHTML = "Mobile number: 8 characters!";
                        $("input[name='phone']").css('border', '1px solid red');
                        error = true;
                    } else if ((input_value.charAt(0) != 5) && ((input_value.length < 7) || (input_value.length > 7))) {
                        name_error.innerHTML = "Home number: 7 characters!";
                        $("input[name='phone']").css('border', '1px solid red');
                        error = true;
                    } else {
                        name_error.innerHTML = valid;
                        $("input[name='phone']").css('border', '1px solid green');
                        error = false;
                    }
                } else if (checker_name == "email"){
                    var email_error = document.getElementById("email_format");
                    var email_format = /\S+@\S+\.\S+/;
                    if (!email_format.test(input_value)) {
                        email_error.innerHTML = "someone@example.com";
                        $("input[name='email']").css('border', '1px solid red');
                        error = true;
                    } else {
                        email_error.innerHTML = valid;
                        $("input[name='email']").css('border', '1px solid green');
                        error = false;
                    }
                }

                var nic = $("input[name='nic']").val();
                var surname = $("input[name='surname']").val();
                var firstname = $("input[name='firstname']").val();
                var phone = $("input[name='phone']").val();
                var email = $("input[name='email']").val();

                // CHECK IF TEXTBOXES ARE EMPTY
                if (nic == "" || surname == "" || firstname == "" || phone == "" || email == "") {
                    error = true;
                }
                
                if (!error) {
                    document.getElementById("next_button").style.display = "block";
                } else {
                    document.getElementById("next_button").style.display = "none";
                }
            }

            function validate_step_2(){
                var error = true;
                var select = $("select[name='region'] option:selected").val();

                if (select != "Select Region") {
                    $("select[name='region'").css({'border':'1px solid green', 'color':'green'});
                    error = false;
                } else {
                    $("select[name='region'").css({'border':'1px solid red', 'color':'red'});
                    error = true;
                }

                if ($("input[name='address']").val() == "") {
                    $("input[name='address']").css('border','1px solid red');
                    error = true;
                } else {
                    $("input[name='address']").css('border','1px solid green');
                    error = false;
                }

                if (error) {
                    $("input[name='reg']").css('display', 'none');
                    return false;
                } else {
                    $("input[name='reg']").css('display', 'block');
                    return true;
                }
            }
        </script>
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
                        <div style="display:flex;flex-direction:row">
                            <div style="width:50%;" id="reg_form">
                                <?php
                                 if ($_GET['reg'] == 'resident'){
                                    echo '
                                        Create your personal account<br/><br/>
                                        <div id="gen_nic_format"></div>            
                                        <input type="text" name="gen_nic" placeholder="NIC" onfocusout="validate(this.name, this.value)" onkeyup="validate(this.name, this.value)" style="text-transform:uppercase;" class="input-box" autocomplete="off" required /><br/>
                                    ';
                                 } else {
                                     echo '
                                        Create your account<br/><br/>
                                        <div id="gen_format"></div>            
                                        <input type="text" name="gen_id" placeholder="Registration Number" onfocusout="validate(this.name, this.value)" onkeyup="validate(this.name, this.value)" style="text-transform:uppercase;" class="input-box" autocomplete="off" required /><br/>
                                     ';
                                 }
                                    
                                ?>
                                <?php
                                    if ($_GET['reg'] == 'resident') {
                                        echo '
                                            <div id="last_format"></div>
                                            <input type="text" name="surname" placeholder="Last Name" onfocusout="validate(this.name, this.value)" style="text-transform:capitalize" class="input-box" autocomplete="off" required /><br/>
                                            <div id="first_format"></div>
                                            <input type="text" name="firstname" placeholder="First Name" onfocusout="validate(this.name, this.value)" style="text-transform:capitalize" class="input-box" autocomplete="off" required /><br/>
                                        ';
                                    } else {
                                        echo '
                                            <div id="full_name_format"></div>
                                            <input type="text" name="fullname" placeholder="Name" onfocusout="validate(this.name, this.value)" style="text-transform:capitalize" class="input-box" autocomplete="off" required /><br/>
                                        ';
                                    }
                                ?>
                                
                                <div id="phone_format"></div>
                                <input type="number" name="phone" placeholder="Tel/Mobile" onfocusout="validate(this.name, this.value)" class="input-box" autocomplete="off" required /><br/>
                                <div id="email_format"></div>
                                <input type="text" name="email" placeholder="Email" onkeyup="validate(this.name, this.value)" class="input-box" autocomplete="off" style="text-transform:none" /><br/><br/>

                                <button class="submit_button" id="next_button" onclick="next()">Next <i class="fa fa-toggle-right"></i></button>
                            </div>
                                <?php
                                    // DIFFERENT PICTURES FOR EACH TYPE
                                    if ($_GET['reg'] == "resident") {
                                        echo '
                                        <div style="width:50%;padding:50px 30px 0 30px">
                                            <img src="Generators/Resident-pages/img/sorting.png" style="width:100%"/>';
                                    } else if ($_GET['reg'] == "commercial") {
                                        echo '
                                        <div style="width:50%;padding:4px 0 0 30px">
                                            <img src="Generators/commercial_pages/img/sorting.png" style="width:100%"/>';
                                    } else {
                                        echo '
                                        <div style="width:50%;padding:50px 30px 0 30px">
                                            <img src="Generators/industry_pages/img/sorting.png" style="width:100%"/>';
                                    }
                                ?>
                            </div>
                        </div>
                        <!-- mapping -->
                        <div id="mapping" style="position:absolute;top:0;width:100%">
                            <?php include("getlocationmap.php"); ?>

                            <input type="hidden" name="locationCoordinate" value="" /><br/><br/>
                            
                        </div> 
                    </form>

                    <h5 style="text-align:center">Already a member? <a href="../../index.php" style="color:#002246">Click here to log in</a></h5>
                </td>
            </tr>
        </table>
    </body>
</html>