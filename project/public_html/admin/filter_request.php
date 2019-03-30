<?php
    include("../../config/db_connect.php");

    $category = $_POST['category'];
    $getFilterData = "SELECT * FROM tbl_generator WHERE Active = 0 AND Category = '$category'";
        if ($getFilter = mysqli_query($conn, $getFilterData)) {
            $data = "
            <table border='0' width='100%' style='font-size:14px;text-transform:capitalize'>
                <tr>
                    <td width='25%'><b>NIC/RegNumber</b></td>
                    <td width='25%'><b>Name</b></td>
                    <td width='16%'>Date Registered</td>
                    <td width='16%'></td>
                    <td width='16%'></td>
                </tr>
                <tr><td colspan='5'><hr></td></tr>
            ";

            while ($row = mysqli_fetch_assoc($getFilter)) {
                $data .= "
                    <tr>
                        <td style='text-transform:uppercase'>" . $row['GeneratorID'] . "</td>
                        <td>" . $row['Name'] . "</td>
                        <td>" . $row['dateReg'] . "</td>
                        <td><div style='border:0px solid black;padding:5px 0;width:100px;box-shadow:0 0 4px green;border-radius:2px;color:green;text-align:center;'>" . $row['Category'] . "</div></td>
                        <td align='right'><input type='button' value='View Details' id='" . $row['GeneratorID'] . "' onclick='viewDetails(this.id)' style='padding:5px 20px' class='button' /></td>
                    </tr>
                    <tr><td colspan='5'><hr></td></tr>
                ";
            }
        }
        $data .= '</table>';

    echo json_encode($data);
?>