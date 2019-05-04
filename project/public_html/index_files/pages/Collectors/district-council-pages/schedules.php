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

            /*
            var data = JSON.stringify([    
                {
                title: 'DC1020 zone:20',
                start: '2019-03-04T05:00:00',
                end: '2019-03-04T07:30:00',
                color: 'yellow'
                }
                ,
                {
                title: 'DC1020 zone:23',
                start: '2019-03-04T08:00:00',
                end: '2019-03-04T09:30:00',
                color: 'yellow'
                }
            ]);
            console.log(data);
            */
                /*,
                {
                title: 'DC1020 zone:23',
                start: '2019-03-04T10:00:00',
                end: '2019-03-04T12:00:00',
                color: 'yellow'
                },
                {
                title: 'DC1020 zone:23',
                start: '2019-03-05T05:00:00',
                color: 'yellow'
                },
                {
                title: 'A2010 zone:24',
                start: '2019-03-05T09:00:00',
                color: 'yellow'
                },
                {
                title: 'A2010 zone:25',
                start: '2019-03-06T05:00:00',
                color: 'yellow'
                },
                {
                title: 'A2010 zone:26',
                start: '2019-03-06T09:00:00',
                color: 'yellow'
                },
                {
                title: 'B3030 zone:27',
                start: '2019-03-06T11:00:00',
                color: 'yellow'
                },
                {
                title: 'B3030 zone:28',
                start: '2019-03-06T13:00:00',
                color: 'yellow'
                },
                {
                title: 'T10Z11 zone:28',
                start: '2019-03-07T06:00:00',
                color: 'yellow'
                },
                {
                title: 'B3030 zone:30',
                start: '2019-03-07T13:00:00',
                color: 'yellow'
                },
                {
                title: 'T10Z11 zone:29',
                start: '2019-03-07T13:00:00',
                color: 'yellow'
                },
                {
                title: 'A2010 zone:30',
                start: '2019-03-08T08:00:00',
                color: 'yellow'
                },
                {
                title: 'A2010 zone:31',
                start: '2019-03-08T13:00:00',
                color: 'yellow'
                },
                {
                title: 'B1010 zone:32',
                start: '2019-03-09T07:00:00',
                color: 'yellow'
                },
                {
                title: 'B1010 zone:33',
                start: '2019-03-09T09:00:00',
                color: 'yellow'
                },
                {
                title: 'A2010 zone:34',
                start: '2019-03-11T07:00:00',
                color: 'yellow'
                }
                */
                /*
                {
                title: 'Meeting',
                start: '2019-03-13T11:00:00',
                end: '2019-03-13T13:00:00',
                color: '#257e4a'
                },
                {
                title: 'Business Lunch',
                start: '2019-03-13T13:00:00',
                },
                {
                title: 'Business Lunch',
                start: '2019-03-13T13:00:00',
                },

                
                {
                title: 'Conference',
                start: '2019-03-18',
                end: '2019-03-20'
                },
                {
                title: 'Party',
                start: '2019-03-29T20:00:00'
                },

                // areas where "Meeting" must be dropped
                {
                groupId: 'availableForMeeting',
                start: '2019-03-11T10:00:00',
                end: '2019-03-11T16:00:00',
                rendering: 'background'
                },
                {
                groupId: 'availableForMeeting',
                start: '2019-03-13T10:00:00',
                end: '2019-03-13T16:00:00',
                rendering: 'background'
                },

                // red areas where no events can be dropped
                {
                start: '2019-03-24',
                end: '2019-03-28',
                overlap: false,
                rendering: 'background',
                color: '#ff9f89'
                }
                
            ]);
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