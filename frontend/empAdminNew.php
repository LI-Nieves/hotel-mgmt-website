<!DOCTYPE html>
<html>
<head>
<title>Admin: Create an Employee Record</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
	<div class="wrapper fadeInDown">
		<div id="formContent2">

        <form action = "<?php $_PHP_SELF ?>" method = "POST">
            <input type = "text" name = "eSSN" placeholder = "Employee's SSN"/><br>
            <input type = "text" name = "eFname" placeholder = "Employee's first name"/><br>
            <input type = "text" name = "eLname" placeholder = "Employee's last name"/><br>
            <input type = "text" name = "eAddress" placeholder = "Employee's address"/><br>
            <input type = "text" name = "eSal" placeholder = "Employee's salary"/><br>
            <input type = "text" name = "eSex" placeholder = "Employee's sex"/><br>
            <input type = "text" name = "eDOB" placeholder = "Employee's birthdate"/><br>
            <input type = "text" name = "eLogin" placeholder = "Employee's login"/><br>
            <input type = "text" name = "eFlag" placeholder = "Employee type (Receptionist, Maintenance, Other)"/><br>
            FILL THIS SECTION OUT ONLY IF THEY'RE A RECEPTIONIST:<br>
            <input type = "text" name = "rPhone" placeholder = "Employee's business phone"/><br>
            <input type = "text" name = "rEmail" placeholder = "Employee's business email"/><br>
            <input type = "text" name = "rLogin" placeholder = "Employee's Receptionist Account login"/><br>
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

                // for debugging?
/*                 echo 
                    "You'd like to change data for Floor ".$_POST["resFloor"].
                    "<br>You entered:<br>Floor number: ".$_POST["resRoom"].
                    "<br>Number of utilities: ".$_POST["aDate"].
                    "<br>Floor amenities: ".$_POST["dDate"].
                    "<br>Maintenance employee's SSN: ".$_POST["numPeople"].
                    "<br>"; */

                $conn = connect();

                if ($eFlag == "Receptionist") {
                    $result = empAdmin($conn,$eSSN,$eFname,$eLname,$eAddress,$eSal,$eSex,$eDOB,$eLogin,$eFlag,$rPhone,$rEmail,$rLogin,$mRole,$mHr,0);
                }
                else if ($eFlag == "Maintenance") {
                    $result = empAdmin($conn,$eSSN,$eFname,$eLname,$eAddress,$eSal,$eSex,$eDOB,$eLogin,$eFlag,$rPhone,$rEmail,$rLogin,$mRole,$mHr,1);
                }
                else if ($eFlag == "Other") {
                    $result = empAdmin($conn,$eSSN,$eFname,$eLname,$eAddress,$eSal,$eSex,$eDOB,$eLogin,$eFlag,$rPhone,$rEmail,$rLogin,$mRole,$mHr,2);
                }
                else {
                    echo "Employee type is invalid.<br>";
                    $result = false;
                }

/*                 if ($result) {
                    echo "Successfully created new employee.<br>";

                    header("Content-Type: JSON");
                    $rowNumber = 0;
                    $output = array();
    
                    while ($row = mysqli_fetch_array($result)) {
                        $output[$rowNumber]['EmpPass'] = $row['EmpPass'];
                        $rowNumber++;
                    }
                    echo json_encode($output, JSON_PRETTY_PRINT);
                } */

                //else {
                if (!$result) {
                    echo "Failed to create a new employee. Please ensure that the username is unique.<br>";
                }

            ?>
        </p>
		</div>
	  </div>

</body>

</html> 