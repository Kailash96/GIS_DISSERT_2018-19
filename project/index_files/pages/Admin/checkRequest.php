<?php
    include("../../../db_connect.php");

    // ARRAY TO RETURN TWO DATA
    $return_arr = array(1);

    $value_check = $_POST["checker"];
    $checkQuery = "SELECT * FROM residents WHERE Active = 0";

    $data = "
        <table border='0' width='100%' style='font-size:14px;text-transform:capitalize'>
            <tr>
                <td width='25%'><b>NIC</b></td>
                <td width='55%'><b>Name</b></td>
                <td width='5%'></td>
                <td width='20%'></td>
            </tr>
            <tr><td colspan='4'><hr></td></tr>
    ";
    
    if ($result = mysqli_query($conn, $checkQuery)){
        $checkCount = mysqli_num_rows($result);
        while($row = mysqli_fetch_assoc($result)){
            $data .= "
                <tr>
                    <td style='text-transform:uppercase'>" . $row['NIC'] . "</td>
                    <td>" . $row['Name'] . "</td>
                    <td><div style='border:0px solid black;padding:5px 0;width:100px;box-shadow:0 0 8px green;border-radius:2px;background-color:green;color:white;text-align:center;'>Resident</div></td>
                    <td align='right'><input type='button' value='View Details' id='" . $row['NIC'] . "-resident' onclick='viewDetails(this.id)' style='padding:5px 20px' class='button' /></td>
                </tr>
                <tr><td colspan='4'><hr></td></tr>
            ";
        }
        $data .= '</table>';
    } else {
        $checkCount = 'err';
    }

    $return_arr[0] = $checkCount;
    $return_arr[1] = $data;

    echo json_encode($return_arr);

?>