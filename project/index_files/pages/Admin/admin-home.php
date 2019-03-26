<!DOCTYPE html>
<html>
    <head>
        <title>Admin | Binswiper</title>
        <?php include("../../../db_connect.php"); ?>
        <link rel="stylesheet" href="../../css_files/style.css" />
        <style>
            #home_selected{
                background-color:#DCDCDC;
                border-left:4px solid #009DC4;
            }

            .topbox {
                display:inline-block;
                padding:8px 12px;
                border-radius:2px;
                background-color:white;
                box-shadow:0 0 3px #0796D5;
                width:100px;
            }

            .topbox h5 {
                color:#A4B6BE;
                padding:0;
                margin:0;
            }

            .topbox h2, .topbox h4 {
                color:#0796D5;
                padding:0;
                margin:0;
            }

        </style>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.min.js"></script>
    </head>
    <body onload="getData(), amountPerRegion();">
        <?php include("admin-left_side_nav_bar.php"); ?>
        <?php include("admin-top-nav-bar.html"); ?>
        
        <?php
            // GET NUMBER OF USERS
            $query = "SELECT * FROM tbl_generator WHERE Active = 1";
            $total = mysqli_num_rows(mysqli_query($conn, $query));
            $getOnline = "SELECT * FROM tbl_generators_login WHERE Status = 1";
            $total_online = mysqli_num_rows(mysqli_query($conn, $getOnline));
            $percentage_online = ($total_online / $total) * 100;
        ?>
        <div class="body_container">
            <div style="display:inline-block;box-sizing:border-box;width:49%;box-shadow:0 0 2px #0796D5;padding:8px 0;">
                <h5 style="text-align:center;margin:0">Total Amount of Waste Generated Last Month in KG</h5>
                <canvas id="myChart"></canvas>
            </div>

            <div style="display:inline-block;float:right;width:49%;box-shadow:0 0 2px #0796D5;padding:8px 0;">
                <h5 style="text-align:center;margin:0">Waste Amount Generated Comparisons</h5>
                <canvas id="linechart"></canvas>
            </div>

            <div class="topbox">
                <h4>Users</h4>
                <h2><?php echo $total; ?></h2>
                <h5><?php echo round($percentage_online); ?> % Active</h5>
            </div>
            <br/><br/>
            <div style="width:100%;box-shadow:0 0 2px #0796D5;padding:8px 8px;box-sizing:border-box;">
                <h5 style="text-align:center;margin:0">Total Amount of Waste Generated from each Region Last Month</h5>
                <canvas id="barchart"></canvas>
            </div>

            <script>
                // PIE CHART
                var ctx = document.getElementById('myChart').getContext('2d');
                function setPie(organic, plastic, paper, other) {
                    var myPieChart = new Chart(ctx, {
                        type: 'pie',
                        data: {
                            datasets: [{
                                data: [organic, plastic, paper, other],
                                backgroundColor: ['rgba(168, 168, 168, 0.6)', 'rgba(255, 224, 0, 0.6)', 'rgba(0, 166, 255, 0.6)', 'rgba(255, 0, 0, 0.6)']
                            }],

                            labels: [
                                'Organic',
                                'Plastic',
                                'Paper',
                                'Other'
                            ]
                        },
                        options: {
                            cutoutPercentage: 0
                        }
                    });
                }

                // GET DATA FOR LAST WEEK
                function getData() {
                    var fetch = new XMLHttpRequest();
                    fetch.onreadystatechange = function() {
                        if (this.readyState == 4 && this.status == 200) {
                            var data = JSON.parse(this.responseText);
                            setPie(data[0], data[1], data[2], data[3]);
                        }
                    }
                    fetch.open("POST", "chart.php", true);
                    fetch.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                    fetch.send("name=previousCollection");
                }

                // BAR CHART
                var ctx_bar = document.getElementById('barchart').getContext('2d');
                function setBarChart(data) {
                    var myBarChart = new Chart(ctx_bar, {
                        type: 'horizontalBar',
                        data: {
                            labels: ['Flacq', 'Grand Port', 'Moka', 'Pamplemousses', 'Plaines Wilhiems', 'Port Louis', 'Riviere Du Rempart', 'Riviere Noire', 'Savanne'],
                            datasets: [{
                                label: 'Organic(%)',
                                backgroundColor: "rgba(168, 168, 168, 0.8)",
                                data: [
                                    parseInt(data["Flacq"][0][0] / data["bin_Flacq"]),
                                    parseInt(data["Grand Port"][0][0] / data["Grand Port"]),
                                    parseInt(data["Moka"][0][0] / data["Moka"]),
                                    parseInt(data["Pamplemousses"][0][0] / data["Pamplemousses"]),
                                    parseInt(data["Plaines Wilhiems"][0][0] / data["Plaines Wilhiems"]),
                                    parseInt(data["Port Louis"][0][0] / data["Port Louis"]),
                                    parseInt(data["Riviere Du Rempart"][0][0] / data["Riviere Du Rempart"]),
                                    parseInt(data["Riviere Noire"][0][0] / data["Riviere Noire"]),
                                    parseInt(data["Savanne"][0][0] / data["Savanne"])
                                ]
                            },
                            {
                                label: 'Plastic(%)',
                                backgroundColor: "rgba(255, 224, 0, 0.8)",
                                data: [
                                    parseInt(data["Flacq"][0][1] / data["bin_Flacq"]),
                                    parseInt(data["Grand Port"][0][1] / data["Grand Port"]),
                                    parseInt(data["Moka"][0][1] / data["Moka"]),
                                    parseInt(data["Pamplemousses"][0][1] / data["Pamplemousses"]),
                                    parseInt(data["Plaines Wilhiems"][0][1] / data["Plaines Wilhiems"]),
                                    parseInt(data["Port Louis"][0][1] / data["Port Louis"]),
                                    parseInt(data["Riviere Du Rempart"][0][1] / data["Riviere Du Rempart"]),
                                    parseInt(data["Riviere Noire"][0][1] / data["Riviere Noire"]),
                                    parseInt(data["Savanne"][0][1] / data["Savanne"])
                                ]
                            },
                            {
                                label: 'Paper(%)',
                                backgroundColor: "rgba(0, 139, 229, 0.8)",
                                data: [
                                    parseInt(data["Flacq"][0][2] / data["bin_Flacq"]),
                                    parseInt(data["Grand Port"][0][2] / data["Grand Port"]),
                                    parseInt(data["Moka"][0][2] / data["Moka"]),
                                    parseInt(data["Pamplemousses"][0][2] / data["Pamplemousses"]),
                                    parseInt(data["Plaines Wilhiems"][0][2] / data["Plaines Wilhiems"]),
                                    parseInt(data["Port Louis"][0][2] / data["Port Louis"]),
                                    parseInt(data["Riviere Du Rempart"][0][2] / data["Riviere Du Rempart"]),
                                    parseInt(data["Riviere Noire"][0][2] / data["Riviere Noire"]),
                                    parseInt(data["Savanne"][0][2] / data["Savanne"])
                                ]
                            },
                            {
                                label: 'Other(%)',
                                backgroundColor: "rgba(255, 0, 0, 0.6)",
                                data: [
                                    parseInt(data["Flacq"][0][3] / data["bin_Flacq"]),
                                    parseInt(data["Grand Port"][0][3] / data["Grand Port"]),
                                    parseInt(data["Moka"][0][3] / data["Moka"]),
                                    parseInt(data["Pamplemousses"][0][3] / data["Pamplemousses"]),
                                    parseInt(data["Plaines Wilhiems"][0][3] / data["Plaines Wilhiems"]),
                                    parseInt(data["Port Louis"][0][3] / data["Port Louis"]),
                                    parseInt(data["Riviere Du Rempart"][0][3] / data["Riviere Du Rempart"]),
                                    parseInt(data["Riviere Noire"][0][3] / data["Riviere Noire"]),
                                    parseInt(data["Savanne"][0][3] / data["Savanne"])
                                ]
                            }]
                        },
                        options: {
                            scales: {
                                xAxes: [{
                                    ticks: {
                                        beginAtZero: true,
                                        max: 100
                                    }
                                }]
                            }
                        }
                    });
                }
                
                function amountPerRegion() {
                    var getData = new XMLHttpRequest();
                    getData.onreadystatechange = function() {
                        if (this.readyState == 4 && this.status == 200) {
                            var data = JSON.parse(this.responseText);
                            setBarChart(data);
                        }
                    }
                    getData.open("POST", "chart.php", true);
                    getData.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                    getData.send("name=amountperregion");
                }

                function comparisons() {
                    var ctx_line = document.getElementById('linechart').getContext('2d');
                    var myLineChart = new Chart(ctx_line, {
                        type: 'line',
                        data: {
                            labels: ["Jan","Feb","Mar","Apr","May","June","July","Aug","Sept","Oct", "Nov", "Dec"],
                            datasets: [{ 
                                data: [86,114,106,106,107,111,133,221,783,2478],
                                label: "Organic",
                                borderColor: "#3e95cd",
                                fill: false
                            }, { 
                                data: [282,350,411,502,635,809,947,1402,3700,5267],
                                label: "Plastic",
                                borderColor: "#8e5ea2",
                                fill: false
                            }, { 
                                data: [168,170,178,190,203,276,408,547,675,734],
                                label: "Paper",
                                borderColor: "#3cba9f",
                                fill: false
                            }, { 
                                data: [40,20,10,16,24,38,74,167,508,784],
                                label: "Other",
                                borderColor: "#e8c3b9",
                                fill: false
                            }]
                        },
                        options: {
                            title: {
                                display: true
                            },
                            scales: {
                                yAxes: [{
                                    ticks: {
                                        beginAtZero: true,
                                        max: 100
                                    }
                                }]
                            }
                        }
                    });
                }

                comparisons();
                
            </script>
        </div>
    </body>
</html>