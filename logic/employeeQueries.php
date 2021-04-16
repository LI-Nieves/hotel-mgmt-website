<?php
    include_once 'C:\xampp\htdocs\Project\logic\helper.php';

    // Admin endpoint: used when an admin logs in
    function adminLogin($conn,$aUser,$aPass) {
        $sql = "SELECT * FROM Employee WHERE AdminLogin = \"$aUser\" AND AdminPass = \"$aPass\"";
        $result = mysqli_query($conn, $sql);

        // setting this guest's ID as the current session's ID
        $sql1 = "SELECT SSN FROM Employee WHERE AdminLogin = \"$aUser\" AND GuestPass = \"$aPass\"";
        $result1 = mysqli_query($conn, $sql);

        $currentID = 0;
        if ($result1) {
            while ($row = mysqli_fetch_array($result1)) {
                $currentID = $row['SSN'];
            }
        }

        setcookie("user", $currentID, 0, "/");

        return $result;
    }

    // Receptionist endpoint: used when a receptionist logs in
    function recepLogin($conn,$user,$pass) {
        $sql = "SELECT * FROM Employee WHERE RecepLogin = \"$user\" AND RecepPass = \"$pass\"";
        $result = mysqli_query($conn, $sql);

        // setting this guest's ID as the current session's ID
        $sql1 = "SELECT SSN FROM Employee WHERE RecepLogin = \"$user\" AND RecepPass = \"$pass\"";
        $result1 = mysqli_query($conn, $sql);

        $currentID = 0;
        if ($result1) {
            while ($row = mysqli_fetch_array($result1)) {
                $currentID = $row['SSN'];
            }
        }

        setcookie("user", $currentID, 0, "/");

        return $result;
    }

    // Employee endpoint: used when an employee logs in
    function employeeLogin($conn,$user,$pass) {
        $sql = "SELECT * FROM Employee WHERE EmpLogin = \"$user\" AND EmpPass = \"$pass\"";
        $result = mysqli_query($conn, $sql);

        // setting this guest's ID as the current session's ID
        $sql1 = "SELECT SSN FROM Employee WHERE EmpLogin = \"$user\" AND EmpPass = \"$pass\"";
        $result1 = mysqli_query($conn, $sql);

        $currentID = 0;
        if ($result1) {
           while ($row = mysqli_fetch_array($result1)) {
                $currentID = $row['SSN'];
            }
        }

        setcookie("user", $currentID, 0, "/");

        return $result;
    }

    // Admin endpoint; used when an admin views all employees
    function empAdminRead($conn) {
        $sql = "SELECT * FROM Employee";
        $result = mysqli_query($conn, $sql);
        return $result;
    }
    
    // Admin endpoint: used when admin creates+modifies employees
    function empAdmin($conn,$eSSN,$eFname,$eLname,$eAddress,$eSal,$eSex,$eDOB,$eLogin,$eFlag,$rPhone,$rEmail,$rLogin,$mRole,$mHr,$func) {
        try {
            // handling user input
            $output = handleInputInteger($eSSN,$eSal,$mHr);
            $output2 = handleInputDate($eDOB);
            if (!($output and $output2)) {
                throw new TypeError(); 
            }
            if (strlen($eSSN) != 9) {
                echo "Invalid SSN.<br>";
                return false;
            }

            // generate random password
            $ePass = rand(1000000000,9999999999);
            // assigning admin's SSN as the super SSN
            $superSSN = assignCookie();
            
            // For new employee that's a receptionist
            if ($func == 0) {
                if (!handleInputInteger($rPhone) or strlen($rPhone) != 11) {
                    echo "Invalid phone number.<br>";
                    return false;
                }
                $rPass = rand(1000000000,9999999999);
                $sql = "INSERT INTO Employee VALUES (\"$eSSN\",\"$eFname\",\"$eLname\",\"$eAddress\",\"$eSal\",\"$eSex\",\"$eDOB\",
                    \"$eLogin\",\"$ePass\",\"$superSSN\",\"$rPhone\",\"$rEmail\",NULL,NULL,NULL,NULL,\"$rLogin\",\"$rPass\",\"Receptionist\")";
            }
            // For new employee that's maintenance
            else if ($func == 1) {
                if (!(handleInputInteger($mHr)) or ($mHr+0) > 168) {
                    echo "Invalid number of hours per week.<br>";
                    return false;
                }
                $sql = "INSERT INTO Employee VALUES (\"$eSSN\",\"$eFname\",\"$eLname\",\"$eAddress\",\"$eSal\",\"$eSex\",\"$eDOB\",
                    \"$eLogin\",\"$ePass\",\"$superSSN\",NULL,NULL,\"$mRole\",\"$mHr\",NULL,NULL,NULL,NULL,\"Maintenance\")";
            }
            // For new employee that's other 
            else if ($func == 2) {
                $sql = "INSERT INTO Employee VALUES (\"$eSSN\",\"$eFname\",\"$eLname\",\"$eAddress\",\"$eSal\",\"$eSex\",\"$eDOB\",
                    \"$eLogin\",\"$ePass\",\"$superSSN\",NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,\"Other\")";                
            }
            // For new employee that's an admin
            if ($func == 3) {
                if (!handleInputInteger($rPhone) or strlen($rPhone) != 11) {
                    echo "Invalid phone number.<br>";
                    return false;
                }
                $aPass = rand(1000000000,9999999999);
                $sql = "INSERT INTO Employee VALUES (\"$eSSN\",\"$eFname\",\"$eLname\",\"$eAddress\",\"$eSal\",\"$eSex\",\"$eDOB\",
                    \"$eLogin\",\"$ePass\",\"$superSSN\",\"$rPhone\",\"$rEmail\",NULL,NULL,'$rLogin','$aPass',NULL,NULL,\"Admin\")";
            }

            // For modify employee that's a receptionist
            if ($func == 4) {
                if (!handleInputInteger($rPhone) or strlen($rPhone) != 11) {
                    echo "Invalid phone number.<br>";
                    return false;
                }
                $sql = "UPDATE Employee SET Fname = \"$eFname\", Lname = \"$eLname\", Address = \"$eAddress\", Salary = \"$eSal\",
                    Sex = \"$eSex\", DoB = \"$eDOB\", EmpLogin = \"$eLogin\", BusiPhone = \"$rPhone\", BusiEmail = \"$rEmail\", RecepLogin = \"$rLogin\",
                    EmpFlag = \"Receptionist\" WHERE SSN = \"$eSSN\"";
            }
            // For modify employee that's maintenance
            else if ($func == 5) {
                if (!(handleInputInteger($mHr)) or ($mHr+0) > 168) {
                    echo "Invalid number of hours per week.<br>";
                    return false;
                }
                $sql = "UPDATE Employee SET Fname = \"$eFname\", Lname = \"$eLname\", Address = \"$eAddress\", Salary = \"$eSal\",
                    Sex = \"$eSex\", DoB = \"$eDOB\", EmpLogin = \"$eLogin\", ERole = \"$mRole\", NumHrWeek = \"$mHr\" WHERE SSN = \"$eSSN\"";
            }
            // For modify employee that's other 
            else if ($func == 6) {
                $sql = "UPDATE Employee SET Fname = \"$eFname\", Lname = \"$eLname\", Address = \"$eAddress\", Salary = \"$eSal\",
                    Sex = \"$eSex\", DoB = \"$eDOB\", EmpLogin = \"$eLogin\" WHERE SSN = \"$eSSN\"";              
            }
            // For modify employee that's an admin
            if ($func == 7) {
                if (!handleInputInteger($rPhone) or strlen($rPhone) != 11) {
                    echo "Invalid phone number.<br>";
                    return false;
                }
                $sql = "UPDATE Employee SET Fname = \"$eFname\", Lname = \"$eLname\", Address = \"$eAddress\", Salary = \"$eSal\",
                    Sex = \"$eSex\", DoB = \"$eDOB\", EmpLogin = \"$eLogin\", BusiPhone = \"$rPhone\", BusiEmail = \"$rEmail\", AdminLogin = \"$rLogin\",
                    EmpFlag = \"Admin\" WHERE SSN = \"$eSSN\"";
            }

            $result = mysqli_query($conn, $sql);

            if ($result && ($func >= 0) && ($func <= 3)) {
                echo "Successfully created new employee.<br>";

                $sqlPass = "SELECT EmpPass FROM Employee WHERE SSN = '$eSSN'";
                $resultPass = mysqli_query($conn,$sqlPass);

                $rowNumber = 0;
                $output = array();
                $password = 0;

                while ($row = mysqli_fetch_array($resultPass)) {
                    $password = $row['EmpPass'];
                    $rowNumber++;
                }

                echo "Here is the auto-generated password to the employee: $password.<br>";
                
            }

            return $result;
                
        }
        catch (TypeError $e) {
            echo "Please ensure that the Employee's SSN, the salary, and the number of hours per week (if entered) are valid numbers.<br>
                Please also ensure that the date of birth is a valid date.<br>";
            return false;
        }
    }

    // Admin endpoint: used when an admin deletes an employee record
    function empAdminDel($conn,$eSSN) {
        $sql = "DELETE FROM Employee WHERE SSN = $eSSN";
        $result = mysqli_query($conn,$sql);

        return $result;
    } 

    // Employee endpoint: used when an employee changes their password
    function empChangePass($conn,$ePass,$rPass,$aPass) {
        if (empty($ePass)) {
            echo "The Employee password cannot be empty.<br>";
            return false;
        }

        $eSSN = assignCookie();

        // check to see what kind of Employee they are
        $eType = checkEmpType($conn,$eSSN);

        if ($eType == 'Admin') {
            if (empty($aPass)) {
                echo "The Admin password cannot be empty since you are an Admin.<br>";
                return false;
            }

        }
        else if ($eType == 'Receptionist') {
            if (empty($rPass)) {
                echo "The Receptionist password cannot be empty since you are a Receptionist.<br>";
                return false;
            }
        }

        $rPass = !empty($rPass) ? "'$rPass'" : "NULL";
        $aPass = !empty($aPass) ? "'$aPass'" : "NULL";

        $sql = "UPDATE Employee SET EmpPass = '$ePass', AdminPass = $aPass, RecepPass = $rPass WHERE SSN = $eSSN";
        $result = mysqli_query($conn,$sql);

        return $result;
    } 

    function checkEmpType($conn,$eSSN) {
        $sql = "SELECT EmpFlag FROM Employee WHERE SSN = '$eSSN'";
        $result = mysqli_query($conn,$sql);

        $returning = '';

        if ($result) {
            $rowNumber = 0;
            $output = array();
            while ($row = mysqli_fetch_array($result)) {
                $returning = $row['EmpFlag'];
                $rowNumber++;
            }
        }
        return $returning;
    }

?>