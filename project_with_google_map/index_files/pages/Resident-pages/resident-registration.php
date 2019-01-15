<!DOCTYPE HTML>
<html>
    <head>
        <title>Resident Registration | Binswiper</title>
        <link type="text/css" rel="stylesheet" href="../../css_files/style.css" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <style>
            *{
                color:#002246;
            }

            .reg-form-box{
                display:grid;
                grid-template-columns: auto auto;
                grid-column-gap:1px;
                box-shadow:0 0 8px #002246;
                border-radius:3px;
                padding:20px;
                width:75%;
            }

            .submit_button{
                background-color:transparent;
                border:1px solid transparent;
                box-shadow:0 0 4px #002246;
                border-radius:4px;
                padding:10px 20px;
                cursor:pointer;
                color:#002246;
            }

            .submit_button:hover{
                box-shadow:0 0 10px #002246;
            }

            #mapid{
                height:180px;
            }
            
        </style>
    </head>
    <body style="margin:0;padding:0;">
        <h1 style="text-align:center"><i class="fa fa-trash-o"></i> Binswiper</h1>
        <div align="center">
            <div class="reg-form-box">
                <div>
                    <h3>Sign Up!</h3>
                    <form method="POST" action="registration_complete.php">
                        <input type="text" name="nic" placeholder="NIC" style="text-transform:uppercase" class="input-box" required /><br/>
                        <input type="text" name="fullname" placeholder="Full Name" style="text-transform:capitalize" class="input-box" required /><br/>
                        <input type="text" name="tan" placeholder="Tax Account Number" class="input-box" /><br/>
                        <input type="number" name="phone" placeholder="Phone" class="input-box" required /><br/>
                        <input type="text" name="email" placeholder="Email" class="input-box" /><br/>
                        <input type="hidden" name="locationCoordinate" value="" /><br/>
                        <input type="submit" class="submit_button" value="Sign Up" />
                    </form>
                </div>
                <div>
                    <?php include("../getlocationmap.php"); ?>
                    <div style="border:1px solid black;padding:10px;margin-top:10px;">
                        <form onsubmit="event.preventDefault();searchLoc(country.value, address.value, region.value)">
                            <input type="text" name="country" placeholder="Country" style="width:24%;text-transform:capitalize" class="input-box" required />
                            <input type="text" name="address" placeholder="Address" style="width:40%;text-transform:capitalize" class="input-box" required />
                            <input type="text" name="region" placeholder="Region" style="width:20%;text-transform:capitalize" class="input-box" required />
                            <input type="submit" value="Localize" class="submit_button" />
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <h5 style="text-align:center">Already a member? <a href="../../../index.php" style="color:#002246">Click here to log in</a></h5>
    </body>
</html>