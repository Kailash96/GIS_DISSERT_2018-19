<?php
    include("../../../db_connect.php");

    $nic = $_POST['nic'];
    $fullname = $_POST['fname'];
    $email = $_POST['email'];

    $password_mail = strtolower(substr($fullname, 0, 3) . substr($nic, -3));
    $password = SHA1(strtolower(substr($fullname, 0, 3) . substr($nic, -3)));
    
    $act_query = "UPDATE tbl_generator SET Active = 1 WHERE GeneratorID = '$nic'";
    
    if (mysqli_query($conn, $act_query)){
        $setacctQuery = "INSERT INTO tbl_generators_login (GeneratorID, Password) VALUES ('$nic', '$password')";
        mysqli_query($conn, $setacctQuery);
        // EMAIL USER
        $msg = "
            Thank you for your registration on <b>Binswiper</b>\n
            Your account has been activated successfully,\n
            you can now proceed to login.\n\n
            Your login credentials:\n
            Username: " . strtoupper($nic) . "\n
            Password: " . $password_mail . "
        ";

        $msg = wordwrap($msg, 70);
        mail($email, "Account activated | Binswiper", $msg);
    }

?>