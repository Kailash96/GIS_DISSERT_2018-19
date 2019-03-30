<!DOCTYPE html>
<html>
    <head>
        <title>Register Employee | Binswiper</title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <link rel="stylesheet" href="../index_files/css_files/style.css" />
        <style>
            #register-employee_selected{
                background-color:#DCDCDC;
                border-left:4px solid #009DC4;
            }
            #edit-data-box-blur, #edit-data-box{
                display:none;
            }
            #edit-data-success-box, #confirm-removal-box{
                display:none;
            }
        </style>
        <script>
            function register(empNum, empFName, empLName){
                event.preventDefault();
                var reg = new XMLHttpRequest();
                reg.onreadystatechange = function(){
                    if(this.readyState == 4 && this.status == 200) {
                        var table = JSON.parse(this.responseText);
                        document.getElementById('listofemp').innerHTML = table;
                        $('[name=employeeNumber]').val('');
                        $('[name=employeeFName]').val('');
                        $('[name=employeeLName]').val('');
                    }
                }
                reg.open("POST", "registration_process.php", true);
                reg.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                reg.send("employeeNumber=" + empNum + "&employeeFName=" + empFName + "&employeeLName=" + empLName);
            }

            function edit_data(empid, empFName, empLName){
                
                $("#edit-data-box").fadeIn();
                $("#edit-data-box-blur").fadeIn();
                
                // add data to text-box for edit
                document.getElementById('prevEmpNum').value = empid;
                document.getElementById('empnumedit').value = empid;
                document.getElementById('empfnameedit').value = empFName;
                document.getElementById('emplnameedit').value = empLName;

            }

            function update_data(saveid, savefname, savelname, prevEmpNum){
                var update = new XMLHttpRequest();
                update.onreadystatechange = function(){
                    if (this.readyState == 4 && this.status == 200) {
                        var result = this.responseText;
                        if (result == "success") {
                            document.getElementById("edit-data-box").style.display = "none";
                            document.getElementById("edit-data-success-box").style.display = "block";
                            register(1, 1, 1);
                            setTimeout(function(){
                                $('#edit-data-success-box').fadeOut();
                                $('#edit-data-box-blur').fadeOut();
                            }, 1000);
                        } else {
                            console.log(result);
                        }
                    }
                }
                update.open("POST", "emp-data-update-process.php", true);
                update.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                update.send("empNum=" + saveid + "&empFName=" + savefname + "&empLName=" + savelname + "&prevEmpNum=" + prevEmpNum);
            }

            function cancel(id){
                $("#" + id).fadeOut();
                $("#edit-data-box-blur").fadeOut();
            }

            function confirm_remove_emp(empID){
                $("#confirm-removal-box").fadeIn();
                $("#edit-data-box-blur").fadeIn();
                document.getElementById('emp_ID').value = empID;
            }

            function remove_emp(empID){
                var remover = new XMLHttpRequest();
                remover.onreadystatechange = function(){
                    if(this.readyState == 4 && this.status == 200){
                        var response = this.responseText;
                        if (response == "success"){
                            $("#confirm-removal-box").fadeOut();
                            $("#edit-data-box-blur").fadeOut();
                            register(1, 1, 1);
                        } else {
                            console.log("fail");
                        }
                    }
                }
                remover.open("POST", "remove-employee.php", true);
                remover.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                remover.send("empid=" + empID);
            }
        </script>
    </head>
    <body style="color:#002246" onload="register(1, 1, 1)">
        <?php include("admin-left_side_nav_bar.php"); ?>
        <?php include("admin-top-nav-bar.html"); ?>
        
        <!-- content container -->
        <div style="padding:10px 20px;">
            <h3>Employee Registration</h3>
            <div>
                <form method="POST" onsubmit="register(employeeNumber.value, employeeFName.value, employeeLName.value)">
                    <input type="text" class="input-box" placeholder="Employee Number" name="employeeNumber" required /><br/>
                    <input type="text" class="input-box" placeholder="Employee First Name" name="employeeFName" required /><br/>
                    <input type="text" class="input-box" placeholder="Employee Last Name" name="employeeLName" required /><br/><br/>
                    <input type="submit" value="Register" class="button" />
                </form>
                <div>
                    <h3>List of Employees Registered</h3>
                    <div id='listofemp' style='font-size:14px'></div>
                </div>
            </div>
        </div>
        
        <!-- EMPLOYEE DETAILS EDIT BOX -->
        <div id="edit-data-box-blur" style="width:100%;height:100%;background-color:#002246;opacity:0.5;position:fixed;left:0;top:0;z-index:4"></div>
        <div id="edit-data-box" style="padding:20px;border-radius:4px;box-shadow:0 0 10px #002246;background-color:white;z-index:5;width:25%;color:#002246;position:fixed;top:25%;left:37.5%">
            <h3>Edit Employee Details</h3>
            <div style="font-size:12px;">Employee Number</div>
            <input type="text" style="width:100%" class="input-box" placeholder="Employee Number" id="empnumedit" /><br/><br/>
            <div style="font-size:12px;">First Name</div>
            <input type="text" style="width:100%" class="input-box" placeholder="First Name" id="empfnameedit" /><br/><br/>
            <div style="font-size:12px;">Last Name</div>
            <input type="text" style="width:100%" class="input-box" placeholder="Last Name" id="emplnameedit" />
            <input type="hidden" value="" id="prevEmpNum" /><br/><br/>
            <input type="button" value="Save Changes" onclick="update_data(empnumedit.value, empfnameedit.value, emplnameedit.value, prevEmpNum.value)" style="width:40%" class="button" />
            <input type="button" value="Cancel" style="width:40%" onclick="cancel('edit-data-box')" id="edit_box" class="button" />
        </div>

        <!-- EDIT SUCCESS BOX -->
        <div id="edit-data-success-box" style="text-align:center;padding:20px;border-radius:4px;box-shadow:0 0 10px #002246;background-color:white;z-index:5;width:25%;color:#002246;position:fixed;top:25%;left:37.5%">
            <h3>Changes Saved</h3>
            <input type="button" value="Okay" class='button' onclick="document.getElementById('edit-data-success-box').style.display='none';document.getElementById('edit-data-box-blur').style.display='none'" />
        </div>

        <!-- CONFIRM REMOVAL BOX -->
        <div id="confirm-removal-box" style="padding:20px;border-radius:4px;box-shadow:0 0 10px #002246;background-color:white;z-index:5;width:25%;color:#002246;position:fixed;top:25%;left:37.5%">
            <h3>Are you sure you want to remove the following employee's account?</h3>
            <input type="hidden" value="" id="emp_ID" />
            <input type="button" class="button" value="Confirm" onclick="remove_emp(emp_ID.value)" />
            <input type="button" class="button" value="Cancel" onclick="cancel('confirm-removal-box')" />
        </div>
    </body>
</html>