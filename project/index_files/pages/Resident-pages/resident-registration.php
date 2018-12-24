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
        </style>
    </head>
    <body style="margin:0;padding:0;">
        <h1 style="text-align:center"><i class="fa fa-trash-o"></i> Binswiper</h1>
        <div align="center">
            <div class="reg-form-box">
                <div>
                    <h3>Sign Up!</h3>
                    <form>
                        <input type="text" placeholder="NIC" class="input-box" /><br/>
                        <input type="text" placeholder="Full Name" class="input-box" /><br/>
                        <input type="text" placeholder="Tax Account Number" class="input-box" /><br/>
                        <input type="text" placeholder="Address" class="input-box" /><br/>
                        <input type="text" placeholder="Phone" class="input-box" /><br/>
                        <input type="text" placeholder="Email" class="input-box" /><br/>
                        <input type="text" placeholder="Address" class="input-box" /><br/><br/>
                        <input type="submit" class="submit_button" value="Sign Up" />
                    </form>
                </div>
                <div>
                    map
                </div>
            </div>
        </div>
        <h5 style="text-align:center">Already a member? <a href="../../../index.php" style="color:#002246">Click here to log in</a></h5>
    </body>
</html>