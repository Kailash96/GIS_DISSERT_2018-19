<?php
    include("../../../db_connect.php");

    $userID = $_POST['userID'];
    $username = $_POST['username'];

    $data = "
        <h3 align='left'>Citizen Details</h3>
        <div class='data_box'>
            <h4><i class='fa fa-id-card-o'></i> " . $username . "</h4>
            <h4><i class='fa fa-id-badge'></i> " . $userID . "</h4>
            <h4><i class='fa fa-pie-chart'></i> Total No. of Bins:</h4>
            <input type='hidden' value='$userID' id='user_bin' />
            <input type='button' value='Add Bins +' onclick='popupaddbin(user_bin.value)' class='button' style='position:absolute;top:7px;right:10px;padding:4px 8px;' />
        </div>
    ";

    $getbinsquery = "SELECT * FROM bins WHERE GeneratorID = '$userID'";
    if (mysqli_num_rows($result = mysqli_query($conn, $getbinsquery)) > 0) {

    } else {
        $data .= "
            
        ";
    }

    $data .= "</table>";

    echo json_encode($data);
?>