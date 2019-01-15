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

            .input-box{
                width:100%;
            }
            
        </style>
        <script>
            function setValue(coordinates){
                $('[name="locationCoordinate"]').val(coordinates);
            }
        </script>
    </head>
    <body style="margin:0;padding:0;">
        <h1 style="text-align:center"><i class="fa fa-trash-o"></i> Binswiper</h1>
        <h3 align="center">Registration</h3>
        <div align="center">
            <div class="reg-form-box">
                <div>
                    <form method="POST" action="registration_complete.php">
                        <input type="text" name="nic" placeholder="NIC" style="text-transform:uppercase" class="input-box" required /><br/>
                        <input type="text" name="fullname" placeholder="Full Name" style="text-transform:capitalize" class="input-box" required /><br/>
                        <input type="text" name="tan" placeholder="Tax Account Number" class="input-box" /><br/>
                        <input type="number" name="phone" placeholder="Phone" class="input-box" required /><br/>
                        <input type="text" name="email" placeholder="Email" class="input-box" style="text-transform:none" /><br/>
                        
                            <input type="text" name="country" placeholder="Country" style="width:49.3%;text-transform:capitalize" class="input-box" required />
                            <input type="text" name="region" placeholder="Region" style="width:49.3%;text-transform:capitalize" class="input-box" required /><br/>
                            <input type="text" name="address" placeholder="Address" style="width:100%;text-transform:capitalize" class="input-box" required /><br/><br/>
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
        <h5 style="text-align:center">Already a member? <a href="../../../index.php" style="color:#002246">Click here to log in</a></h5>
    </body>
</html>