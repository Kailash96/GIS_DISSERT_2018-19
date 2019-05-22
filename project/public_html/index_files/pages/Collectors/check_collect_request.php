<?php
    include("../../../../config/db_connect.php");

    session_start();
    $category = $_SESSION['collector_category'];
    $data_value = "<table border='0' class='notif_box' cellspacing='0'>";
    $query = "select *, tbl_generator.Name AS genName from (((tbl_collection_request inner join tbl_generator on tbl_collection_request.UserID = tbl_generator.GeneratorID) inner join tbl_zones on tbl_generator.zoneID = tbl_zones.zoneID) inner join tbl_collectors on tbl_zones.regionID = tbl_collectors.RegionID) where tbl_collection_request.Approval = 0 and tbl_collectors.Category != 'Recycler' AND tbl_collectors.Category = '$category'";
    if (($count = mysqli_num_rows($notif = mysqli_query($conn, $query))) > 0) {
        while ($data = mysqli_fetch_assoc($notif)) {
            $data_value .= "
                <tr><td style='padding-top:25px'><div style='background-color:#0099C6;color:white;padding:4px 8px;border-radius:3px;'>Request</div></td><tr>
                <tr>
                    <td><h5>User ID:</h5>" . $data['UserID'] . "<br/>
                    <h5>User Name:</h5>" . $data['genName'] . "</td>
                    <td><h5>Tel/Mobile:</h5>" . $data['PhoneNumber'] . "<br/>
                    <h5>Waste Amount:</h5><span style='color:red'>" . $data['WasteAmount'] . "KG</span></td>
                    <td style='vertical-align:text-top'><h5>Address:</h5>" . $data['Address'] . "<br/>
                    <h5>Collection Date</h5><span style='color:red'>" . $data['CollectionDate'] . "</span></td>
                    <td>
                        <input type='button' value='Accept' class='btn' id=" . $data['RID'] . "_1" . " onclick='request_review(1, this.id)' /><br/><br/>
                        <input type='button' value='Reject' class='btn' id=" . $data['RID'] . "_0" . " onclick='request_review(0, this.id)' />
                    </td>
                </tr>
                <tr><td colspan='4'><hr></td></tr>
            ";
        }
    }

    $data_value .= "</table>";

    $content = array($count, $data_value);
    echo json_encode($content);

?>