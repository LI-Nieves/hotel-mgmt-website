<?php

    include_once 'C:\xampp\htdocs\Project\logic\helper.php';

    // Admin/Employee endpoint: used to view all rooms
    function roomEmpRead($conn) {
        $result = mysqli_query($conn, "CALL roomEmpRead()");
        return $result;
    }

    // Employee endpoint: used to modify clean status of room
    // This one method updates both the Room table and the MaintSSN table
    function roomEmpWrite($conn,$fNo,$rNo) {
        try {
            // handling user input
            $check = handleInputInteger($fNo,$rNo);
            if (!$check) {
                throw new TypeError;
            }
            if (($fNo + 0) < 0) {
                echo "The floor number cannot be negative.<br>";
                return false;
            }
            if (($rNo + 0) < 0) {
                echo "The room number cannot be negative.<br>";
                return false;
            }



            $stmt = $conn->prepare("CALL roomEmpWrite(?,?)");
            $stmt->bind_param("ii",$fNo,$rNo);
            $stmt->execute();

            if ($stmt->affected_rows < 1) {
                echo "This room is already clean.<br>";
                return false;
            }

            return true;
        }
        catch (TypeError $e) {
            echo "Ensure that the floor number and room number are valid numbers.<br>";
            return false;
        }
    }

    // When Employee cleans a room on a floor, that floor is recorded in the database
    function maintEmpWrite($conn1,$conn2,$fNo,$eSSN) {

        // checking if that employee already maintains that floor
        $stmt = $conn1->prepare("CALL checkMaint(?,?)");
        $stmt->bind_param("is",$fNo,$eSSN);
        $stmt->execute();
        $result = $stmt->get_result();

        $count = mysqli_num_rows($result);
        if ($count == 0) {
            $stmt = $conn2->prepare("CALL maintNew(?,?)");
            $stmt->bind_param("is",$fNo,$eSSN);
            $stmt->execute();

            if ($stmt->affected_rows < 1) {
                echo "Failed to documented this floor as one you're maintaining.<br>";
            }
            else {
                echo "Successfully documented this floor as one you're maintaining.<br>";
            }
        }
        else {
            echo "This is the floor you're assigned to clean. Good job!<br>";
        }
    }

    // Receptionist ednpoint: used to check guests in/out
    function roomRecepWrite($conn,$fNo,$rNo,$gID,$iDate,$oDate) {
        try {
            // handling user input
            $check1 = handleInputInteger($fNo,$rNo);
            $check2 = handleInputDate($iDate);
            if (!$check1 and !$check2) {
                throw new TypeError;
            }
            if (($fNo + 0) < 0) {
                echo "The floor number cannot be negative.<br>";
                return false;
            }
            if (($rNo + 0) < 0) {
                echo "The room number cannot be negative.<br>";
                return false;
            }
            if ($iDate < date("Y-m-d")) {
                echo "Cannot check a guest in/out on a past date.<br>";
                return false;
            }

            if ($oDate == NULL) {
                $stmt = $conn->prepare("CALL checkIn(?,?,?,?)");
                $stmt->bind_param("iiss",$fNo,$rNo,$gID,$iDate);
                $stmt->execute();
    
                if ($stmt->affected_rows < 1) {
                    return false;
                }
            }
            else {
                $check3 = handleInputDate($oDate);
                if (!$check3) {
                    throw new TypeError;
                }
                if (strtotime($iDate) > strtotime($oDate)) {
                    echo "Check-in date cannot be after check-out date.<br>";
                    return false;
                }
                $stmt = $conn->prepare("CALL checkOut(?,?,?,?,?)");
                $stmt->bind_param("iisss",$fNo,$rNo,$gID,$iDate,$oDate);
                $stmt->execute();
    
                if ($stmt->affected_rows < 1) {
                    return false;
                }
            }
            
            return true;
        }
        catch (TypeError $e) {
            echo "Please ensure that the floor number and room number are numbers.<br>
                Please also ensure that the check-in date and check-out date are valid dates in yyyy-mm-dd format.<br>";
            return false;
        }
    }

    // Admin endpoint: creating+modifying new room record
    function roomAdmin($conn,$fNo,$rNo,$cost,$bed,$rType) {
        try {
            // handling user input
            $check = handleInputInteger($fNo,$rNo,$cost,$bed);
            if (!$check) {
                throw new TypeError;
            }
            if (($fNo + 0) < 0) {
                echo "The floor number cannot be negative.<br>";
                return false;
            }
            if (($rNo + 0) < 0) {
                echo "The room number cannot be negative.<br>";
                return false;
            }
            if (($cost + 0) < 0) {
                echo "The cost cannot be negative.<br>";
                return false;
            }
            if (($bed + 0) < 0) {
                echo "The number of beds cannot be negative.<br>";
                return false;
            }

            $rType = !empty($rType) ? $rType : NULL;

            $stmt = $conn->prepare("CALL roomAdmin(?,?,?,?,?)");
            $stmt->bind_param("iiiis",$fNo,$rNo,$cost,$bed,$rType);
            $stmt->execute();

            if ($stmt->affected_rows < 1) {
                return false;
            }

            return true;

        }
        catch (TypeError $e) {
            echo "Please ensure that the floor number, room number, cost, and number of beds are numbers.<br>";
            return false;
        }
    }

?>