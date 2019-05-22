<!DOCTYPE html>
<html>
    <head>
        <title>Collectors | Binswiper</title>
        <?php include("../../config/db_connect.php"); ?>
        <link rel="stylesheet" href="../index_files/css_files/style.css" />
        <style>
            #collectors_selected{
                background-color:#DCDCDC;
                border-left:4px solid #009DC4;
            }

            #collectorForm {
                padding:10px 30px;
                display:none;
            }

            .textBox{
                box-sizing:border-box;
                border:1px solid #A3A3A3;
                padding:8px 8px;
                width:300px;
                border-radius:3px;
                outline:none;
            }

            .btn{
                border:1px solid #A3A3A3;
                background-color:white;
                color:black;
                border-radius:3px;
                padding:8px 12px;
                cursor:pointer;
                width:100px;
            }

            .btn:hover{
                box-shadow:0 0 2px black;
            }
        </style>
        <script>
            function list(cType) {
                var listing = new XMLHttpRequest();
                listing.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        var data = JSON.parse(this.responseText);
                        document.getElementById("content_list").innerHTML = data;
                        document.getElementById("collector_type").value = cType;
                    }
                }
                listing.open("POST", "listing.php", true);
                listing.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                listing.send("cat=" + cType);
            }

            function show() {
                document.getElementById("collectorForm").style.display = "block";
                document.getElementById("list").style.display = "none";
            }

            function hide() {
                document.getElementById("collectorForm").style.display = "none";
                document.getElementById("list").style.display = "block";
            }

            function register(username, address, telephone, region, category) {
                event.preventDefault();
                
                var reg = new XMLHttpRequest();
                reg.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        list(category);
                        hide();
                    }
                }
                reg.open("POST", "registerCollector.php", true);
                reg.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                reg.send("username=" + username + "&address=" + address + "&telephone=" + telephone + "&region=" + region + "&category=" + category);
                
            }

        </script>
    </head>
    <body onload="list(collector_type.value)">
        <?php include("admin-left_side_nav_bar.php"); ?>
        <?php include("admin-top-nav-bar.html"); ?>

        <div style="padding:10px 30px;" id="list">
            <h2 style="box-shadow:0 2px 1px black;padding:20px">Waste Collectors</h2>
            <div>
                <input type="text" placeholder="Search" style="outline:none;padding:8px;width:400px;margin-right:40px" />
                <select id="collector_type" style="outline:none;padding:8px;width:200px;cursor:pointer" onchange="list(this.value)">
                    <option value="District Council">District Council</option>
                    <option value="Municipality">Municipality</option>
                    <option value="Recycler">Recyclers</option>
                </select>
                <input type="button" value="+ Add Collector" onclick="show()" style="float:right;background-color:white;border:1px solid black;border-radius:2px;padding:10px 20px;cursor:pointer;box-shadow:0 0 1px black;" />
            </div>
            <br/>
            Collectors List:
            <div id="content_list"></div>
        </div>

        <div id="collectorForm">
            <h2 style="box-shadow:0 2px 1px black;padding:20px">Waste Collectors</h2>
            <form method="post" onsubmit="register(username.value, address.value, telephone.value, region.value, category.value)">
                <input type="text" placeholder="Name" name="username" class="textBox" /><br/><br/>
                <input type="text" placeholder="Address" name="address" class="textBox" /><br/><br/>
                <input type="text" placeholder="Telephone" name="telephone" class="textBox" /><br/><br/>
                <select name="category" class="textBox" style="cursor:pointer">
                    <option value="District Council">District Council</option>
                    <option value="Municipality">Municipality</option>
                    <option value="Recycler">Recycler</option>
                </select><br/><br/>
                <input type="text" placeholder="Region Covered" name="region" class="textBox" /><br/><br/>
                <input type="submit" value="Register" class="btn" />
                <input type="button" value="Cancel" class="btn" onclick="hide()" />
            </form>
        </div>
    </body>
</html>