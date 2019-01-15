<!DOCTYPE HTML>
<html>
    <head>
        <title>Employee Login | Binswiper</title>
        <link rel="stylesheet" href="../../css_files/style.css" />
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
    </head>
    <body style="margin:0;">
        <?php
            if (!empty($_POST)) {
                // submitted
                include("../../../db_connect.php");
                $empl_ID = $_POST['empID'];
                $empID = (string)$empl_ID;
                $password = $_POST['empPassword'];

                $check_query = "SELECT * FROM employees WHERE EmployeeNumber = '$empID'";
                if ($result = mysqli_query($conn, $check_query)){
                    while($row = mysqli_fetch_assoc($result)){
                        echo $row['EmployeeNumber'];
                    }
                } else {
                    echo "failure";
                }

            }
        ?>
        <div align="center">
            <h1 style="color:#002246"><i class="fa fa-trash-o"></i> Binswiper</h1>
            <h3 style="color:#002246">Employee Login</h3>
            <div style='box-shadow:0 0 8px #002246;display:block;width:300px;text-align:left;padding:0 20px;border:1px solid transparent;border-radius:4px'>
                <h4>Login</h4>
                <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                    <input type="text" placeholder="Employee Number" name="empID" class="loginbox" /><br/>
                    <input type="password" placeholder="password" name="empPassword" class="loginbox" /><br/>
                    <div align="right"><input type="submit" value="Login" class="button" /></div><br/>
                </form>
            </div>
        </div>

    </body>
</html>