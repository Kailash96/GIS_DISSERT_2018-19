<?php
    $test = array("value1" => 10);

    $value2 = "value2";
    $secondarray = array($value2 => 20);

    $test = array_merge($test, array($value2 => 20));

    echo $test["value2"];
?>