<?php
    include("../../../db_connect.php");

    $prevEmpNum = $_POST['prevEmpNum'];
    $empNum = $_POST['empNum'];
    $empFName = $_POST['empFName'];
    $empLName = $_POST['empLName'];

    $update_query = "UPDATE employees SET EmployeeNumber = '$empNum', EmployeeFirstName = '$empFName', EmployeeLastName = '$empLName' WHERE EmployeeNumber = '$prevEmpNum'";
    if (mysqli_query($conn, $update_query)){
        echo "success";
    } else {
        echo "fail";
    }
?>