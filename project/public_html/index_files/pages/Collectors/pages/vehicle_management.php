<!DOCTYPE html>
<html>
    <head>
        <title>Vehicle | Binswiper</title>
        <link rel="stylesheet" href="../../../css_files/style.css" />
        <script src="../../../js_files/jquery_lib.js"></script>

        <style>
            #vehicle_selected{
                background-color:#DCDCDC;
                border-left:4px solid #009DC4;
            }
            .trucks_box{
                
            }
            .trucks_box td{
                padding:20px;
            }
            .trucks_box h5{
                margin:0;
            }
        </style>
    </head>
    <body>
        <?php include("left_side_nav_bar.html"); ?>
        <?php include("top-nav-bar.html"); ?>

        <?php include("../../../../../config/db_connect.php"); ?>

        <div style="padding:30px;">
            <h3>Trucks Details</h3>
            <table border="0" class="trucks_box">
                <?php

                    $collector = $_SESSION['collector_userID'];
                    $getTrucksQuery = "SELECT * FROM tbl_trucks WHERE OwnerID = '$collector'";
                    $getTrucks = mysqli_query($conn, $getTrucksQuery);
                    $data = "";
                    while ($trucks = mysqli_fetch_assoc($getTrucks)) {
                        if ($trucks['Status'] == 1){
                            $availability = "<span style='color:green'>Available</span>";
                        } else {
                            $availability = "<span style='color:red'>Unavailable</span>";
                        }
                        $data .= "
                            <tr>
                                <td><h5>Plate Number</h5>" . $trucks['PlateNumber'] . "</td>
                                <td><h5>Truck Capacity</h5>" . $trucks['Capacity'] . "</td>
                                <td><h5>Waste Type</h5>" . $trucks['WasteType'] . "</td>
                                <td><h5>Status</h5>" . $availability . "</td>
                            </tr>
                            <tr><td colspan='4' style='padding:0'><hr></td></tr>
                        ";
                    }
                    echo $data;
                ?>
            </table>
        </div>
    </body>
</html>