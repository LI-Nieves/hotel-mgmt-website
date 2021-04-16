<!DOCTYPE html>
<html>
<head>
<title>Admin: Modify Employee Record</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
	<div class="wrapper fadeInDown">
		<div id="formContent2">

        <form action = "<?php $_PHP_SELF ?>" method = "POST">
            <input type = "text" name = "eSSN" placeholder = "SSN of Employee to modify?"/><br>
            WRITE NEW DETAILS BELOW:<br>
            <input type = "text" name = "eFname" placeholder = "Employee's first name"/><br>
            <input type = "text" name = "eLname" placeholder = "Employee's last name"/><br>
            <input type = "text" name = "eAddress" placeholder = "Employee's address"/><br>
            <input type = "text" name = "eSal" placeholder = "Employee's salary"/><br>
            <input type = "text" name = "eSex" placeholder = "Employee's sex"/><br>
            <input type = "text" name = "eDOB" placeholder = "Employee's birthdate"/><br>
            <input type = "text" name = "eLogin" placeholder = "Employee's login"/><br>
            <input type = "text" name = "eFlag" placeholder = "Employee type (Receptionist, Maintenance, Other)"/><br>
            FILL THIS SECTION OUT ONLY IF THEY'RE AN ADMIN OR A RECEPTIONIST:<br>
            <input type = "text" name = "rPhone" placeholder = "Employee's business phone"/><br>
            <input type = "text" name = "rEmail" placeholder = "Employee's business email"/><br>
            <input type = "text" name = "rLogin" placeholder = "Employee's Admin/Receptionist Account login"/><br>
            FILL THIS SECTION OUT ONLY IF THEY'RE MAINTENANCE:<br>
            <input type = "text" name = "mRole" placeholder = "Employee's role"/><br>
            <input type = "text" name = "mHr" placeholder = "Employee's work hours per week"/><br>
            <input type = "submit" />
        </form>
		
        <p> <?php 
                include 'C:\xampp\htdocs\Project\backend\database.php';
                include 'C:\xampp\htdocs\Project\logic\employeeQueries.php';

                $eSSN  = $_POST["eSSN"];
                $eFname   = $_POST["eFname"];
                $eLname  = $_POST["eLname"];
                $eAddress  = $_POST["eAddress"];
                $eSal   = $_POST["eSal"];
                $eSex  = $_POST["eSex"];
                $eDOB  = $_POST["eDOB"];
                $eLogin   = $_POST["eLogin"];
                $eFlag  = $_POST["eFlag"];
                $rPhone   = $_POST["rPhone"];
                $rEmail  = $_POST["rEmail"];
                $rLogin   = $_POST["rLogin"];
                $mRole  = $_POST["mRole"];
                $mHr  = $_POST["mHr"];

                $conn = connect();

                // checking if the specified SSN exists in the table
                $check = "SELECT * FROM Employee WHERE SSN = \"$eSSN\"";
                if (countEntries($conn,$check) == 0) {
                    echo "The SSN you desire to update data for does not exist in the table.<br>";
                    return false;
                }
                

                if ($eFlag == "Receptionist") {
                    $result = empAdmin($conn,$eSSN,$eFname,$eLname,$eAddress,$eSal,$eSex,$eDOB,$eLogin,$eFlag,$rPhone,$rEmail,$rLogin,$mRole,$mHr,4);
                }
                else if ($eFlag == "Maintenance") {
                    $result = empAdmin($conn,$eSSN,$eFname,$eLname,$eAddress,$eSal,$eSex,$eDOB,$eLogin,$eFlag,$rPhone,$rEmail,$rLogin,$mRole,$mHr,5);
                }
                else if ($eFlag == "Other") {
                    $result = empAdmin($conn,$eSSN,$eFname,$eLname,$eAddress,$eSal,$eSex,$eDOB,$eLogin,$eFlag,$rPhone,$rEmail,$rLogin,$mRole,$mHr,6);
                }
                else if ($eFlag == "Admin") {
                    $result = empAdmin($conn,$eSSN,$eFname,$eLname,$eAddress,$eSal,$eSex,$eDOB,$eLogin,$eFlag,$rPhone,$rEmail,$rLogin,$mRole,$mHr,7);
                }
                else {
                    echo "Employee type is invalid.<br>";
                    $result = false;
                }

                if ($result) {
                    echo "Successfully updated employee information.<br>";
                }
                else {
                    echo "Failed to updated employee information.<br>";
                }

            ?>
        </p>
		</div>
	  </div>

</body>

</html> 