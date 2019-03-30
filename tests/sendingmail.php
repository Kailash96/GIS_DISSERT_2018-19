<?php
    $nic = "c011196130765e";
    $password_mail = "test";

    $msg = "
        Thank you for your registration on <b>Binswiper</b><br/>
        Your account has been activated successfully,<br/>
        you can now proceed to login.<br/><br/>
        Your login credentials:<br/>
        Username: " . strtoupper($nic) . "<br/>
        Password: " . $password_mail . "
    ";

    $email = "kailash_chooramun@hotmail.com";
    
    $msg = wordwrap($msg, 70);
    mail($email, "Account activated | Binswiper", $msg);
    
?>