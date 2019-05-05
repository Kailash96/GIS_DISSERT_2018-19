<!DOCTYPE html>
<html>
    <head>
        <?php include("../../../../../config/db_connect.php") ?>
        <link rel="stylesheet" href="../../../css_files/style.css" />
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <style>
            #schedule_selected{
                background-color:#DCDCDC;
                border-left:4px solid #009DC4;
            }
        </style>
        <script>
            // TEST DATA
            /*
            var data = [
                {
                    title: '10Z11',
                    start: '2019-04-08T05:15:00',
                    end: '2019-04-08T05:54:00',
                    color: 'yellow'
                }
            ];
            */
            
        </script>
    </head>
    <body>
        <?php include("left_side_nav_bar.html"); ?>
        <?php include("top-nav-bar.html"); ?>

        <div style="width:1050px;position:relative;left:270px;top:30px;">
            <?php include("../calendar/background-events.html"); ?>
        </div>
    </body>
</html>