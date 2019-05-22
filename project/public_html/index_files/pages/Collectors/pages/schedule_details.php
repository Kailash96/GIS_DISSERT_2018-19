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

    $schedule_query = "SELECT * FROM tbl_schedule";
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