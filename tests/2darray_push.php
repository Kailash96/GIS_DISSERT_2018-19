<?php
    $array = array();
    // $array = [["hello world"]["second value"]];
    // $array = [["testing"]["testing 2"]];
    array_push($array,
        array(
            array("the pushed value","hello world"),
            array("second value", "second column")
        )
    );

    print_r($array);

?>