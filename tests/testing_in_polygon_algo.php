<?php
        $coords =  [[-20.165590, 57.736680],  [-20.200344,57.757233],  [-20.213680,57.702259], [-20.171716,57.712306], [-20.165590, 57.736680]];

        $marker_check = [-20.19096149460747,57.71931409835816];

        function inside($point, $vs) {

            $x = $point[0];
            $y = $point[1];
            
            $inside = false;
            for ($i = 0, $j = sizeof($vs) - 1; $i < sizeof($vs); $j = $i++) {
                $xi = $vs[$i][0];
                $yi = $vs[$i][1];
                $xj = $vs[$j][0];
                $yj = $vs[$j][1];
                
                $intersect = (($yi > $y) != ($yj > $y)) && ($x < ($xj - $xi) * ($y - $yi) / ($yj - $yi) + $xi);
                if ($intersect) $inside = !$inside;
            }

            return $inside;
            
        };

        echo inside($marker_check, $coords) . "<br/>";
        echo $coords[0][1];

        

        // var polygon = "[[4040958.21,261090.239],[4399737.773,261090.239],  [4399737.773,1004118.285],[4040958.21,1004118.285]]";
        // var poly_json = JSON.parse(polygon);

        // The below are two examples.  One of them is inside the other is outside to bounding box
        // inside -->
        // test = inside([ 4147263, 646445.066 ], poly_json); // true
         // outside -->
        
        // test = inside([ 4537048, 694061 ], polygon); // false
        
?>