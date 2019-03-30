<!DOCTYPE HTML>
<html>
    <head>
        <title>Requests | Binswiper</title>
        <link rel="stylesheet" href="../../css_files/style.css" />
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

        <style>
            #requests_selected{
                background-color:#DCDCDC;
                border-left:4px solid #009DC4;
            }

            .selection_button{
                display:block-inline;
                width:100px;
                padding:4px;
                border:1px solid black;
                background-color:white;
                cursor:pointer;
            }

            .selection_button:hover{
                box-shadow:0 0 1px black;
            }

            .reg-form-box{
                display:grid;
                grid-template-columns: auto auto;
                grid-column-gap:1px;
                border-radius:3px;
                padding:0 30px;
                width:100%;
                box-sizing:border-box;
            }

            .input-box{
                width:100%;
                padding:7px 8px;
            }

            .submit_button{
                background-color:transparent;
                border:1px solid transparent;
                box-shadow:0 0 4px #002246;
                border-radius:4px;
                padding:6px;
                cursor:pointer;
                color:#002246;
            }

            .submit_button:hover{
                box-shadow:0 0 10px #002246;
            }

            .map-holder{
                border:1px solid black;
                padding:2px;
                width:600px;
                height:98%;
            }

            #viewDetailsContainer{
                visibility:visible;
                position:fixed;
                top:2%;
                left:13%;
                background-color:white;
                box-shadow:0 0 8px black;
                z-index:3;
                padding:10px 0;
                visibility:hidden;
            }

            .blurry-background{
                background-color:white;
                opacity:0.8;
                position:fixed;
                width:100%;
                height:100%;
                top:0;
                left:0;
                z-index:2;
                visibility:hidden;
            }

            .top-right-close-button{
                float:right;
                background-color:white;
                border:1px solid black;
                cursor:pointer;
                outline:none;
            }

            .top-right-close-button:hover{
                box-shadow:0 0 1px black;
            }

        </style>
        <script>
            function closeme(){
                $("#viewDetailsContainer").css('visibility', 'hidden');
                $(".blurry-background").css('visibility', 'hidden');
            }

            function edit(nic, fullname, email){
                event.preventDefault();
                // ACTIVATE ACCOUNT
                var activate = new XMLHttpRequest();
                activate.onreadystatechange = function(){
                    if (this.readyState == 4 && this.status == 200){
                        closeme();
                    }
                }
                activate.open("POST", "activate-account.php", true);
                activate.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                activate.send("nic=" + nic + "&fname=" + fullname + "&email=" + email);
                
            }

            function reject_account(nic){
                var reject = new XMLHttpRequest();
                reject.onreadystatechange = function (){
                    if (this.readyState == 4 && this.status == 200){
                        var response = JSON.parse(this.responseText);
                        if (response == true) {
                           closeme();
                        }
                        console.log(response);
                    }
                }
                reject.open("POST", "reject_request.php", true);
                reject.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                reject.send("nic=" + nic);
            }

            function filter_request(category) {
                var filter = new XMLHttpRequest();
                filter.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        var data = JSON.parse(this.responseText);
                        document.getElementById("LORequests").innerHTML = data;
                    }
                }
                filter.open("POST", "filter_request.php", true);
                filter.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                filter.send("category=" + category);
            }

        </script>
    </head>
    <body>
        <?php include("admin-left_side_nav_bar.php"); ?>
        <?php include("admin-top-nav-bar.html"); ?>
        
        <div style="padding:10px 20px;" id="listofrequestscontainer">
            <h3 style="color:#053A5C">List of Account Activation Requests</h3>
            <select id="category" onchange="filter_request(this.value)" style="border-radius:2px;padding:8px;width:300px;outline:none;">
                <option value="resident">Resident</option>
                <option value="commercial">Commercial</option>
                <option value="industrial">Industrial</option>
            </select>
            <br/><br/>
            <!-- LIST OF REQUEST CONTAINER -->
            <div id="LORequests">
                <h1 style='text-align:center;font-size:50px;color:#EDEDED;margin-top:100px'><i style='color:#EDEDED' class="fa fa-check-square-o"></i> No Request</h1>
            </div>
        </div>

        <!-- VIEW DETAILS CONTAINER  -->
        <div class="blurry-background"></div>
        <div id="viewDetailsContainer">
            <h3 style="padding:0 20px;margin:0;color:#002246">Details Edit <input type='button' onclick='closeme()' value='X' class='top-right-close-button'></h3>
            <div class="reg-form-box">
                <div style="padding:10px;">
                    <form method="POST" onsubmit="edit(nic.value, fullname.value, email.value)" style="font-size:12px;font-weight:bold;color:#9F9F9F">
                        NIC <input type="text" name="nic" placeholder="NIC" style="text-transform:uppercase" class="input-box" required /><br/><br/>
                        Full Name <input type="text" name="fullname" placeholder="Full Name" style="text-transform:capitalize" class="input-box" required /><br/><br/>
                        Tax Account Number <input type="text" name="tan" placeholder="Tax Account Number" class="input-box" /><br/><br/>
                        Phone <input type="number" name="phone" placeholder="Phone" class="input-box" required /><br/><br/>
                        Email <input type="text" name="email" placeholder="Email" class="input-box" style="text-transform:none" /><br/><br/>
                        
                            Country/Region<br/><input type="text" name="country" placeholder="Country" style="width:49.3%;text-transform:capitalize" class="input-box" required />
                            <input type="text" name="region" placeholder="Region" style="width:49.3%;text-transform:capitalize" class="input-box" required /><br/><br/>
                            Address<input type="text" name="address" placeholder="Address" style="width:100%;text-transform:capitalize" class="input-box" required /><br/><br/>
                            <input type="button" onclick="searchLoc(country.value, address.value, region.value)" value="Set my Location" style="width:100%;color:blue;" class="submit_button" />
                        
                        <input type="hidden" name="locationCoordinate" value="" /><br/><br/>
                        <input type="submit" class="submit_button" style="width:50%;color:green;box-shadow:0 0 8px green" value="Activate Account" />
                        <input type="button" class="submit_button" style="width:48%;color:red;box-shadow:0 0 8px red" onclick='reject_account(nic.value)' value="Reject Request" />
                    </form>
                </div>
                <div align="right" style="padding:10px">
                    <?php include('../getlocationmap.php'); ?>
                    <script>
                        function viewDetails(genID){

                            var nic = genID;

                            var userdetails = new XMLHttpRequest();
                            userdetails.onreadystatechange = function(){
                                if (this.readyState == 4 && this.status == 200){
                                    var data = JSON.parse(this.responseText);
                                    
                                    $("#viewDetailsContainer").css('visibility', 'visible');
                                    $(".blurry-background").css('visibility', 'visible');

                                    $("input[name='nic']").val(data[0]);
                                    $("input[name='fullname']").val(data[1]);
                                    $("input[name='phone']").val(data[3]);
                                    $("input[name='email']").val(data[5]);
                                    $("input[name='country']").val(data[6]);
                                    $("input[name='region']").val(data[7]);
                                    $("input[name='address']").val(data[2]);
                                    
                                }
                            }
                            userdetails.open("POST", "getuserdetails.php", true);
                            userdetails.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                            userdetails.send('GenID=' + nic);

                        }
                    </script>
                </div>
            </div>
        </div>

    </body>
</html>