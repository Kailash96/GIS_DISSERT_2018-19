<!DOCTYPE html>
<html>

    <head>
        <title>Bin Control | Binswiper</title>
        <link rel="stylesheet" href="../index_files/css_files/style.css" />
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <style>
            #user_mngt_selected {
                background-color:#DCDCDC;
                border-left:4px solid #009DC4;
            }

            .table th{
                text-align:left;
                background-color:#E5E5E5;
                padding:4px 8px;
                border-radius:4px 4px 0 0;
            }

            .table td{
                padding:8px;
            }

            .view_button{
                background-color:white;
                border:1px solid transparent;
                box-shadow:0 0 1px black;
                padding:4px;
                border-radius:1px;
                cursor:pointer;
            }

            .view_button:hover{
                background-color:#E5E5E5;
            }
        </style>
        <script>
            function user_list(user_category){
                var getList = new XMLHttpRequest();
                getList.onreadystatechange = function(){
                    if (this.readyState == 4 && this.status == 200) {
                        var data = JSON.parse(this.responseText);
                        document.getElementById("content_list").innerHTML = data;
                    }
                }
                getList.open("POST", "getUsers.php", true);
                getList.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                getList.send("category=" + user_category);
            }

            function viewAccount(genID){
                var profile = new XMLHttpRequest();
                profile.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        var response = JSON.parse(this.responseText);
                        document.getElementById('content_list').innerHTML = response;
                    }
                }
                profile.open("POST", "profile.php", true);
                profile.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                profile.send("genID=" + genID);
            }

            function search(data){
                var cat = document.getElementById("category").value;
                var search = new XMLHttpRequest();
                search.onreadystatechange = function () {
                    if (this.readyState == 4 && this.status == 200) {
                        var response = JSON.parse(this.responseText);
                        document.getElementById("content_list").innerHTML = response;
                    }
                }
                search.open("POST", "search.php", true);
                search.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                search.send("cat=" + cat + "&data=" + data);
            }

            function resetBin(type, userid) {
                if (confirm("Confirm Reset Bin for " + type)) {
                    var reset = new XMLHttpRequest();
                    reset.onreadystatechange = function() {
                        if (this.readyState == 4 && this.status == 200) {
                            var response = JSON.parse(this.responseText);
                            console.log(response);
                            alert("Bin has been reset successfully!");
                            window.location.reload();
                        }
                    }
                    reset.open("POST", "resetbin.php", true);
                    reset.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                    reset.send("userid=" + userid + "&type=" + type);
                }
            }

            function deleteAccount(genID) {
                if (confirm("Confirm Account Deletion?")) {
                    var deleteAcc = new XMLHttpRequest();
                    deleteAcc.onreadystatechange = function() {
                        if (this.readyState == 4 && this.status == 200) {
                            var response = JSON.parse(this.responseText);
                            console.log(response);
                            alert("Account Deleted!");
                            document.location.reload();
                        }
                    }
                    deleteAcc.open("POST", "deleteAccount.php", true);
                    deleteAcc.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                    deleteAcc.send("genID=" + genID);
                }
            }

        </script>
    </head>
    <body onload="user_list('Resident')">
        <?php include("admin-left_side_nav_bar.php"); ?>
        <?php include("admin-top-nav-bar.html"); ?>
        
        <div style="padding:20px;font-size:14px;">

            Filter:
            <select id="category" onchange="user_list(this.value)" style="border:1px solid #BFBFBF;border-radius:2px;padding:4px;width:200px;outline:none;">
                <option value="Resident">Resident</option>
                <option value="Commercial">Commercial</option>
                <option value="Industrial">Industrial</option>
            </select>

            <button class="view_button" style="float:right;margin:0 10px;"><i class="fa fa-plus-square"></i> Add New User</button>
            <input type="text" placeholder="Search" style="outline:none;padding:3.3px 4px;width:300px;float:right;" onkeyup="search(this.value)" />
            
            <br/><br/>
            
            <div id="content_list"></div>

        </div>
        
    </body>
</html>