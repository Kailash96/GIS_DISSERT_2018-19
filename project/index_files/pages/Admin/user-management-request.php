<?php
    include('../../../db_connect.php');

    $category = $_POST['category'];
    $user_id = $_POST['user_id'];

    if ($category == 'residents'){
        if ($user_id == 0) {
            $account_list_query = "SELECT * FROM residents WHERE Active = 1";
        } else {
            $account_list_query = "SELECT * FROM residents WHERE NIC = '$user_id'";
        }
    } else if ($category == 'commercial') {
        if ($user_id == 0) {
            $account_list_query = "SELECT * FROM commercial WHERE Active = 1";
        } else {
            $account_list_query = "SELECT * FROM commercial WHERE RegNo = '$user_id'";
        }
    } else if ($category == 'industrial') {
        if ($user_id == 0) {
            $account_list_query == "SELECT * FROM industrial WHERE Active = 1";
        } else {
            $account_list_query == "SELECT * FROM industrial WHERE RegNo = '$user_id'";
        }
    }

    $data = "";
    if ($results = mysqli_query($conn, $account_list_query)) {
        while ($row = mysqli_fetch_assoc($results)) {
            if ($category == 'residents') {
                $userid = $row['NIC'];
                $username = $row['Name'];
                $data .= "
                    <table border='0'>
                        <tr>
                            <td style='width:240px;text-transform:uppercase;'><i class='fa fa-address-card-o'></i> " . $row['NIC'] . "</td>
                            <td style='width:240px;text-transform:capitalize'><i class='fa fa-user-circle-o'></i> " . $row['Name'] . "</td>
                        </tr>
                        <tr>
                            <td><a href='#'><i class='fa fa-edit'></i> View/Edit Profile</a></td>
                            <input type='hidden' value='$userid' id='usernic_" . $userid . "' />
                            <input type='hidden' value='$username' id='username_" . $userid . "'/>
                            <td><a href='#' onclick='bin_control(usernic_" . $userid . ".value, username_". $userid . ".value)'><i class='fa fa-trash'></i> Bin Control</a></td>
                        </tr>
                    </table>
                ";
            } else if ($category == 'commercial') {
                $data .= "
                    <table>
                        <tr>
                            <td style='width:240px;text-transform:uppercase;'><i class='fa fa-address-card-o'></i> " . $row['RegNo'] . "</td>
                            <td style='text-transform:capitalize'><i class='fa fa-user-circle-o'></i> " . $row['Name'] . "</td>
                        </tr>
                    </table>
                ";
            } else if ($category == 'industrial') {
                $data .= "
                    <table>
                        <tr>
                            <td style='width:240px;text-transform:uppercase;'><i class='fa fa-address-card-o'></i> " . $row['RegNo'] . "</td>
                            <td style='text-transform:capitalize'><i class='fa fa-user-circle-o'></i> " . $row['Name'] . "</td>
                        </tr>
                    </table>
                ";
            }
        }
    }

    echo json_encode($data);
    
?>