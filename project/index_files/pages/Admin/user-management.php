<!DOCTYPE html>
<html>
    <head>
        <title>Bin Control | Binswiper</title>
        <link rel="stylesheet" href="../../css_files/style.css" />
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <style>
            #user_mngt_selected {
                background-color:#002246;
                color:white;
            }

            #usermanagementlist table{
                box-shadow:0 0 2px #002246;
                display:inline-block;
                width:48%;
                padding:8px;
                margin:4px 0;
            }

            #usermanagementlist td{
                padding:4px 0;
            }

            #usermanagementlist td a{
                text-decoration:none;
                color:#002246;
                font-size:13px;
            }

            #usermanagementlist td a:hover{
                text-decoration:underline;
            }

            .data_box{
                box-shadow:0 0 4px #002246;
                padding:10px 20px;
                position:relative;
            }

            .data_box h4{
                padding:0;
                margin:0 80px 0 0;
                display:inline;
            }

            .addBinPromptBox{
                box-shadow:0 0 4px #002246;
                border-radius:3px;
                padding:10px;
                width:300px;
                display:none;
            }

            .addBinPromptBox h3{
                margin:0;
                padding:0 0 8px 0;
            }

            #blurme{
                display:none;
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
                        document.getElementById('usermanagementlist').innerHTML = data;
                    }
                }
                getUsers.open("POST", "user-management-request.php", true);
                getUsers.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                getUsers.send('user_id=' + user_id + "&category=" + category);
            }

            function bin_control(userID, username){
                $('#usermanagementlist').hide();

                var getbins = new XMLHttpRequest();
                getbins.onreadystatechange = function(){
                    if (this.readyState == 4 && this.status == 200) {
                        var data = JSON.parse(this.responseText);
                        document.getElementById('bin_control_box').innerHTML = data;
                    }
                }
                getbins.open("POST", "getbins.php", true);
                getbins.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                getbins.send("userID=" + userID + "&username=" + username);

            }

            function update_bin(user_bin_id, bin_type, bin_capacity, nOfBin, act){
                event.preventDefault();

                var update_bin = new XMLHttpRequest();
                update_bin.onreadystatechange = function () {
                    if (this.readyState == 4 && this.status == 200) {
                         document.getElementById('promptbox').innerHTML = "New Bin Added";
                         setTimeout(function(){
                            $("#blurme, #promptbox").fadeOut();
                         }, 1000);
                    }
                }
                update_bin.open("POST", "update_bin.php", true);
                update_bin.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                update_bin.send('user_id=' + user_bin_id + "&bin_type=" + bin_type + "&bin_capacity=" + bin_capacity + "&nOfBin=" + nOfBin + "&act=" + act);

            }

            function popupaddbin(user_id){
                document.getElementById('theuserid').value = user_id;
                $("#blurme, .addBinPromptBox").fadeIn();
            }

            function close_box(){
                $("#blurme, .addBinPromptBox").fadeOut();
            }
        </script>
    </head>
    <body onload="update_list(0, 'residents')">
        <?php include("admin-left_side_nav_bar.php"); ?>
        <?php include("admin-top-nav-bar.html"); ?>
        
        <div style="padding:0 20px;" align="center">
            <div id="usermanagementlist" align="left"></div>
            <div id="bin_control_box" align='left'>bin control box</div>

            <!-- BACKGROUND BLUR -->
            <div id='blurme' style='position:fixed;left:0;top:0;background-color:white;width:100%;height:100%;opacity:0.8;z-index:0;'></div>

            <!-- ADD BIN PROMPT BOX -->
            <div class='addBinPromptBox' id='promptbox' align="left" style='position:absolute;top:180px;left:650px;background-color:white;z-index:1'>
                <h3><i class='fa fa-trash-o'></i> New Bin</h3>
                <form onsubmit='update_bin(theuserid.value, bintype.value, binCapacity.value, nOfBin.value, 1)'>
                    Bin Type:
                    <select id='bintype' style='width:100%;border:1px solid #002246;padding:8px;cursor:pointer;outline:none;border-radius:3px;'>
                        <option value='organic' >Organic</option>
                        <option value='plastic'>Plastic</option>
                        <option value='paper'>Paper</option>
                    </select><br/><br/>
                    Capacity:
                    <select id='binCapacity' style='width:100%;border:1px solid #002246;padding:8px;cursor:pointer;outline:none;border-radius:3px;'>
                        <option value='5' >5 Liters</option>
                        <option value='15'>15 Liters</option>
                        <option value='25'>25 Liters</option>
                    </select><br/><br/>
                    Number of Bins:<br/>
                    <input type="number" id='nOfBin' style='width:100%;border:1px solid #002246;padding:8px;cursor:pointer;outline:none;border-radius:3px;box-sizing:border-box' required /><br/><br/>
                    <input type='hidden' value='' id='theuserid' />
                    <input type="submit" class='button' value="Add +" />
                    <input type="button" class="button" onclick="close_box()" value="Cancel" />
                </form>
            </div>
        </div>
        
    </body>
</html>