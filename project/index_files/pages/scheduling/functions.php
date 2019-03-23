<?php

    function getRoute($region, $zone, $category, $waste_type){
        global $conn;
        $generalQuery =
            "SELECT
                tbl_generator.GeneratorID,
                tbl_waste_gen.generatorID,
                tbl_waste_gen.getDate,
                tbl_waste_gen.getTime,
                tbl_waste_gen.$waste_type,
                tbl_generator.zoneID,
                tbl_generator.Region,
                tbl_generator.LocationCoordinate
            FROM
                tbl_waste_gen
            INNER JOIN
                tbl_generator
            ON
                tbl_waste_gen.generatorID = tbl_generator.GeneratorID
            WHERE
                tbl_waste_gen.getDate
            IN
                (
                    SELECT
                        MAX(getDate)
                    FROM
                        tbl_waste_gen
                    GROUP BY
                        generatorID
                )
            AND
                tbl_waste_gen.getTime
            IN
                (
                    SELECT
                        MAX(getTime)
                    FROM
                        tbl_waste_gen
                    GROUP BY
                        generatorID
                )
            AND
                tbl_generator.zoneID = $zone
            AND
                tbl_waste_gen.$waste_type > 0
            AND
                tbl_generator.Category = '$category'
            AND
                tbl_generator.Region = '$region'
            GROUP BY
                tbl_waste_gen.generatorID
            ORDER BY
                tbl_waste_gen.getDate DESC
            ";

            $route_array = array();
            $numOfHouses = 0;
            $total_waste = 0;
            $data_array = array();
            $wasteAmountPerUser = array();

            if ($getResult = mysqli_query($conn, $generalQuery)) {
                while ($row = mysqli_fetch_assoc($getResult)) {
                    $location = $row['LocationCoordinate'];
                    $waste_amount = json_decode($row[$waste_type]);
                    if ($category == "Resident") {
                        // CONVERT AMOUNT TO KG (ACTURALLY IN %)
                        $waste_amount_in_kg = ($waste_amount / 100) * 20;
                    } else {
                        // CONVERT AMOUNT TO KG (ACTURALLY IN %)
                        $waste_amount_in_kg = ($waste_amount / 100) * 80;
                    }
                    array_push($route_array, $location);
                    array_push($wasteAmountPerUser, $waste_amount_in_kg);
                    $numOfHouses++;
                    $total_waste += $waste_amount_in_kg;
                }
            }

            if (sizeof($route_array) > 0) {
                array_push($data_array, array($route_array, $numOfHouses, $total_waste, $wasteAmountPerUser));
                return $data_array;
            } else {
                return 0;
            }

    }

    function createTrips($trip_builder_array, $regionName, $category, $wasteType, $allTrucks, $tbl_route_ID){

        for ($t = 0; $t < sizeof($allTrucks); $t++) {
            if ($allTrucks[$t][5] == 1) {
                if (($allTrucks[$t][0] == $category) && ($allTrucks[$t][1] == $wasteType) && ($allTrucks[$t][2] == $regionName)) {
                    setTrip($allTrucks[$t][3], $trip_builder_array, $allTrucks[$t][4], $category, $tbl_route_ID);
                    return $t;
                } 
            }
        }
        return -1;
    }

    function setTrip($truckCapacity, $tripBuilder, $truck, $category, $tbl_route_ID){

        global $tripArray;
        $tracker = $truckCapacity;
        $tripPath = array();
        $total_waste_per_trip = 0;

        for ($b = 0; $b < sizeof($tripBuilder); $b++) {
            if ($tracker >= $tripBuilder[$b][1]) {
                array_push($tripPath, $tripBuilder[$b][0]);
                $tracker = $tracker - $tripBuilder[$b][1];
                $total_waste_per_trip += $tripBuilder[$b][1];
            } else {
                array_push($tripArray, array($tripPath, $truck, $total_waste_per_trip, $tbl_route_ID));
                unset($tripPath); // RESET THE ARRAY FOR NEXT TRIP
                $tripPath = array();
                $tracker = $truckCapacity; // RESET THE TRUCK CAPACITY COUNTER FOR NEW TRIP
                array_push($tripPath, $tripBuilder[$b][0]);
                $tracker = $tracker - $tripBuilder[$b][1];
                $total_waste_per_trip = 0;
                $total_waste_per_trip += $tripBuilder[$b][1];
            }
        }
        array_push($tripArray, array($tripPath, $truck, $total_waste_per_trip, $tbl_route_ID));

    }

    function travellingSalesmen() {
        int[,] ary = new int[10, 10];
		int[] completed = new int[10];
		int n, cost = 0;
		
		void takeInput() {
			int i, j;
			Console.Write("Enter the number of villages: ");
			n = Convert.ToInt32(Console.ReadLine());
			Console.WriteLine("Enter the cost Matrix");
			
			for (i = 0; i < n; i++) {
				Console.WriteLine("Enter the Elements of Row: " + (i+1));
				for (j = 0; j < n; j++) {
					ary[i,j] = Convert.ToInt32(Console.ReadLine());
				}
				completed[i] = 0;
			}
			
			Console.WriteLine();
			Console.WriteLine("The Cost List is: ");
			for (i = 0; i < n; i++) {
				Console.WriteLine();
				for (j = 0; j < n; j++) {
					Console.Write(ary[i,j] + " ");
				}
			}
			Console.ReadKey();
		}
		
		int least(int c) {
			int i,  nc = 999;
			int min = 999, kmin = 0;
			
			for (i = 0; i < n; i++) {
				if ((ary[c,i] != 0) && (completed[i] == 0)) {
					if (ary[c,i] + ary[i,c] < min) {
						min = ary[i,0] + ary[c,i];
						kmin = ary[c,i];
						nc = i;
					}
				}
			}
			if (min != 999) {
				cost += kmin;
			}
			
			return nc;
		}
		
		void mincost(int city) {
			int i, ncity;
			completed[city] = 1;
			Console.Write((city + 1) + "--->");
			ncity = least(city);
			
			if (ncity == 999) {
				ncity = 0;
				Console.Write((ncity+1));
				cost += ary[city,ncity];
				return;
			}
			mincost(ncity);
		}
		
		public static int Main(string[] args) {
			Program inside = new Program();
			inside.takeInput();
			Console.WriteLine();
			Console.Write("The path is: ");
			inside.mincost(0);
			Console.WriteLine();
			Console.WriteLine("Minimum cost is: " + inside.cost);
			Console.ReadKey();
			return 0;
		}
    }

?>