<?php
            include("db_connect.php");

            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                
                $userid = $_POST['userid'];
                $password = $_POST['userpassword'];

                $checkID_query = "SELECT * FROM generatorslogin WHERE GeneratorID = '$userid'";
                $checkPass_query = "SELECT * FROM generatorslogin WHERE Password = '$password'";

                if (mysqli_num_rows($checkCat = mysqli_query($conn, $checkID_query)) > 0){
                    if (mysqli_num_rows($result = mysqli_query($conn, $checkPass_query)) > 0){

                        session_start();
                        $_SESSION['userID'] = $userid;
                        
                        $row = mysqli_fetch_assoc($checkCat);
                        if ($row['Category'] == 'resident') {
                            $getDataQuery = "SELECT * FROM residents WHERE NIC = '$userid'";
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
                
            }
            
        ?>