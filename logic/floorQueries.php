<?php
    include 'C:\xampp\htdocs\Project\logic\helper.php';

    // Admin endpoint 5; used when an admin views all floors
    function floorAdminRead($conn) {
        $sql = "SELECT * FROM Floors";
        $result = mysqli_query($conn, $sql);
        return $result;
    }

    // Admin endpoint 5; used when an admin views all floors
    function maintAdminRead($conn) {
        $sql = "SELECT * FROM MaintHandling";
        $result = mysqli_query($conn, $sql);
        return $result;
    }

    function floorAdminNew($conn,$floorNo,$numUtilities,$fAmenities) {
        try {
            // handling user input
            $check = handleInputInteger($floorNo,$numUtilities);
            if (!$check) {
                throw new TypeError;
            }
            if ($floorNo < 0) {
                echo "The floor number cannot be negative.<br>";
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
            echo "Please ensure that the floor number and number of utilities is a number.<br>";
            return false;
        }
    }

?>