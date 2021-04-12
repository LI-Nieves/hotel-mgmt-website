<?php
    include 'C:\xampp\htdocs\Project\logic\helper.php';

    // Employee endpoint 4.1; used when an employee modifies their own dependents
    function depEmp($conn,$dSSN1,$dSSN,$dName,$func) {
        try {
            // handling user input
            $check = handleInputInteger($dSSN,$dSSN1);
            if (!$check or strlen($dSSN) != 9 or strlen($dSSN1) != 9) {
                throw new TypeError(); 
            }

            // setting the Employee SSN to be the same of the currently logged in user's
            $eSSN = assignCookie();

            // Employee endpoint 3.1; used when an employee views their own dependents
            if ($func == 0) {
                $sql = "SELECT * FROM Dependent WHERE EmpSSN = \"$eSSN\"";
            }
            // Employee endpoint 3.2; used when an employee modifies their own dependents
            else if ($func == 1) {
                $sql = "UPDATE Dependent SET DepSSN = \"$dSSN\", DepName = \"$dName\" WHERE EmpSSN = \"$eSSN\" and DepSSN = \"$dSSN1\"";
            }
            // Employee endpoint 3.3; used when an employee creates new dependents
            else if ($func == 2) {
                $sql = "INSERT INTO Dependent VALUES (\"$eSSN\",\"$dSSN\",\"$dName\")";
            }
            // Part of Employee endpoint 3.1, except for the DepBenefits table
            else if ($func == 3) {
                $sql = "SELECT * FROM DepBenefits WHERE EmpSSN = \"$eSSN\"";
            }
            
            $result = mysqli_query($conn, $sql);
            return $result;
               
        }
        catch (TypeError $e) {
            echo "Ensure that the dependent's SSN is valid.<br>";
            return false;
        }
    }

    // Admin endpoint 3; used when an admin views all dependents
    function depAdminRead($conn,$func) {
        if ($func == 0) {
            $sql = "SELECT * FROM Dependent";
        }
        else if ($func == 3) {
            $sql = "SELECT * FROM DepBenefits";
        }
        $result = mysqli_query($conn, $sql);
        return $result;
    }

    function depAdmin($conn,$eSSN,$dSSN1,$dSSN,$dName,$func) {
        try {
            // handling user input
            $check = handleInputInteger($eSSN,$dSSN1,$dSSN);
            if (!$check or strlen($eSSN) != 9 or strlen($dSSN1) != 9 or strlen($dSSN) != 9) {
                throw new TypeError(); 
            }

            // Admin endpoint 4; used when an admin creates new dependents
            if ($func == 0) {
                $sql = "INSERT INTO Dependent VALUES (\"$eSSN\",\"$dSSN\",\"$dName\")";
            }
            else if ($func == 1) {
                $sql = "UPDATE Dependent SET DepSSN = \"$dSSN\", DepName = \"$dName\" WHERE EmpSSN = \"$eSSN\" AND DepSSN = \"$dSSN1\"";
            }

            $result = mysqli_query($conn, $sql);
            return $result;
        }
        catch (TypeError $e) {
            echo "Ensure that both SSNs are valid.<br>";
            return false;
        }
    } 

    // Admin endpoint 4; used when an admin creates new dependents
    function depBenAdminNew($conn,$eSSN, $dSSN, $dBen) {
        try {
            // handling user input
            $check = handleInputInteger($eSSN,$dSSN);
            if (!$check or strlen($eSSN) != 9 or strlen($dSSN) != 9) {
                throw new TypeError(); 
            }

            for ($i = 0; $i < sizeof($dBen); $i++) {
                $sql = "INSERT INTO DepBenefits VALUES (\"$eSSN\",\"$dSSN\",\"$dBen[$i]\")";
                $result = mysqli_query($conn, $sql);
                if (!$result) {
                    echo "Failed to add " .$eSSN. ", " .$dSSN. ", " .$dBen[$i]. " to the database.<br>";
                }
            }
            return $result;
        }
        catch (TypeError $e) {
            echo "Ensure that both SSNs are valid.<br>";
            return false;
        }
    }

?>