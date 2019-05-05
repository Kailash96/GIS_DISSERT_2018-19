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

    $data = array(); // ""; // "[";

    // $counter = 0;
    // count number of rows
    //$count_query = "SELECT * FROM tbl_schedule";
    //$count_rw = mysqli_num_rows(mysqli_query($conn, $count_query));

    $schedule_query = "SELECT * FROM tbl_schedule";
    if ($count = mysqli_num_rows($schedules = mysqli_query($conn, $schedule_query)) > 0) {
        while ($sch = mysqli_fetch_assoc($schedules)) {
            $title = $sch['TruckID'];
            $start = $sch['CollectionDate'] . "T" . $sch['TimeStart'];
            $end = $sch['CollectionDate'] . "T" . $sch['TimeEnd'];
            // $counter++;
            
            // CREATE OBJECT AND PUSH TO ARRAY
            $data_object = new calendar($title, $start, $end);
            array_push($data, $data_object);

             // $data_value = 'title: "' . $sch["TruckID"] . '", start: "' . $sch["CollectionDate"] . 'T' . $sch["TimeStart"] . '", end: "' . $sch["CollectionDate"] . 'T' . $sch["TimeEnd"] . '", color: "Yellow"';

            // array_push($data, $data_value);
            
           //  $data .= 'title: "' . $sch["TruckID"] . '", start: "' . $sch["CollectionDate"] . 'T' . $sch["TimeStart"] . '", end: "' . $sch["CollectionDate"] . 'T' . $sch["TimeEnd"] . '", color: "Yellow"';

            /*
            array_merge($data, array(
                'title' => '" . $sch['TruckID'] . "',
                'start' => '" . $sch['CollectionDate'] . "T" . $sch['TimeStart'] . "',
                'end' => '" . $sch['CollectionDate'] . "T" . $sch['TimeEnd'] . "',
                'color' => 'Yellow'
                )
            );
            
            
            if ($counter < $count_rw) {
                $data .= "]";
            }
            */
        }
    }

    //$data .= "]";

    echo json_encode($data);
?>