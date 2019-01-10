<!DOCTYPE html>
<html>
    <head>
        <title>Register Employee | Binswiper</title>
        <link rel="stylesheet" href="../../css_files/style.css" />
        <style>
            #register-employee_selected{
                background-color:#002246;
                color:white;
            }
            .button{
                border:1px solid #002246;
                background-color:white;
                padding:10px 20px;
                border-radius:3px;
                cursor:pointer;
                color:#002246;
            }
            .button:hover{
                box-shadow:0 0 3px #002246;
            }
            #edit-data-box-blur, #edit-data-box{
                display:none;
            }
        </style>
        <script>
            function register(empNum, empName){
                event.preventDefault();
                var reg = new XMLHttpRequest();
                reg.onreadystatechange = function(){
                    if(this.readyState == 4 && this.status == 200) {
                        var table = JSON.parse(this.responseText);
                        document.getElementById('listofemp').innerHTML = table;
                    }
                }
                reg.open("POST", "registration_process.php", true);
                reg.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                reg.send("employeeNumber=" + empNum + "&employeeName=" + empName);
            }

            function edit_data(empid, empname){
                document.getElementById("edit-data-box").style.display = "block";
                document.getElementById("edit-data-box-blur").style.display = "block";

                // add data to text-box for edit
                document.getElementById('prevEmpNum').value = empid;
                document.getElementById('empnumedit').value = empid;
                document.getElementById('empnameedit').value = empname;
            }

            function update_data(saveid, savename, prevEmpNum){
                var update = new XMLHttpRequest();
                update.onreadystatechange = function(){
                    if (this.readyState == 4 && this.status == 200) {
                        var result = this.responseText;
                        if (result == "success") {
                            document.getElementById("edit-data-box").style.display = "none";
                        } else {

                        }
                    }
                }
                update.open("POST", "emp-data-update-process.php", true);
                update.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                update.send("empNum=" + saveid + "&empName=" + savename + "&prevEmpNum=" + prevEmpNum);
            }

            function cancel(id){
                document.getElementById(id).style.display = "none";
                document.getElementById(id + "-blur").style.display = "none";
            }
        </script>
    </head>
    <body style="color:#002246" onload="register(1, 1)">
        <?php include("admin-left_side_nav_bar.php"); ?>
        <?php include("admin-top-nav-bar.html"); ?>
        
        <!-- content container -->
        <div style="padding:0 20px;">
            <h3>Employee Registration</h3>
            <div>
                <form method="POST" onsubmit="register(employeeNumber.value, employeeName.value)">
                    <input type="text" class="input-box" placeholder="Employee Number" name="employeeNumber" required /><br/>
                    <input type="text" class="input-box" placeholder="Employee Name" name="employeeName" required /><br/><br/>
                    <input type="submit" value="Register" class="button" />
                </form>
                <div>
                    <h3>List of Employees Registered</h3>
                    <div id='listofemp'></div>
                </div>
            </div>
        </div>
        
        <!-- EMPLOYEE DETAILS EDIT BOX -->
        <div id="edit-data-box-blur" style="width:100%;height:100%;background-color:#002246;opacity:0.5;position:fixed;left:0;top:0;z-index:4"></div>
        <div id="edit-data-box" style="padding:20px;border-radius:4px;box-shadow:0 0 10px #002246;background-color:white;z-index:5;width:25%;color:#002246;position:fixed;top:25%;left:37.5%">
            <h3>Edit Employee Details</h3>
            <div style="font-size:12px;">Employee Number</div>
            <input type="text" style="width:100%" class="input-box" placeholder="Employee Number" id="empnumedit" /><br/><br/>
            <div style="font-size:12px;">Employee Name</div>
            <input type="text" style="width:100%" class="input-box" placeholder="Employee Name" id="empnameedit" />
            <input type="hidden" value="" id="prevEmpNum" /><br/><br/>
            <input type="button" value="Save Changes" onclick="update_data(empnumedit.value, empnameedit.value, prevEmpNum.value)" style="width:40%" class="button" />
            <input type="button" value="Cancel" style="width:40%" onclick="cancel('edit-data-box')" id="edit_box" class="button" />
        </div>
    </body>
</html>