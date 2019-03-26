<?php
    include("../../../db_connect.php");

    $name = $_POST['name'];
    if ($name == "previousCollection") {
        $prev_month = date("m") - 1;
        $crr_year = date("Y");
        $total_organic = 0;
        $total_plastic = 0;
        $total_paper = 0;
        $total_other = 0;
        
        $query = "SELECT * FROM tbl_waste_gen WHERE MONTH(getDate) = $prev_month AND YEAR(getDate) = $crr_year";
        if ($result = mysqli_query($conn, $query)) {
            while ($row = mysqli_fetch_assoc($result)) {
                $organickg = ($row['Organic'] / 100) * 20;
                $total_organic += $organickg;
                $plastickg = ($row['Plastic'] / 100) * 20;
                $total_plastic += $plastickg;
                $paperkg = ($row['Paper'] / 100) * 20;
                $total_paper += $paperkg;
                $otherkg = ($row['Other'] / 100) * 20;
                $total_other += $otherkg;
            }
        }
        $data = array();
        array_push($data, $total_organic, $total_plastic, $total_paper, $total_other);
        echo json_encode($data);
    } else if ($name == "amountperregion") {
        $prev_month = date("m") - 1;
        $crr_year = date("Y");
        $total_organic = 0;
        $total_plastic = 0;
        $total_paper = 0;
        $total_other = 0;
        $region_array = array();

        $test = array();

        $region_query = "SELECT * FROM tbl_region";
        if ($result = mysqli_query($conn, $region_query)) {
            while ($region_row = mysqli_fetch_assoc($result)) {
                $total_amount_array = array();
                $crr_region = $region_row['regionName'];
                $getWasteAmountQuery = "SELECT * FROM tbl_waste_gen LEFT JOIN tbl_generator ON tbl_waste_gen.generatorID = tbl_generator.GeneratorID WHERE MONTH(tbl_waste_gen.getDate) = $prev_month AND YEAR(tbl_waste_gen.getDate) = $crr_year AND tbl_generator.region = '$crr_region'";
                if ($counter = mysqli_num_rows($region_result = mysqli_query($conn, $getWasteAmountQuery))) {
                    while ($amount = mysqli_fetch_assoc($region_result)) {
                        $total_organic += $amount['Organic'];
                        $total_plastic += $amount['Plastic'];
                        $total_paper += $amount['Paper'];
                        $total_other += $amount['Other'];
                    }
                }
                $binname = "bin_" . $crr_region;
                array_push($total_amount_array, array($total_organic, $total_plastic, $total_paper, $total_other));
                $region_array = array_merge($region_array, array($crr_region => $total_amount_array, $binname => $counter));
                unset($total_amount_array);

                $total_organic = 0;
                $total_plastic = 0;
                $total_paper = 0;
                $total_other = 0;
            }
        }

        echo json_encode($region_array);

    } else if ($name == "comparisons") {
        $monthly_amount = array("Months");
        $total_organic = 0;
        $total_plastic = 0;
        $total_paper = 0;
        $total_other = 0;
        
        $crr_year = date("Y");
        for ($month = 1; $month <= 12; $month++) {
            $query = "SELECT * FROM tbl_waste_gen WHERE MONTH(getDate) = $month AND YEAR(getDate) = $crr_year";
            if ($count = mysqli_num_rows($result = mysqli_query($conn, $query))) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $total_organic += ($row['Organic'] / 100) * 20;
                    $total_plastic += ($row['Plastic'] / 100) * 20;
                    $total_paper += ($row['Paper'] / 100) * 20;
                    $total_other += ($row['Other'] / 100) * 20;
                }
            }

            $total_full = (20 * $count) * 4; // 20KG * NUMBER OF USERS * 4 WEEKS (1MONTH)
            array_push($monthly_amount, array($total_organic, $total_plastic, $total_paper, $total_other, $total_full));

            $total_organic = 0;
            $total_plastic = 0;
            $total_paper = 0;
            $total_other = 0;
        }

        echo json_encode($monthly_amount);

    }

?>