<?php
    include("../../../../../config/db_connect.php");

    class calendar {
        public function __construct($title, $start, $end) {
            $this->title = $title;
            $this->start = $start;
            $this->end = $end;
            $this->color = "yellow";
        }
    }

    $data = array();

    session_start();
    $collector_ID = $_SESSION['collector_userID'];
    
    $schedule_query = "select * from (((tbl_region inner join tbl_collectors on tbl_region.CollectorsID = tbl_collectors.CollectorID) inner join tbl_zones on tbl_region.regionID = tbl_zones.regionID) inner join tbl_schedule on tbl_zones.zoneID = tbl_schedule.Zone) where tbl_collectors.CollectorID = '$collector_ID'";
    if ($count = mysqli_num_rows($schedules = mysqli_query($conn, $schedule_query)) > 0) {
        while ($sch = mysqli_fetch_assoc($schedules)) {
            $title = $sch['TruckID'] . " | zone: " . $sch['Zone'];
            $start = $sch['CollectionDate'] . "T" . $sch['TimeStart'];
            $end = $sch['CollectionDate'] . "T" . $sch['TimeEnd'];
            
            // CREATE OBJECT AND PUSH TO ARRAY
            $data_object = new calendar($title, $start, $end);
            array_push($data, $data_object);

        }
    }

    echo json_encode($data);
?>