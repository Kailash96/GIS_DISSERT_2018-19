<!DOCTYPE HTML>
<html>
    <head>
        <title>Welcome | Binswiper</title>
        <link rel="stylesheet" href="index_files/css_files/style.css" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <style>
            .loginbox{
                border:1px solid #002246;
                border-radius:3px;
                padding:10px;
                margin:4px 0;
                width:100%;
                box-sizing:border-box;
                outline:none;
            }
        </style>

        <?php include_once('log_reg_server.php'); ?>
    </head>
    <body style="margin:0;">
        <div align="center">
            <h1 style="color:#002246"><i class="fa fa-trash-o"></i> Binswiper</h1>
            <div style='box-shadow:0 0 8px #002246;display:block;width:300px;text-align:left;padding:0 20px;border:1px solid transparent;border-radius:4px'>
                <form method="post" action="<?php $_SERVER['PHP_SELF']; ?>">
                    <h4>Login</h4>
                    <input type="text" placeholder="NIC/Reg Number" name="userid" style="text-transform:uppercase;" class="loginbox" required /><br/>
                    <input type="password" placeholder="password" name="userpassword" class="loginbox" required /><br/>
                    <input type="submit" name="lgn" value="login" class="button" style="float:right;" />
                </form>
                <h5>New user? <a href="index_files/pages/registration_navigator.php" style="color:#002246">Click here to register.</a></h5>
            </div>
        </div>

        <h1>temporary links:</h1><br/>
        <a href="index_files/pages/resident-pages/resident-home.php" target="_blank">resident home page</a><br/>
        <a href="index_files/pages/admin/admin-home.php" target="_blank">admin page</a><br/>
        <a href="index_files/pages/district-council-pages/overview.php" target="_blank">district council page</a><br/>
        <a href="">municipality page</a><br/>
        <a href="">local authorities</a><br/>
        <a href="index_files/pages/employees/employee-signin.php" target="_blank">Employee page</a>
    </body>
</html>