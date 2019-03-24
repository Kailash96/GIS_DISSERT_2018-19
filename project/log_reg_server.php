<?php
        include("db_connect.php");

        function inside($point, $vs) {

            $x = $point[0];
            $y = $point[1];
        
            $inside = false;
            for ($i = 0, $j = sizeof($vs) - 1; $i < sizeof($vs); $j = $i++) {
                $xi = $vs[$i][0];
                $yi = $vs[$i][1];
                $xj = $vs[$j][0];
                $yj = $vs[$j][1];
                
                $intersect = (($yi > $y) != ($yj > $y))
                && ($x < ($xj - $xi) * ($y - $yi) / ($yj - $yi) + $xi);
                if ($intersect) $inside = !$inside;
            }
        
            return $inside;
        };
    
    
        function checkInZone($usr_location) {
            $zone_query = "SELECT * FROM tbl_zones";
            $usr_location_arr = explode(",", $usr_location);
            if ($my_result = mysqli_query($GLOBALS['conn'], $zone_query)) {
                while ($row = mysqli_fetch_assoc($my_result)) {
                    if (inside($usr_location_arr, json_decode($row['coordinates']))){
                        return $row['zoneID'];
                    }
                }
                return 0;
            }
            
        };

        // LOGIN CODE
        if (($_SERVER['REQUEST_METHOD'] == 'POST') && (isset($_POST['lgn']))){
            
            $userid = $_POST['userid'];
            $password = SHA1($_POST['userpassword']);

            $checkID_query = "SELECT * FROM tbl_generators_login WHERE GeneratorID = '$userid'";
            $checkPass_query = "SELECT * FROM tbl_generators_login WHERE Password = '$password'";

            if (mysqli_num_rows($checkCat = mysqli_query($conn, $checkID_query)) > 0){
                if (mysqli_num_rows($result = mysqli_query($conn, $checkPass_query)) > 0){

                    session_start();
                    $_SESSION['userID'] = $userid;
                    
                    $row = mysqli_fetch_assoc($checkCat);
                    $category = $row['Category'];
                    $getDataQuery = "SELECT * FROM tbl_generator WHERE GeneratorID = '$userid'";

                    if ($getData = mysqli_query($conn, $getDataQuery)) {
                        $value = mysqli_fetch_assoc($getData);
                        $_SESSION['username'] = $value['Name'];

                    }

                    header('location: index_files/pages/Resident-pages/resident-home.php');
                } else {
                    // WRONG PASSWORD
                    echo "<script>alert('wrong password');</script>";
                }
            } else {
                // WRONG ID
                echo "<script>alert('wrong ID');</script>";
            }
            
        } else if (($_SERVER['REQUEST_METHOD'] == 'POST') && (isset($_POST['reg']))) {
            
            // REGISTRATION CODE
            if ($_GET['reg'] == 'resident') {
                $nic = strtoupper($_POST["gen_nic"]);
                $fullname = ucwords($_POST["surname"] . " " . $_POST['firstname']);
                $category = "Resident";
            } else if ($_GET['reg'] == 'commercial') {
                $nic = strtoupper($_POST["gen_id"]);
                $fullname = ucwords($_POST["fullname"]);
                $category = "Commercial";
            } else {
                $nic = strtoupper($_POST["gen_id"]);
                $fullname = ucwords($_POST["fullname"]);
                $category = "Industrial";
            }

            $phone = $_POST["phone"];
            $email = strtolower($_POST["email"]);
            $address = ucwords($_POST["address"]);
            $region = ucwords($_POST["region"]);
            $country = ucwords($_POST["country"]);
            $locationCoordinate = $_POST["locationCoordinate"];

            $zone_ID = checkInZone($locationCoordinate);
            $dateReg = date('Y-m-d');
            
            $add_data = "INSERT INTO tbl_generator (GeneratorID, Name, Address, PhoneNumber, LocationCoordinate, Email, country, region, zoneID, DateReg, Category)
                        VALUES ('$nic', '$fullname', '$address', $phone, '$locationCoordinate', '$email', '$country', '$region', $zone_ID, '$dateReg', '$category')";
            
            if (mysqli_query($conn, $add_data)){
                header("Location: registration_done.php");
            } else {
                echo $locationCoordinate;
                echo "failed";
                echo date('Y-m-d');
            }

        }

?>