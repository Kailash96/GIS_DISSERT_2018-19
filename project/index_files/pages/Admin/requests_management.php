<!DOCTYPE HTML>
<html>
    <head>
        <title>Requests | Binswiper</title>
        <link rel="stylesheet" href="../../css_files/style.css" />
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <style>
            #requests_selected{
                background-color:#002246;
                color:white;
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
                display:block;
            }
        </style>
        <script>
                function viewDetails(data){
                    
                    var arrdata = data.split("-");
                    var nic = arrdata[0];
                    var category = arrdata[1];

                    $("#listofrequestscontainer").hide();
                    $("#viewDetailsContainer").fadeIn();
                    
                    var userdetails = new XMLHttpRequest();
                    userdetails.onreadystatechange = function(){
                        if (this.readyState == 4 && this.status == 200){
                            // var data = JSON.parse(this.responseText);
                            // alert('test');
                        }
                    }
                    userdetails.open("POST", "getuserdetails.php", true);
                    userdetails.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                    userdetails.send('id=' + nic);
                    
                }

                function edit(){
                    event.preventDefault();
                    // GET ALL VALUES
                }
        </script>
    </head>
    <body>
        <?php include("admin-left_side_nav_bar.php"); ?>
        <?php include("admin-top-nav-bar.html"); ?>
        
        <div style="padding:0 20px;" id="listofrequestscontainer">
            <h3>List of Account Activation Requests</h3>
            <input type="button" class="selection_button" value="Resident" />
            <input type="button" class="selection_button" value="Commercial" />
            <input type="button" class="selection_button" value="Industrial" />
            <br/><br/>
            <div id="LORequests"></div>
        </div>

        <!-- VIEW DETAILS CONTAINER  -->
        <div id="viewDetailsContainer">
            <h3 style="padding:0 20px;margin:0">Details Edit</h3>
            <div class="reg-form-box">
                <div>
                    <form method="POST" action="edit()" style="font-size:12px;font-weight:bold;color:#9F9F9F">
                        NIC <input type="text" name="nic" placeholder="NIC" style="text-transform:uppercase" class="input-box" required /><br/><br/>
                        Full Name <input type="text" name="fullname" placeholder="Full Name" style="text-transform:capitalize" class="input-box" required /><br/><br/>
                        Tax Account Number <input type="text" name="tan" placeholder="Tax Account Number" class="input-box" /><br/><br/>
                        Phone <input type="number" name="phone" placeholder="Phone" class="input-box" required /><br/><br/>
                        Email <input type="text" name="email" placeholder="Email" class="input-box" style="text-transform:none" /><br/><br/>
                        
                            Country/Region<br/><input type="text" name="country" placeholder="Country" style="width:49.3%;text-transform:capitalize" class="input-box" required />
                            <input type="text" name="region" placeholder="Region" style="width:49.3%;text-transform:capitalize" class="input-box" required /><br/><br/>
                            Address<input type="text" name="address" placeholder="Address" style="width:100%;text-transform:capitalize" class="input-box" required /><br/><br/>
                            <input type="button" onclick="searchLoc(country.value, address.value, region.value)" value="Set my Location" style="width:100%" class="submit_button" />
                        
                        <input type="hidden" name="locationCoordinate" value="" /><br/><br/>
                        <input type="submit" class="submit_button" style="width:100%" value="Register" />
                    </form>
                </div>
                <div align="right">
                    <?php include("../getlocationmap.php"); ?>
                </div>
            </div>
        </div>

    </body>
</html>