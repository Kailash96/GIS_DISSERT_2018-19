<!DOCTYPE html>
<html>
    <head>
        <title>Collect Request | Binswiper</title>
        <link rel="stylesheet" href="../../../css_files/style.css" />
        <script src="../../../js_files/jquery_lib.js"></script>
        <style>
            #collect_selected{
                background-color:#DCDCDC;
                border-left:4px solid #009DC4;
            }
            .notif_box{
                margin:80px 20px;
            }
            .notif_box td{
                padding:0 20px;
            }
            .notif_box h5{
                margin:10px 0 0 0;
            }
            .btn{
                border:1px solid #BDBDBD;
                background-color:white;
                color:black;
                padding:8px;
                border-radius:3px;
                width:120px;
                cursor:pointer;
                margin-left:100px;
            }
            .btn:hover{
                box-shadow:0 0 2px black;
            }
        </style>
        <script>
            function request_review(act, id) {
                
                if (act == 1) {
                    var accept = new XMLHttpRequest();
                    accept.onreadystatechange = function(){
                        if (this.readyState == 4 && this.status == 200) {
                            var response = JSON.parse(this.responseText);
                            location.reload();
                            console.log(response);
                        }
                    }
                    accept.open("POST", "request_review.php", true);
                    accept.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                    accept.send("act=true" + "&id=" + id);
                } else {
                    var reject = new XMLHttpRequest();
                    reject.onreadystatechange = function(){
                        if (this.readyState == 4 && this.status == 200) {
                            var response = JSON.parse(this.responseText);
                            location.reload();
                            console.log(response);
                        }
                    }
                    reject.open("POST", "request_review.php", true);
                    reject.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                    reject.send("act=false" + "&id=" + id);
                }
            }
        </script>
    </head>
    <body>
        <?php include("left_side_nav_bar.html"); ?>
        <?php include("top-nav-bar.html"); ?>

        <?php include("../../../../../config/db_connect.php"); ?>

        <div id="notifbox"></div>

    </body>
</html>