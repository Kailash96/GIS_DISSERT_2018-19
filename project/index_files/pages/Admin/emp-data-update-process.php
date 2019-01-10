<?php
    include("../../../db_connect.php");

    $prevEmpNum = $_POST['prevEmpNum'];
    $empNum = $_POST['empNum'];
    $empName = $_POST['empName'];

    $update_query = "UPDATE employees SET EmployeeNumber = '$empNum', EmployeeName = '$empName' WHERE EmployeeNumber = '$prevEmpNum'";
    if (mysqli_query($conn, $update_query)){
        echo "success";
    } else {
        echo "fail";
    }
?>