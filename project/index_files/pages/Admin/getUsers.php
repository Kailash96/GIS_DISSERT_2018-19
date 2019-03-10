<?php
    include("../../../db_connect.php");

    $category = $_POST['category'];

    $content = "
        <table width='100%' cellspacing='0' border='0' class='table'>
            <tr>
                <th width='18%'>User ID</th>
                <th width='24%'>Username</th>
                <th width='26%'>Email</th>
                <th width='10%'>Status</th>
                <th width='12%'>Date Created</th>
                <th width='10%'></th>
            </tr>
    ";
    $getUserQuery = "SELECT * FROM tbl_generator WHERE Category = '$category' ORDER BY dateReg DESC";
    if ($data_result = mysqli_query($conn, $getUserQuery)) {
        while ($rw = mysqli_fetch_assoc($data_result)) {
            $content .= "
                <tr>
                    <td>" . $rw['GeneratorID'] . "</td>
                    <td>" . $rw['Name'] . "</td>
                    <td>" . $rw['Email'] . "</td>";
                    if ($rw['Active']){
                        $content .= "<td style='color:green'><i class='fa fa-check-square' style='color:green;'></i> Active</td>";
                    } else {
                        $content .= "<td style='color:red'><i class='fa fa-window-close' style='font-size:12px;color:red;'></i> Inactive</td>";
                    }
            
            $content .= "
                    <td>" . $rw['dateReg'] . "</td>
                    <td><input type='button' value='View Account' id='" . $rw['GeneratorID'] . "' onclick='viewAccount(this.id)' class='view_button' /></td>
                </tr>
            ";
        }
    }

    $content .= "</table>";

    echo json_encode($content);

?>