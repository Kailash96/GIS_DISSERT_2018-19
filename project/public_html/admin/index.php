<?php
    include("../../config/db_connect.php");
?>
<html>
    <head>
        <title>Administrator</title>
    </head>
    <body>
        <h1>Admin Login</h1>
        <form method="POST" action="admin-home.php"> <!-- to change action target -->
            <input type="text" name="admin_username" placeholder="Username" /><br/><br/>
            <input type="password" name="admin_password" placeholder="Password" /><br/><br/>
            <input type="submit" value="Login" />
        </form>
    </body>
</html>