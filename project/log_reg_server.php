<?php
        include("db_connect.php");

        // LOGIN CODE
        if (($_SERVER['REQUEST_METHOD'] == 'POST') && (isset($_POST['lgn']))){
            
            $userid = $_POST['userid'];
            $password = SHA1($_POST['userpassword']);

            $checkID_query = "SELECT * FROM generatorslogin WHERE GeneratorID = '$userid'";
            $checkPass_query = "SELECT * FROM generatorslogin WHERE Password = '$password'";

            if (mysqli_num_rows($checkCat = mysqli_query($conn, $checkID_query)) > 0){
                if (mysqli_num_rows($result = mysqli_query($conn, $checkPass_query)) > 0){

                    session_start();
                    $_SESSION['userID'] = $userid;
                    
                    $row = mysqli_fetch_assoc($checkCat);
                    if ($row['Category'] == 'resident') {
                        $getDataQuery = "SELECT * FROM tbl_residents WHERE NIC = '$userid'";
                    } else if ($row['Category'] == 'commercial') {
                        // SELECT FROM TABLE COMMERCIAL
                    } else if ($row['Category'] == 'industrial') {
                        // SELECT FROM TABLE INDUSTRIAL
                    }

                    if ($getData = mysqli_query($conn, $getDataQuery)) {
                        $value = mysqli_fetch_assoc($getData);
                        $_SESSION['username'] = $value['Name'];

                    }

                    header('location: index_files/pages/resident-pages/resident-home.php');
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
            $nic = $_POST["nic"];
            $fullname = $_POST["fullname"];
            $phone = $_POST["phone"];
            $email = $_POST["email"];
            $address = $_POST["address"];
            $region = $_POST["region"];
            $country = $_POST["country"];
            $locationCoordinate = $_POST["locationCoordinate"];

            $add_data = "INSERT INTO tbl_residents (NIC, Name, Address, PhoneNumber, LocationCoordinate, Email, country, region)
                        VALUES ('$nic', '$fullname', '$address', $phone, '$locationCoordinate', '$email', '$country', '$region')";

            if (mysqli_query($conn, $add_data)){
                echo "Data submitted successfully. Admin will verify your data.";
            } else {
                echo "failed";
            }

        }

?>