<!DOCTYPE HTML>
<html>
    <head>
        <title>Home | Binswiper</title>
        <link type="text/css" rel="stylesheet" href="../../css_files/resident-css.css" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <?php session_start(); ?>
        <style>
            .bins_box{
                box-shadow:0 0 4px #002246;
                padding:10px;
                margin:10px 0;
                border-radius:3px;
            }
        </style>
        <script>
            function update_bins(userID){
                var update_bin = new XMLHttpRequest();
                update_bin.onreadystatechange = function(){
                    if (this.readyState == 4 && this.status == 200) {
                        var data = JSON.parse(this.responseText);
                        document.getElementById('bins_box').innerHTML = data[0];
                    }
                }
                update_bin.open("POST", "update_resident_bin.php", true);
                update_bin.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                update_bin.send("user_id=" + userID);
            }

            function levelup(userID, binType, binCapacity, numOfBins, level_value){
                event.preventDefault();

                var level = new XMLHttpRequest();
                level.onreadystatechange = function(){
                    if (this.readyState == 4 && this.status == 200){
                        var level_bar_id = binType + binCapacity;
                        var new_level = JSON.parse(this.responseText);

                        var i;
                        for (i = 0; i < numOfBins; i++){
                            if (new_level <= 100) {
                                document.getElementById(level_bar_id + "_" + i).style.width = new_level + '%';
                                document.getElementById(level_bar_id + "_fill_" + i).innerHTML = new_level + '%';
                                new_level = 0;
                            } else {
                                document.getElementById(level_bar_id + "_" + i).style.width = "100%";
                                document.getElementById(level_bar_id + "_fill_" + i).innerHTML = '100%';
                                new_level -= 100;
                            }  
                        }
                        
                    }
                }
                level.open("POST", "bin_level.php", true);
                level.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                level.send("GenID=" + userID + "&cap=" + binCapacity + "&type=" + binType + "&nob=" + numOfBins + "&level=" + level_value);

            }
        </script>
    </head>
    <input type="hidden" value="<?php echo $_SESSION['userID']; ?>" id='userid' />
    <body style="padding:70px 45px;" onload="update_bins(userid.value)">
        <!-- TOP BAR -->
        <div class="top-bar">
            <h1 style="display:inline-block;margin:8px 0;">Binswiper</h1>
            <!-- OPTIONS CONTAINER -->
            <div style="float:right;display:block-inline;margin-top:20px;">
                <span style="margin-right:50px;text-transform:capitalize"><i class="fa fa-user-circle-o"></i> <?php echo $_SESSION['username'] ?></span>
                <a href="" style="color:#002246;text-decoration:none;margin-right:50px;"><i class="fa fa-wrench"></i> Settings</a>
                <a href="logout.php" style="color:#002246;text-decoration:none;"><i class="fa fa-sign-out"></i> Logout</a>
            </div>
        </div>

        Next Collection: -- | -- | --
        <h3>My Bins</h3>

        <!-- BINS DETAILS BOX -->
        <div id="bins_box">
        </div>
    </body>
</html>