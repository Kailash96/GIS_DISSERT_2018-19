<?php
    include("../../config/db_connect.php");

    $category = $_POST['cat'];
    $data = "
        <table border='0' width='100%' cellspacing='12px'>
    ";

    $getListQuery = "SELECT * FROM tbl_collectors WHERE Category = '$category'";
    if ($getList = mysqli_query($conn, $getListQuery)) {
        while ($list = mysqli_fetch_assoc($getList)) {
            $data .= "
                <tr style='box-shadow:0 1px 1px black;'>
                    <td style='font-size:14px;padding:8px'>
                        Name<br/>
                        <b>" . ucwords($list['Name']) . "</b>
                        <br/><br/>
                        Telephone
                        <br/>
                        <b>" . $list['Telephone'] . "</b>
                    </td>
                    <td style='font-size:14px;padding:8px'>
                        Address
                        <br/>
                        <b>" . $list['Address'] . "</b>
                        <br/><br/>
                        Region covered
                        <br/>
                        <b>" . $list['RegionName'] . "</b>
                    </td>
                </tr>
            ";
        }
    }

    $data .= "</table>";
    echo json_encode($data);
?>