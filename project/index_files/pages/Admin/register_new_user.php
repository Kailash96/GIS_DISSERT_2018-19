<!DOCTYPE HTML>
<html>
    <head>
        <title>Registration | Binswiper</title>
        <link rel="stylesheet" href="../../css_files/style.css" />
        <style>
            #register_selected{
                background-color:#DCDCDC;
                border-left:4px solid #009DC4;
            }
            .container-box{
                width:200px;
                height:120px;
                color:#002246;
                border:1px solid #002246;
                display:inline-block;
                margin:20px;
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
        <?php include("admin-left_side_nav_bar.php"); ?>

        <!-- choose generator or collector -->
        <div>
            <a href=""><div class="container-box">
                <i class="fa fa-home" style="font-size:80px"></i><br/><br/>
                Generator
            </div></a>
            <a href=""><div class="container-box">
                <i class="fa fa-shopping-cart" style="font-size:80px;"></i><br/><br/>
                Collector
            </div></a>
        </div>
        <!-- choosing generator -->
        <div>
            <a href=""><div class="container-box">
                <i class="fa fa-home" style="font-size:80px"></i><br/><br/>
                Resident
            </div></a>
            <a href=""><div class="container-box">
                <i class="fa fa-shopping-cart" style="font-size:80px;"></i><br/><br/>
                Commercial
            </div></a>
            <a href=""><div class="container-box">
                <i class="fa fa-industry" style="font-size:80px;"></i><br/><br/>
                Industry
            </div></a>
        </div>
        <!-- choosing collector -->
        <div>
            <a href=""><div class="container-box">
                <i class="fa fa-home" style="font-size:80px"></i><br/><br/>
                District Council
            </div></a>
            <a href=""><div class="container-box">
                <i class="fa fa-shopping-cart" style="font-size:80px;"></i><br/><br/>
                Municipality
            </div></a>
            <a href=""><div class="container-box">
                <i class="fa fa-industry" style="font-size:80px;"></i><br/><br/>
                Contractors
            </div></a>
            <a href=""><div class="container-box">
                <i class="fa fa-industry" style="font-size:80px;"></i><br/><br/>
                Local Authorities
            </div></a>
        </div>
    </body>
<html>