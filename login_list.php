<?php
    include("project/db_connect.php");

    $getList = "SELECT * FROM tbl_residents WHERE Active = 1";

    $table = "<table>";
    if ($results = mysqli_query($conn, $getList)) {
        while ($row = mysqli_fetch_assoc($results)) {
            $table .= "
                <tr>
                    <td>" . $row['NIC'] . "</td>
                    <td>" . substr($row['Name'], 0, 3) . substr($row['NIC'], -3) . "</td>
                </tr>
            ";
        }
    }
    $table .= "</table>";

    echo $table;
?>