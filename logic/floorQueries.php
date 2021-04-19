<?php
    include_once 'C:\xampp\htdocs\Project\logic\helper.php';

    // Admin endpoint: used when an admin views all floors
    function floorAdminRead($conn) {
        $result = mysqli_query($conn, "CALL floorAdminRead()");
        return $result;
    }

    // Admin endpoint: used when an admin views who's maintaining the floors
    function maintAdminRead($conn) {
        $result = mysqli_query($conn, "CALL maintAdminRead()");
        return $result;
    }

    // Admin endpoint; used when an admin modifies floor record
    function floorAdminWrite($conn,$desiredFloor,$fAmenities,$numUtilities) {
        try {
        
            // handling user input
            $check = handleInputInteger($desiredFloor,$numUtilities);
            if (!$check) {
                throw new TypeError;
            }
            if ($desiredFloor < 0) {
                echo "Invalid floor number.<br>";
                return false;
            }
            if ($numUtilities < 0 and $numUtilities != '') {
                echo "The number of utilities cannot be negative.<br>";
                return false;
            }

            $numUtilities = !empty($numUtilities) ? $numUtilities : NULL;
            $fAmenities = !empty($fAmenities) ? $fAmenities : NULL;

            $stmt = $conn->prepare("CALL floorAdminWrite(?,?,?)");
            $stmt->bind_param("isi",$desiredFloor,$fAmenities,$numUtilities);
            $stmt->execute();

            if ($stmt->affected_rows < 1) {
                return false;
            }

            return true;

        }
        catch (TypeError $e) {
            echo "Please ensure that the floor number and number of utilities is a number.<br>";
            return false;
        }
    }

?>