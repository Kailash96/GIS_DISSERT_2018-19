<!DOCTYPE html>
<html>
    <head>
        <title>Bin Control | Binswiper</title>
        <link rel="stylesheet" href="../../css_files/style.css" />
        <style>
            #bin_control_selected {
                background-color:#002246;
                color:white;
            }

            #bincontrollist table{
                border:1px solid black;
                cursor:pointer;
                display:inline-block;
                width:48%;
                padding:8px;
            }
        </style>
        <script>
            function update_list(user_id, category){
                // DEFAULT CATEGORY IS RESIDENTS TO SEARCH IN RESIDENTS TABLE

                // GET USER DETAILS
                var getUsers = new XMLHttpRequest();
                getUsers.onreadystatechange = function(){
                    if (this.readyState == 4 && this.status == 200) {
                        var data = JSON.parse(this.responseText);
                        document.getElementById('bincontrollist').innerHTML = data;
                    }
                }
                getUsers.open("POST", "bincontrolrequest.php", true);
                getUsers.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                getUsers.send('user_id=' + user_id + "&category=" + category);
            }
        </script>
    </head>
    <body onload="update_list(0, 'residents')">
        <?php include("admin-left_side_nav_bar.php"); ?>
        <?php include("admin-top-nav-bar.html"); ?>
        
        <div style="padding:0 20px;" align="center">
            <div id="bincontrollist"></div>
        </div>
    </body>
</html>