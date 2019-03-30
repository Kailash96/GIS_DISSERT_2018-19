<?php
    include("../../config/db_connect.php");

    $profileID = $_POST['genID'];

    $profile = "";

    $userdataQuery = "SELECT * FROM tbl_generator WHERE GeneratorID = '$profileID' LIMIT 1";
    if ($userdata = mysqli_query($conn, $userdataQuery)) {
        $data = mysqli_fetch_assoc($userdata);
    }

    $profile .= "
        <input type='button' value='Back' style='background-color:white;border:1px solid black;box-shadow: 0 0 1px black;padding:8px;border-radius:2px;width:100px;cursor:pointer' onclick='user_list(category.value)' /><br/><br/>
        <table border='0' width='100%'>
            <tr>
                <th colspan='2'><h1 style='margin:0;text-align:left;box-shadow:0 2px 1px black;padding:10px;'>User Profile</h1></th>
            <tr>
            <tr>
                <td style='vertical-align:top;padding:20px' width='50%'>
                    User ID
                    <h3 style='padding:0;margin:0'>" . strtoupper($profileID) . "</h3>
                    <br/>
                    Username
                    <h3 style='padding:0;margin:0'>" . ucwords($data['Name']) . "</h3>
                    <br/>
                    User Email
                    <h3 style='padding:0;margin:0'>" . $data['Email'] . "</h3>
                </td>
                <td style='vertical-align:top;padding:20px'>
                    <div>Date Registered:<br/>" . date("D, d M Y", strtotime($data['dateReg'])) . "</div><br/>
                    User Address
                    <h3 style='padding:0;margin:0'>" . ucwords($data['Address']) . "</h3>
                    <br/><br/>
                    <input type='button' style='background-color:white;border:1px solid black;box-shadow: 0 0 1px black;padding:8px;border-radius:2px;width:150px;cursor:pointer' value='Edit' />
                    <input type='button' style='background-color:red;color:white;border:1px solid red;box-shadow: 0 0 1px red;padding:8px;border-radius:2px;width:150px;cursor:pointer' value='Delete Account' onclick='deleteAccount(" . json_encode($profileID) . ")' />
                </td>
            </tr>
            <tr>
                <td colspan='2' style='padding:10px;box-shadow:0 2px 1px black;'><h2 style='padding:0;margin:0'>Bin Details</h2></td>
            </tr>
            ";

            $getBinLevelQuery = "SELECT * FROM tbl_waste_gen WHERE generatorID = '$profileID' ORDER BY wgID DESC LIMIT 1";
            if ($getBinLevel = mysqli_query($conn, $getBinLevelQuery)) {
                $binLevel = mysqli_fetch_assoc($getBinLevel);
                if ($binLevel['Organic'] == 0) {
                    $binLevelOrganic = 0;
                } else {
                    $binLevelOrganic = $binLevel['Organic'];
                }
                if ($binLevel['Plastic'] == "") {
                    $binLevelPlastic = 0;
                } else {
                    $binLevelPlastic = $binLevel['Plastic'];
                }
                if ($binLevel['Paper'] == "") {
                    $binLevelPaper = 0;
                } else {
                    $binLevelPaper = $binLevel['Paper'];
                }
                if ($binLevel['Other'] == "") {
                    $binLevelOther = 0;
                } else {
                    $binLevelOther = $binLevel['Other'];
                }
            } else {
                $binLevelOrganic = 0;
                $binLevelPlastic = 0;
                $binLevelPaper = 0;
                $binLevelOther = 0;
            }

            $profile .= "<tr>
                <td style='padding:10px;' align='center' colspan='2'>
                    <div style='display:inline-block;text-align:center;width:220px;border:1px solid black;padding:12px;border-radius:2px'>
                        <h3 style='margin:0'>Organic</h3><br/>
                        <div style='font-size:20px'>" . $binLevelOrganic . " %</div><br/>
                        <input type='button' value='Reset' id='Organic' onclick='resetBin(this.id, " . json_encode($profileID) . ")' style='background-color:white;border:1px solid black;box-shadow: 0 0 1px black;padding:8px;border-radius:2px;width:150px;cursor:pointer' />
                    </div>
                    <div style='display:inline-block;text-align:center;width:220px;border:1px solid black;padding:12px;border-radius:2px'>
                        <h3 style='margin:0'>Plastic</h3><br/>
                        <div style='font-size:20px'>" . $binLevelPlastic . " %</div><br/>
                        <input type='button' value='Reset' id='Plastic' onclick='resetBin(this.id, " . json_encode($profileID) . ")' style='background-color:white;border:1px solid black;box-shadow: 0 0 1px black;padding:8px;border-radius:2px;width:150px;cursor:pointer' />
                    </div>
                    <div style='display:inline-block;text-align:center;width:220px;border:1px solid black;padding:12px;border-radius:2px'>
                        <h3 style='margin:0'>Paper</h3><br/>
                        <div style='font-size:20px'>" . $binLevelPaper . " %</div><br/>
                        <input type='button' value='Reset' id='Paper' onclick='resetBin(this.id, " . json_encode($profileID) . ")' style='background-color:white;border:1px solid black;box-shadow: 0 0 1px black;padding:8px;border-radius:2px;width:150px;cursor:pointer' />
                    </div>
                    <div style='display:inline-block;text-align:center;width:220px;border:1px solid black;padding:12px;border-radius:2px'>
                        <h3 style='margin:0'>Other</h3><br/>
                        <div style='font-size:20px'>" . $binLevelOther . " %</div><br/>
                        <input type='button' value='Reset' id='Other' onclick='resetBin(this.id, " . json_encode($profileID) . ")' style='background-color:white;border:1px solid black;box-shadow: 0 0 1px black;padding:8px;border-radius:2px;width:150px;cursor:pointer' />
                    </div>
                </td>
            </tr>
        </table>
    ";

    echo json_encode($profile);
?>