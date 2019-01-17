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
        </style>
       
    </head>
    <body>
        <?php include("admin-left_side_nav_bar.php"); ?>
        <?php include("admin-top-nav-bar.html"); ?>
        
        <div style="padding:0 20px;">
            <h3>List of Account Activation Requests</h3>
            <input type="button" class="selection_button" value="Resident" />
            <input type="button" class="selection_button" value="Commercial" />
            <input type="button" class="selection_button" value="Industrial" />
            <br/><br/>
            <div id="LORequests"></div>
        </div>

    </body>
</html>