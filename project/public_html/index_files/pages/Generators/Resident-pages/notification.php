<?php
    include("../../../../../config/db_connect.php");

    session_start();
    $userID = $_SESSION['userID'];
    $zone = $_SESSION['zone'];

    $table = "
        <table>
            <tr>
                <td>Notifications:</td>
            </tr>
    ";
    $query = "SELECT * FROM tbl_carry_forward INNER JOIN tbl_schedule ON tbl_schedule.ScheduleID = tbl_carry_forward.schedule_ID WHERE tbl_schedule.Zone = $zone AND tbl_carry_forward.read_receipt = 0";
    $carry_forward = mysqli_query($conn, $query);
    while ($data = mysqli_fetch_assoc($carry_forward)) {
        $table .= "
            <tr>
                <td>Collection for " .  . "</td>
            </tr>
        ";
    }

    $table .= "</table>";

    echo json_encode($table);


?>