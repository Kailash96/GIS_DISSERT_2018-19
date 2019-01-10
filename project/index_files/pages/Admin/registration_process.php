<?php
    include("../../../db_connect.php");

    $empNum = $_POST['employeeNumber'];
    $empName = $_POST['employeeName'];
    $password = "test";

    function fetch_data(){
        include("../../../db_connect.php");
        $fetch_query = "SELECT * FROM employees";
        if ($results = mysqli_query($conn, $fetch_query)){
            $table = "<table style='padding:0 10px'>
                    <tr>
                        <td style='width:25%'>Employee Number</td>
                        <td style='width:50%'>Employee Name</td>
                        <td style='width:25%'>Options</td>
                    </tr>
                    <tr><td colspan='3'><hr></td></tr>";
            while ($row = mysqli_fetch_assoc($results)) {
                $table .=
                "<tr>
                    <td>" . $row['EmployeeNumber'] . "</td>
                    <td>" . $row['EmployeeName'] . "</td>
                    <td>
                        <input type='hidden' value=" . $row['EmployeeNumber'] . " id='" . $row['EmployeeNumber'] . "' />
                        <input type='hidden' value=" . $row['EmployeeName'] . " id='" . $row['EmployeeNumber'] . "_" . $row['EmployeeName'] . "' />
                        <input type='button' value='Edit' onclick='edit_data(" . $row['EmployeeNumber'] . ".value, " . $row['EmployeeNumber'] . "_" . $row['EmployeeName'] . ".value)' class='button' />
                        <input type='button' value='Remove' class='button' />
                    </td>
                </tr>
                <tr><td colspan='3'><hr></td></tr>";
            }
            $table .= "</table>";
            $data = json_encode($table);
            echo $data;
        }
    }

    if ($empNum == 1 AND $empName == 1){
        fetch_data();
    } else {
        $register_query = "INSERT INTO employees VALUES ('$empNum', '$empName', '$password')";
        if (mysqli_query($conn, $register_query)){
            fetch_data();
        } else {
            echo "error";
        }
    }
?>