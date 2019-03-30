<!DOCTYPE html>
<html>
    <head>
        <title>Admin | Binswiper</title>
        <?php include("../../config/db_connect.php"); ?>
        <link rel="stylesheet" href="../index_files/css_files/style.css" />
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
    <body onload="getData(), amountPerRegion(), setComparisons();">
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
            <br/><br/>
            
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

                function comparisons(data) {
                    var ctx_line = document.getElementById('linechart').getContext('2d');
                    var myLineChart = new Chart(ctx_line, {
                        type: 'line',
                        data: {
                            labels: ["Jan","Feb","Mar","Apr","May","June","July","Aug","Sept","Oct", "Nov", "Dec"],
                            datasets: [{ 
                                data: [
                                    parseInt((data[1][0] / data[1][4]) * 100),
                                    parseInt((data[2][0] / data[2][4]) * 100),
                                    parseInt((data[3][0] / data[3][4]) * 100),
                                    parseInt((data[4][0] / data[4][4]) * 100),
                                    parseInt((data[5][0] / data[5][4]) * 100),
                                    parseInt((data[6][0] / data[6][4]) * 100),
                                    parseInt((data[7][0] / data[7][4]) * 100),
                                    parseInt((data[8][0] / data[8][4]) * 100),
                                    parseInt((data[9][0] / data[9][4]) * 100),
                                    parseInt((data[10][0] / data[10][4]) * 100),
                                    parseInt((data[11][0] / data[11][4]) * 100),
                                    parseInt((data[12][0] / data[12][4]) * 100),
                                ],
                                label: "Organic",
                                borderColor: "grey",
                                fill: false
                            }, { 
                                data: [
                                    parseInt((data[1][1] / data[1][4]) * 100),
                                    parseInt((data[2][1] / data[2][4]) * 100),
                                    parseInt((data[3][1] / data[3][4]) * 100),
                                    parseInt((data[4][1] / data[4][4]) * 100),
                                    parseInt((data[5][1] / data[5][4]) * 100),
                                    parseInt((data[6][1] / data[6][4]) * 100),
                                    parseInt((data[7][1] / data[7][4]) * 100),
                                    parseInt((data[8][1] / data[8][4]) * 100),
                                    parseInt((data[9][1] / data[9][4]) * 100),
                                    parseInt((data[10][1] / data[10][4]) * 100),
                                    parseInt((data[11][1] / data[11][4]) * 100),
                                    parseInt((data[12][1] / data[12][4]) * 100),    
                                ],
                                label: "Plastic",
                                borderColor: "orange",
                                fill: false
                            }, { 
                                data: [
                                    parseInt((data[1][2] / data[1][4]) * 100),
                                    parseInt((data[2][2] / data[2][4]) * 100),
                                    parseInt((data[3][2] / data[3][4]) * 100),
                                    parseInt((data[4][2] / data[4][4]) * 100),
                                    parseInt((data[5][2] / data[5][4]) * 100),
                                    parseInt((data[6][2] / data[6][4]) * 100),
                                    parseInt((data[7][2] / data[7][4]) * 100),
                                    parseInt((data[8][2] / data[8][4]) * 100),
                                    parseInt((data[9][2] / data[9][4]) * 100),
                                    parseInt((data[10][2] / data[10][4]) * 100),
                                    parseInt((data[11][2] / data[11][4]) * 100),
                                    parseInt((data[12][2] / data[12][4]) * 100),    
                                ],
                                label: "Paper",
                                borderColor: "blue",
                                fill: false
                            }, { 
                                data: [
                                    parseInt((data[1][3] / data[1][4]) * 100),
                                    parseInt((data[2][3] / data[2][4]) * 100),
                                    parseInt((data[3][3] / data[3][4]) * 100),
                                    parseInt((data[4][3] / data[4][4]) * 100),
                                    parseInt((data[5][3] / data[5][4]) * 100),
                                    parseInt((data[6][3] / data[6][4]) * 100),
                                    parseInt((data[7][3] / data[7][4]) * 100),
                                    parseInt((data[8][3] / data[8][4]) * 100),
                                    parseInt((data[9][3] / data[9][4]) * 100),
                                    parseInt((data[10][3] / data[10][4]) * 100),
                                    parseInt((data[11][3] / data[11][4]) * 100),
                                    parseInt((data[12][3] / data[12][4]) * 100),
                                ],
                                label: "Other",
                                borderColor: "red",
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
                                        scaleOverride:true,
                                        stepSize: 20,
                                        max: 100
                                    }
                                }]
                            }
                        }
                    });
                }

                function setComparisons() {
                    var getdata = new XMLHttpRequest();
                    getdata.onreadystatechange = function() {
                        if (this.readyState == 4 && this.status == 200) {
                            var data = JSON.parse(this.responseText);
                            comparisons(data);
                        }
                    }
                    getdata.open("POST", "chart.php", true);
                    getdata.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                    getdata.send("name=comparisons");
                }
                
            </script>
        </div>
    </body>
</html>