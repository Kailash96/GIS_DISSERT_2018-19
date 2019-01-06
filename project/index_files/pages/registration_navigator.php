<!DOCTYPE HTML>
<html>
    <head>
        <title>Registration Navigator | Binswiper</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <style>
            @font-face{
                font-family: quicksand;
                src: url("../font_files/Quicksand-Medium.ttf")
            }

            *{
                font-family: quicksand;
            }

            .container-box{
                width:200px;
                height:120px;
                color:#002246;
                border:1px solid #002246;
                display:inline-block;
                margin:100px 80px;
                padding:20px;
                box-shadow:0 0 2px black;
                border-radius:2px;
            }

            .container-box:hover{
                box-shadow:0 0 8px black;
            }
        </style>
        
    </head>
    <body>
        <div>
            <h1 style="margin:40px 0;font-size:50px;text-align:center;color:#002246;"><i class="fa fa-trash-o"></i> Binswiper</h1>
            <h3 style="text-align:center;color:#002246;">Registration</h3>
        </div>
        
        <!-- resident, commercial or industry selection -->
        <div style="text-align:center;" id="waste-generators-type-selection-box">
            <a href="resident-pages/resident-registration.php"><div class="container-box">
                <i class="fa fa-home" style="font-size:80px"></i><br/><br/>
                Resident
            </div></a>
            <a href="commercial-registration.php"><div class="container-box">
                <i class="fa fa-shopping-cart" style="font-size:80px;"></i><br/><br/>
                Commercial
            </div></a>
            <a href="industrial-registration.php"><div class="container-box">
                <i class="fa fa-industry" style="font-size:80px;"></i><br/><br/>
                Industry
            </div></a>
        </div>
        <h5 style="text-align:center">Already a member? <a href="../../index.php" style="color:#002246">Click here to log in</a></h5>
    </body>
</html>