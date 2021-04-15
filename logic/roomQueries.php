<?php

    include_once 'C:\xampp\htdocs\Project\logic\helper.php';

    // Admin/Employee endpoint: used to view all rooms
    function roomEmpRead($conn) {
        $sql = "SELECT * FROM Room";
        $result = mysqli_query($conn, $sql);
        return $result;
    }

    // Employee endpoint: used to modify clean status of room
    // I'm gonna have this one method update both the Room table and the MaintSSN table
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

            $eSSN = assignCookie();

            $sql = "UPDATE Room SET CleanStatus = TRUE WHERE FloorNo = $fNo AND RoomNo = $rNo";
            $result1 = mysqli_query($conn, $sql);

            if($result1) {
                $check = mysqli_query($conn, "SELECT * FROM Room WHERE FloorNo = $fNo AND RoomNo = $rNo");
                $count = 0;
                $output = array();

                while ($row = mysqli_fetch_array($check)) {
                    $count++;
                }

                if ($count > 0) {
                    echo "Successfully set the room as clean.<br>";
                    maintEmpWrite($conn,$fNo,$eSSN);
                    return $result1;
                }
                else {
                    return false;
                }
            }
            else {
                return false;
            }
        }
        catch (TypeError $e) {
            echo "Ensure that the floor number and room number are valid numbers.<br>";
            return false;
        }
    }

    // When Employee cleans a room on a floor, that floor is recorded in the database
    function maintEmpWrite($conn,$fNo,$eSSN) {
        $sqlTry = "SELECT * FROM MaintHandling WHERE MaintSSN = \"$eSSN\" AND FloorNo = $fNo";
        $resultTry = mysqli_query($conn, $sqlTry);

        if ($resultTry) {
            $count = 0;
            while ($row = mysqli_fetch_array($resultTry)) {
                $count++;
            }
            if ($count == 0) {
                $sql = "INSERT INTO MaintHandling VALUES (\"$eSSN\",$fNo)";
                $result = mysqli_query($conn, $sql);
        
                if ($result) {
                    echo "Successfully documented this floor as one you're maintaining.<br>";
                }
                else {
                    echo "Failed to documented this floor as one you're maintaining.<br>";
                }
            }
            else {
                echo "This is the floor you're assigned to clean. Good job!<br>";
            }
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

            if ($oDate == NULL) {
                $sql = "UPDATE Room SET CleanStatus = 0, GCheckIn = \"$gID\", ChkInDate = \"$iDate\", GCheckOut = NULL, ChkOutDate = NULL WHERE FloorNo = $fNo AND RoomNo = $rNo";
                $result = mysqli_query($conn, $sql);
            }
            else {
                $check3 = handleInputDate($oDate);
                if (!$check3) {
                    throw new TypeError;
                }
                $sql = "UPDATE Room SET GCheckIn = \"$gID\", ChkInDate = \"$iDate\", GCheckOut = \"$gID\", ChkOutDate = \"$oDate\" WHERE FloorNo = $fNo AND RoomNo = $rNo";
                $result = mysqli_query($conn, $sql);
            }
            
            return $result;
        }
        catch (TypeError $e) {
            echo "Ensure that the floor number and room number are numbers.<br>
                Please also ensure that the check-in date and check-out date are valid dates.<br>";
            return false;
        }
    }

    // Admin endpoint: creating+modifying new room record
    function roomAdmin($conn,$fNo,$rNo,$cost,$bed,$rType,$func) {
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

            $rType = !empty($rType) ? "'$rType'" : "NULL";
            
            // Admin endpoint: used to create rooms
            if ($func == 0) {
                $sql = "INSERT INTO Room VALUES ($fNo,$rNo,$cost,$bed,TRUE,$rType,NULL,NULL,NULL,NULL)";
            }
            // Admin endpoint: used to modify room details
            else if ($func == 1) {
                $sql = "UPDATE Room SET Cost = $cost, Beds = $bed, RoomType = $rType WHERE FloorNo = $fNo AND RoomNo = $rNo";
            }
            
            $result = mysqli_query($conn, $sql);
            return $result;

        }
        catch (TypeError $e) {
            echo "Ensure that the floor number, room number, cost, and number of beds are numbers.<br>";
            return false;
        }
    }

    // Admin endpoint: used to delete a room record
    function roomAdminDel($conn,$fNo,$rNo) {
        $sql = "DELETE FROM Room WHERE FloorNo = $fNo AND RoomNo = $rNo";
        $result = mysqli_query($conn,$sql);

        return $result;
    } 

?>