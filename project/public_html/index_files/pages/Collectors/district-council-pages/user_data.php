<?php
    include("../../../../../config/db_connect.php");

    $userID = $_POST['userID'];

    $data = array();
    
    // GET USER BIN LEVELS
    $userBinLevelQuery = "SELECT * FROM tbl_waste_gen WHERE generatorID = '$userID' ORDER BY wgID DESC LIMIT 1";
    if (mysqli_num_rows($result = mysqli_query($conn, $userBinLevelQuery)) > 0) {
        $bin = mysqli_fetch_assoc($result);
        array_push($data, $bin['Organic']);
        array_push($data, $bin['Plastic']);
        array_push($data, $bin['Paper']);
        array_push($data, $bin['Other']);
    } else {
        array_push($data, 0);
        array_push($data, 0);
        array_push($data, 0);
        array_push($data, 0);
    }
    
    // GET USER DETAILS
    $userDataQuery = "SELECT GeneratorID, Name, Address, PhoneNumber, Email, Country, tbl_generator.ZoneID AS usr_zone, tbl_region.regionName AS usr_region FROM ((tbl_generator LEFT JOIN tbl_zones ON tbl_generator.zoneID = tbl_zones.zoneID) LEFT JOIN tbl_region ON tbl_zones.regionID = tbl_region.regionID) WHERE tbl_generator.GeneratorID = '$userID' LIMIT 1";
    if ($result = mysqli_query($conn, $userDataQuery)) {
        $row = mysqli_fetch_assoc($result);
        array_push($data, $row['GeneratorID']);
        array_push($data, $row['Name']);
        array_push($data, $row['Address']);
        array_push($data, $row['PhoneNumber']);
        array_push($data, $row['Email']);
        array_push($data, $row['Country']);
        array_push($data, $row['usr_zone']);
        array_push($data, $row['usr_region']);
    }

    // LAYOUT
    $content = '
        <table border="0" style="text-transform:capitalize;font-size:14px;border-spacing:0 10px;width:100%">
            <tr>
                <td colspan="2">Username<br/><b>' . $data[5] . '</b></td>
                <td colspan="2">NIC<br/><b>' . $data[4] . '</b></td
            </tr>
            <tr>
                <td colspan="4">Address<br/><b>' . $data[6] . '</b></td>
            </tr>
            <tr>
                <td colspan="2">Region<br/><b>' . $data[11] . '</b></td>
                <td colspan="2">Zone<br/><b>' . $data[10] . '</b></td>
            </tr>
            <tr>
                <td width="25%">
                    Domestic<br><b>' . $data[0] . '%</b>
                </td>
                <td width="25%">
                    Plastic<br><b>' . $data[1] . '%</b>
                </td>
                <td width="25%">
                    Paper<br><b>' . $data[2] . '%</b>
                </td>
                <td width="25%">
                    Other<br><b>' . $data[3] . '%</b>
                </td>
            </tr>
        </table>
    ';

    echo json_encode($content);

?>