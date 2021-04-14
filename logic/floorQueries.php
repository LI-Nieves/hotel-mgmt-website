<?php
    include 'C:\xampp\htdocs\Project\logic\helper.php';

    // Admin endpoint: used when an admin views all floors
    function floorAdminRead($conn) {
        $sql = "SELECT * FROM Floors";
        $result = mysqli_query($conn, $sql);
        return $result;
    }

    // Admin endpoint: used when an admin views who's maintaining the floors
    function maintAdminRead($conn) {
        $sql = "SELECT * FROM MaintHandling";
        $result = mysqli_query($conn, $sql);
        return $result;
    }

    // Admin endpoint: used when an admin creates a new record for a floor
    function floorAdminNew($conn,$floorNo,$numUtilities,$fAmenities) {
        try {
            // handling user input
            $check = handleInputInteger($floorNo,$numUtilities);
            if (!$check) {
                throw new TypeError;
            }
            if ($floorNo < 0) {
                echo "Invalid floor number.<br>";
                return false;
            }
            if ($numUtilities < 0 and $numUtilities != '') {
                echo "The number of utilities cannot be negative.<br>";
                return false;
            }

            $numUtilities = !empty($numUtilities) ? "'$numUtilities'" : "NULL";
            $fAmenities = !empty($fAmenities) ? "'$fAmenities'" : "NULL";

            $sql1 = "INSERT INTO Floors VALUES ($floorNo,$fAmenities,$numUtilities)";
            $result = mysqli_query($conn, $sql1);
            return $result;

        }
        catch (TypeError $e) {
            echo "Please ensure that the floor number and number of utilities is a valid number.<br>";
            return false;
        }
    }

    // Admin endpoint; used when an admin modifies floor record
    function floorAdminWrite($conn,$desiredFloor,$floorNo,$fAmenities,$numUtilities) {
        try {
        
            // handling user input
            $check = handleInputInteger($desiredFloor,$floorNo,$numUtilities);
            if (!$check) {
                throw new TypeError;
            }
            if ($desiredFloor < 0 or $floorNo < 0) {
                echo "The floor number cannot be negative.<br>";
                return false;
            }
            if ($numUtilities < 0 and $numUtilities != '') {
                echo "The number of utilities cannot be negative.<br>";
                return false;
            }

            $numUtilities = !empty($numUtilities) ? "'$numUtilities'" : "NULL";
            $fAmenities = !empty($fAmenities) ? "'$fAmenities'" : "NULL";

            // setting the EmpSSN on record to be the currently logged in employee
            $eSSN = assignCookie();

            $sql1 = "UPDATE Floors SET FloorNo = $floorNo, FAmenities = $fAmenities, NumUtilities = $numUtilities WHERE FloorNo = $desiredFloor";
            $result = mysqli_query($conn, $sql1);
            
            return $result;

        }
        catch (TypeError $e) {
            echo "Please ensure that the floor number and number of utilities is a number.<br>";
            return false;
        }
    }

    // Admin endpoint: used to delete a floor record
    function floorAdminDel($conn,$fNo) {
        $sql = "DELETE FROM Floors WHERE FloorNo = $fNo";
        $result = mysqli_query($conn,$sql);

        return $result;
    }  

?>