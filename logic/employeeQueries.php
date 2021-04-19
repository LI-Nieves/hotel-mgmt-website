<?php
    include_once 'C:\xampp\htdocs\Project\logic\helper.php';

    function adminLogin($conn,$user,$pass) {
        // SQL statement
        $stmt = $conn->prepare("CALL GetCurrentAdmin(?,?)");
        $stmt->bind_param("ss", $user, $pass);
        $stmt->execute();
        $result = $stmt->get_result();

        $resultRet = $result;

        $currentID = 0;
        if ($result) {
            $count = 0;
            while ($row = mysqli_fetch_array($result)) {
                $currentID = $row['SSN'];
                $count++;
            }
            if ($count == 0) {
                return false;
            }
            // setting this Admin's SSN as the current session's ID
            setcookie("user", $currentID, 0, "/");
        }
        
        return $resultRet;
    }

    // Receptionist endpoint: used when a receptionist logs in
    function recepLogin($conn,$user,$pass) {
        $stmt = $conn->prepare("CALL GetCurrentRecep(?,?)");
        $stmt->bind_param("ss", $user, $pass);
        $stmt->execute();
        $result = $stmt->get_result();

        $resultRet = $result;

        $currentID = 0;
        if ($result) {
            $count = 0;
            while ($row = mysqli_fetch_array($result)) {
                $currentID = $row['SSN'];
                $count++;
            }
            if ($count == 0) {
                return false;
            }
            // setting this Receptionist's SSN as the current session's ID
            setcookie("user", $currentID, 0, "/");
        }
        
        return $resultRet;
    }

    // Employee endpoint: used when an employee logs in
    function employeeLogin($conn,$user,$pass) {
        $stmt = $conn->prepare("CALL GetCurrentEmp(?,?)");
        $stmt->bind_param("ss", $user, $pass);
        $stmt->execute();
        $result = $stmt->get_result();

        $resultRet = $result;

        $currentID = 0;
        if ($result) {
            $count = 0;
            while ($row = mysqli_fetch_array($result)) {
                $currentID = $row['SSN'];
                $count++;
            }
            if ($count == 0) {
                return false;
            }
            // setting this Employee's SSN as the current session's ID
            setcookie("user", $currentID, 0, "/");
        }
        
        return $resultRet;
    }

    // Employee endpoint: used when an employee views their own information
    function empEmpRead($conn) {
        $eSSN = assignCookie();
        $result = mysqli_query($conn, "CALL checkEmp($eSSN)");
        return $result;
    }

    // Admin endpoint; used when an admin views all employees
    function empAdminRead($conn) {
        $result = mysqli_query($conn, "CALL empAdminRead()");
        return $result;
    }
    
    // Admin endpoint: used when admin creates+modifies employees
    function empAdmin($conn,$eSSN,$eFname,$eLname,$eAddress,$eSal,$eSex,$eDOB,$eLogin,$eFlag,$rPhone,$rEmail,$rLogin,$mRole,$mHr,$func) {
        try {
            // checking if the Employee username already exists
            $table = 'Employee'; 
            $dupUsername = dupUsername($conn,$eLogin,$table,$eSSN);
            if ($dupUsername) {
                echo "This employee username already exists in the database.<br>";
                return false;
            }

            // checking if the Recep username already exists (if they're a receptionist) 
            if ($func == 0 || $func == 4) {
                $table = 'Receptionist'; 
                $dupUsername = dupUsername($conn,$rLogin,$table,$eSSN);
                if ($dupUsername) {
                    echo "This receptionist username already exists in the database.<br>";
                    return false;
                }
            }

            // checking if the Admin username already exists (if they're a Admin) 
            if ($func == 3 || $func == 7) {
                $table = 'Admin'; 
                $dupUsername = dupUsername($conn,$rLogin,$table,$eSSN);
                if ($dupUsername) {
                    echo "This admin username already exists in the database.<br>";
                    return false;
                }
            }

            // handling user input
            $output = handleInputInteger($eSSN,$eSal);
            $output2 = handleInputDate($eDOB);
            if (!($output and $output2)) {
                throw new TypeError; 
            }
            if (strlen($eSSN) != 9) {
                echo "Invalid SSN.<br>";
                return false;
            }
            if ($eDOB > date('Y-m-d', mktime(0, 0, 0, date("m") , date("d"), date("Y")-14))) {
                echo "Employee cannot be under 14 years old.<br>";
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
                $stmt = $conn->prepare("CALL newRecep(?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
                $stmt->bind_param("ssssisssssssss",$eSSN,$eFname,$eLname,$eAddress,$eSal,$eSex,$eDOB,$eLogin,$ePass,$superSSN,$rPhone,$rEmail,$rLogin,$rPass);
                $stmt->execute();
                if ($stmt->affected_rows < 1) {
                    return false;
                }
                return $ePass;
            }
            // For new employee that's maintenance
            else if ($func == 1) {
                if (!(handleInputInteger($mHr)) or ($mHr+0) > 168) {
                    echo "Invalid number of hours per week.<br>";
                    return false;
                }
                $stmt = $conn->prepare("CALL newMaint(?,?,?,?,?,?,?,?,?,?,?,?)");
                $stmt->bind_param("ssssissssssi",$eSSN,$eFname,$eLname,$eAddress,$eSal,$eSex,$eDOB,$eLogin,$ePass,$superSSN,$mRole,$mHr);
                $stmt->execute();
                if ($stmt->affected_rows < 1) {
                    return false;
                }
                return $ePass;
            }
            // For new employee that's other 
            else if ($func == 2) {
                $stmt = $conn->prepare("CALL newOther(?,?,?,?,?,?,?,?,?,?)");
                $stmt->bind_param("ssssisssss",$eSSN,$eFname,$eLname,$eAddress,$eSal,$eSex,$eDOB,$eLogin,$ePass,$superSSN);
                $stmt->execute();
                if ($stmt->affected_rows < 1) {
                    return false;
                }    
                return $ePass;        
            }
            // For new employee that's an admin
            if ($func == 3) {
                if (!handleInputInteger($rPhone) or strlen($rPhone) != 11) {
                    echo "Invalid phone number.<br>";
                    return false;
                }
                $aPass = rand(1000000000,9999999999);
                $stmt = $conn->prepare("CALL newAdmin(?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
                $stmt->bind_param("ssssisssssssss",$eSSN,$eFname,$eLname,$eAddress,$eSal,$eSex,$eDOB,$eLogin,$ePass,$superSSN,$rPhone,$rEmail,$rLogin,$aPass);
                $stmt->execute();
                if ($stmt->affected_rows < 1) {
                    return false;
                }
                return $ePass;
            }

            // For modify employee that's a receptionist
            if ($func == 4) {
                if (!handleInputInteger($rPhone) or strlen($rPhone) != 11) {
                    echo "Invalid phone number.<br>";
                    return false;
                }
                $stmt = $conn->prepare("CALL modRecep(?,?,?,?,?,?,?,?,?,?,?)");
                $stmt->bind_param("ssssissssss",$eSSN,$eFname,$eLname,$eAddress,$eSal,$eSex,$eDOB,$eLogin,$rPhone,$rEmail,$rLogin,);
                $stmt->execute();
                if ($stmt->affected_rows < 1) {
                    return false;
                }
                return true;
            }
            // For modify employee that's maintenance
            else if ($func == 5) {
                if (!(handleInputInteger($mHr)) or ($mHr+0) > 168) {
                    echo "Invalid number of hours per week.<br>";
                    return false;
                }
                $stmt = $conn->prepare("CALL modMaint(?,?,?,?,?,?,?,?,?,?)");
                $stmt->bind_param("ssssissssi",$eSSN,$eFname,$eLname,$eAddress,$eSal,$eSex,$eDOB,$eLogin,$mRole,$mHr);
                $stmt->execute();
                if ($stmt->affected_rows < 1) {
                    return false;
                }
                return true;            }
            // For modify employee that's other 
            else if ($func == 6) {
                $stmt = $conn->prepare("CALL modOther(?,?,?,?,?,?,?,?)");
                $stmt->bind_param("ssssisss",$eSSN,$eFname,$eLname,$eAddress,$eSal,$eSex,$eDOB,$eLogin);
                $stmt->execute();
                if ($stmt->affected_rows < 1) {
                    return false;
                }    
                return true;       
            }
            // For modify employee that's an admin
            if ($func == 7) {
                if (!handleInputInteger($rPhone) or strlen($rPhone) != 11) {
                    echo "Invalid phone number.<br>";
                    return false;
                }
                $stmt = $conn->prepare("CALL modAdmin(?,?,?,?,?,?,?,?,?,?,?)");
                $stmt->bind_param("ssssissssss",$eSSN,$eFname,$eLname,$eAddress,$eSal,$eSex,$eDOB,$eLogin,$rPhone,$rEmail,$rLogin,);
                $stmt->execute();
                if ($stmt->affected_rows < 1) {
                    return false;
                }
                return true;
            }                
        }
        catch (TypeError $e) {
            echo "Please ensure that the Employee's SSN, the salary, and the number of hours per week (if entered) are valid numbers.<br>
                Please also ensure that the date of birth is a valid date in yyyy-mm-dd format.<br>";
            return false;
        }
    }

    // Admin endpoint: used when an admin deletes an employee record
    function empAdminDel($conn,$eSSN) {
        $stmt = $conn->prepare("CALL empAdminDel(?)");
        $stmt->bind_param("s",$eSSN);
        $stmt->execute();

        if ($stmt->affected_rows < 1) {
            return false;
        }

        return true;
    } 

    // Employee endpoint: used when an employee changes their password
    function empChangePass($conn,$ePass,$rPass,$aPass,$eType) {
        if (empty($ePass)) {
            echo "The Employee password cannot be empty.<br>";
            return false;
        }

        $eSSN = assignCookie();

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

        $rPass = !empty($rPass) ? $rPass : NULL;
        $aPass = !empty($aPass) ? $aPass : NULL;

        $stmt = $conn->prepare("CALL changePass(?,?,?,?)");
        $stmt->bind_param("ssss",$eSSN,$ePass,$rPass,$aPass);
        $stmt->execute();

        if ($stmt->affected_rows < 1) {
            return false;
        }

        return true;
    } 

    function checkEmpType($conn,$eSSN) {
        $result = mysqli_query($conn,"CALL checkEType($eSSN)");

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