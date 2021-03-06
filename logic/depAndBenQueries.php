<?php
    include_once 'C:\xampp\htdocs\Project\logic\helper.php';

    // Employee endpoints: used when an employee views+modifies+creates their own dependents
    function depEmp($conn,$dSSN1,$dSSN,$dName,$func) {
        try {
            // handling user input
            $check = handleInputInteger($dSSN,$dSSN1);
            if (!$check or strlen($dSSN) != 9 or strlen($dSSN1) != 9) {
                throw new TypeError; 
            }

            // setting the Employee SSN to be the same of the currently logged in user's
            $eSSN = assignCookie();

            // Employee endpoint: 
            //      used when an employee views their own dependents...
            if ($func == 0) {
                $result = mysqli_query($conn, "CALL depEmpRead($eSSN)");
                return $result;
            }
            //      ... and their benefits
            else if ($func == 3) {
                $result = mysqli_query($conn, "CALL depBenEmpRead($eSSN)");
                return $result;
            }
            // Employee endpoint: used when an employee modifies their own dependents
            else if ($func == 1) {
                $stmt = $conn->prepare("CALL depWrite(?,?,?,?)");
                $stmt->bind_param("ssss",$eSSN,$dSSN1,$dSSN,$dName);
                $stmt->execute();

                if ($stmt->affected_rows < 1) {
                    return false;
                }

                return true;
            }
            // Employee endpoint: used when an employee creates new dependents
            else if ($func == 2) {
                $stmt = $conn->prepare("CALL depNew(?,?,?)");
                $stmt->bind_param("sss",$eSSN,$dSSN,$dName);
                $stmt->execute();

                if ($stmt->affected_rows < 1) {
                    return false;
                }

                return true;
            }              
        }
        catch (TypeError $e) {
            echo "Ensure that the SSNs are valid.<br>";
            return false;
        }
    }

    // Admin endpoint: used when an admin views all dependents
    function depAdminRead($conn,$func) {
        if ($func == 0) {
            $result = mysqli_query($conn, "CALL depAdminRead()");
        }
        else if ($func == 3) {
            $result = mysqli_query($conn, "CALL depBenAdminRead()");
        }
        return $result;
    }

    // Admin endpoint: used when admin creates+modifies dependents
    function depAdmin($conn,$eSSN,$dSSN1,$dSSN,$dName,$func) {
        try {
            // handling user input
            $check = handleInputInteger($eSSN,$dSSN1,$dSSN);
            if (!$check or strlen($eSSN) != 9 or strlen($dSSN1) != 9 or strlen($dSSN) != 9) {
                throw new TypeError(); 
            }

            // Admin endpoint: used when an admin creates new dependents
            if ($func == 1) {
                $stmt = $conn->prepare("CALL depWrite(?,?,?,?)");
                $stmt->bind_param("ssss",$eSSN,$dSSN1,$dSSN,$dName);
                $stmt->execute();

                if ($stmt->affected_rows < 1) {
                    return false;
                }

                return true;
            }
            // Admin endpoint: used when an admin modifies dependents
            else if ($func == 0) {
                $stmt = $conn->prepare("CALL depNew(?,?,?)");
                $stmt->bind_param("sss",$eSSN,$dSSN,$dName);
                $stmt->execute();

                if ($stmt->affected_rows < 1) {
                    return false;
                }

                return true;
            }
        }
        catch (TypeError $e) {
            echo "Ensure that  SSNs are valid.<br>";
            return false;
        }
    } 

    // Admin endpoint: used when an admin creates new dependent benefits
    function depBenAdminNew($conn,$eSSN, $dSSN, $dBen) {
        try {
            // handling user input
            $check = handleInputInteger($eSSN,$dSSN);
            if (!$check or strlen($eSSN) != 9 or strlen($dSSN) != 9) {
                throw new TypeError; 
            }
            
            $stmt = $conn->prepare("CALL depBenNew(?,?,?)");
            $stmt->bind_param("sss",$eSSN, $dSSN, $dBen);
            $stmt->execute();

            if ($stmt->affected_rows < 1) {
                return false;
            }

            return true;
        }
        catch (TypeError $e) {
            echo "Ensure that both SSNs are valid.<br>";
            return false;
        }
    }

    // Admin endpoint: used to remove dependent
    function depAdminDel($conn,$eSSN,$dSSN) {
        $stmt = $conn->prepare("CALL depDel(?,?)");
        $stmt->bind_param("ss",$eSSN,$dSSN);
        $stmt->execute();

        if ($stmt->affected_rows < 1) {
            return false;
        }

        return true;
    }  

    // Admin endpoint: used to remove benefit from dependent
    function depBenAdminDel($conn,$eSSN,$dSSN,$dBen) {
        $stmt = $conn->prepare("CALL depBenDel(?,?,?)");
        $stmt->bind_param("sss",$eSSN,$dSSN,$dBen);
        $stmt->execute();

        if ($stmt->affected_rows < 1) {
            return false;
        }

        return true;
    }  

?>