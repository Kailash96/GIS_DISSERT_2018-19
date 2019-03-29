<?php
    include("../../../db_connect.php");

    $empNum = $_POST['employeeNumber'];
    $empFName = $_POST['employeeFName'];
    $empLName = $_POST['employeeLName'];
    $password = "test";

    function fetch_data(){
        include("../../../db_connect.php");
        $fetch_query = "SELECT * FROM employees ORDER BY employeeFirstName ASC";
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
                    <td style='text-transform:uppercase'>" . $row['EmployeeNumber'] . "</td>
                    <td style='text-transform:capitalize'>" . $row['EmployeeFirstName'] . " " . $row['EmployeeLastName'] . "</td>
                    <td>
                        <input type='button' value='Edit' onclick='edit_data(" . json_encode($row['EmployeeNumber']) . ", " . json_encode($row['EmployeeFirstName']) . ", " . json_encode($row['EmployeeLastName']) . ")' class='button' />
                        <input type='button' value='Remove' onclick='confirm_remove_emp(" . json_encode($row['EmployeeNumber']) . ")' class='button' />
                    </td>
                </tr>
                <tr><td colspan='3'><hr></td></tr>";
            }
            $table .= "</table>";
            $data = json_encode($table);
            echo $data;
        }
    }

    if ($empNum == 1 AND $empFName == 1 AND $empLName == 1){
        fetch_data();
    } else {
        $register_query = "INSERT INTO employees VALUES ('$empNum', '$empFName', '$empLName', '$password')";
        if (mysqli_query($conn, $register_query)){
            fetch_data();
        } else {
            echo "error";
        }
    }
?>