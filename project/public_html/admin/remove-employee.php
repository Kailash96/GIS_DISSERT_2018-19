<?php
    include("../../config/db_connect.php");

    $empID = $_POST['empid'];
    $remove_query = "DELETE FROM employees WHERE EmployeeNumber = '$empID'";
    if (mysqli_query($conn, $remove_query)){
        echo "success";
    } else {
        echo "fail";
    }
?>