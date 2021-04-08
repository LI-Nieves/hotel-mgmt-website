<?php

    function logOut() {
        $currentID = 0;
    }

    // Guest endpoint 1; used when a guest logs in
    function guestAccountRead($conn,$gUser,$gPass) {
        $sql = "SELECT * FROM Guest WHERE GuestLogin = \"$gUser\" AND GuestPass = \"$gPass\"";
        $result = mysqli_query($conn, $sql);

        // setting this guest's ID as the current session's ID
        $sql1 = "SELECT GuestID FROM Guest WHERE GuestLogin = \"$gUser\" AND GuestPass = \"$gPass\"";
        $result1 = mysqli_query($conn, $sql);

        $currentID = 0;
        if ($result1) {
            header("Content-Type: JSON");

            while ($row = mysqli_fetch_array($result1)) {
                $currentID = $row['GuestID'];
            }
        }

        //echo $currentID;

        setcookie("user", $currentID, 0, "/");

        return $result;
    }

    // Guest endpoint 2; used when a guest creates account
    function guestAccountWrite($conn,$gName,$gUser,$gPass,$gCredit,$gPhone,$gAddress) {
        
        try {
            // input catching credit card and phone number
            gettype($gCredit + 0);
            gettype($gPhone + 0);
            if (strlen($gCredit) != 16 or strlen($gPhone) > 11) {
                throw new TypeError(); 
            }

            // generating random GuestID
            $gID = rand(0000000000,9999999999);

            $sql = "INSERT INTO Guest VALUES (\"$gID\",\"$gUser\",\"$gPass\",\"$gCredit\",\"$gPhone\",\"$gName\",\"$gAddress\")";
            $result = mysqli_query($conn, $sql);

            if ($result) {
                echo "Successfully created account.<br>Here's your info:<br>";
                $sql1 = "SELECT * FROM Guest WHERE GuestID = \"$gID\"";
                $result1 = mysqli_query($conn, $sql1);
            }
            return $result1;
        }
        catch (TypeError $e) {
            echo "Ensure that credit card and phone numbers are valid.<br>";
            return false;
        }
    }

    // Guest endpoint 3; used when a guest views all available rooms
    function viewRoomsGuest($conn) {
        $sql = "SELECT * FROM Room WHERE Availability = true";
        $result = mysqli_query($conn, $sql);
        echo $currentID;
        return $result;
    }

    // Guest endpoint 3; used when a guest views all available rooms
    function viewRoomsGuestAmen($conn) {
        $sql = "SELECT * FROM RoomAmenities WHERE (FloorNo, RoomNo) IN (SELECT (FloorNo, RoomNo) FROM Room WHERE Availability = true)";
        $result = mysqli_query($conn, $sql);
        return $result;
    }

    // Admin endpoint 1; used when an admin logs in
    function adminAccountRead($conn,$aUser,$aPass) {
        $sql = "SELECT * FROM Employee WHERE AdminLogin = \"$aUser\" AND AdminPass = \"$aPass\"";
        $result = mysqli_query($conn, $sql);

        // setting this guest's ID as the current session's ID
        $sql1 = "SELECT SSN FROM Employee WHERE AdminLogin = \"$aUser\" AND GuestPass = \"$aPass\"";
        $result1 = mysqli_query($conn, $sql);

        $currentID = 0;
        if ($result1) {
            header("Content-Type: JSON");

            while ($row = mysqli_fetch_array($result1)) {
                $currentID = $row['SSN'];
            }
        }

        //echo $currentID;

        setcookie("user", $currentID, 0, "/");

        return $result;
    }

    // Receptionist endpoint 1; used when a receptionist logs in
    function recepAccountRead($conn,$user,$pass) {
        $sql = "SELECT * FROM Employee WHERE RecepLogin = \"$user\" AND RecepPass = \"$pass\"";
        $result = mysqli_query($conn, $sql);

        // setting this guest's ID as the current session's ID
        $sql1 = "SELECT SSN FROM Employee WHERE RecepLogin = \"$user\" AND RecepPass = \"$pass\"";
        $result1 = mysqli_query($conn, $sql);

        $currentID = 0;
        if ($result1) {
            header("Content-Type: JSON");

            while ($row = mysqli_fetch_array($result1)) {
                $currentID = $row['SSN'];
            }
        }

        //echo $currentID;

        setcookie("user", $currentID, 0, "/");

        return $result;
    }

    // Receptionist endpoint 1; used when a receptionist logs in
    function empAccountRead($conn,$user,$pass) {
        $sql = "SELECT * FROM Employee WHERE EmpLogin = \"$user\" AND EmpPass = \"$pass\"";
        $result = mysqli_query($conn, $sql);

        // setting this guest's ID as the current session's ID
        $sql1 = "SELECT SSN FROM Employee WHERE EmpLogin = \"$user\" AND EmpPass = \"$pass\"";
        $result1 = mysqli_query($conn, $sql);

        $currentID = 0;
        if ($result1) {
            header("Content-Type: JSON");

            while ($row = mysqli_fetch_array($result1)) {
                $currentID = $row['SSN'];
            }
        }

        //echo $currentID;

        setcookie("user", $currentID, 0, "/");

        return $result;
    }

    // Admin endpoint 4; used when an admin creates new dependents
    function depAdminNew($conn,$eSSN, $dSSN, $dName) {
        try {
            // input catching SSNs
            gettype($eSSN + 0);
            gettype($dSSN + 0);
            if (strlen($eSSN) != 9 or strlen($dSSN) != 9) {
                throw new TypeError(); 
            }
            $sql = "INSERT INTO Dependent VALUES (\"$eSSN\",\"$dSSN\",\"$dName\")";
            $result = mysqli_query($conn, $sql);

            return $result;
        }
        catch (TypeError $e) {
            echo "Ensure that both SSNs are valid.<br>";
            return false;
        }
    }    

    // Admin endpoint 4; used when an admin modifies dependents
    function depAdminWrite($conn,$eSSN, $dSSN, $dName) {
        try {
            // input catching SSNs
            gettype($eSSN + 0);
            gettype($dSSN + 0);
            if (strlen($eSSN) != 9 or strlen($dSSN) != 9) {
                throw new TypeError(); 
            }
            $sql = "UPDATE Dependent SET DepSSN = \"$dSSN\", DepName = \"$dName\" WHERE EmpSSN = \"$eSSN\"";
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
            // input catching SSNs
            gettype($eSSN + 0);
            gettype($dSSN + 0);
            if (strlen($eSSN) != 9 or strlen($dSSN) != 9) {
                throw new TypeError(); 
            }

            for ($i = 0; $i < sizeof($dBen); $i++) {
                $sql = "INSERT INTO DepBenefits VALUES (\"$eSSN\",\"$dSSN\",\"$dBen[$i]\")";
                $result = mysqli_query($conn, $sql);
                if (!$result) {
                    echo "Failed to add " .$eSSN. ", " .$dSSN. ", " .$dBen[$i]. " to the database.";
                }
            }
            return $result;
        }
        catch (TypeError $e) {
            echo "Ensure that both SSNs are valid.<br>";
            return false;
        }
    }

    // Admin endpoint 5; used when an admin views all floors
    function floorAdminRead($conn) {
        if (isset($_COOKIE["user"])) {
            echo "User logged in had ID: ".$_COOKIE["user"]."<br>";
        }
        else {
            echo "Cookies have not been set.<br>";
        }
        $sql = "SELECT * FROM Floors";
        $result = mysqli_query($conn, $sql);
        return $result;
    }

    // Admin endpoint 5; used when an admin views all floors (amenities)
    function floorAdminReadAmenities($conn) {
        $sql = "SELECT * FROM FloorAmenities";
        $result = mysqli_query($conn, $sql);
        return $result;
    }

    // Admin endpoint 6.1; used when an admin modifies floors
    // THE AMENITIES AREN'T TREATED LIKE A MULTIVALUED ATTRIBUTE
    function floorAdminWrite($conn,$desiredFloor,$floorNo,$numUtilities) {
        $sql1 = "UPDATE Floors SET FloorNo = $floorNo, NumUtilities = $numUtilities WHERE FloorNo = $desiredFloor";
        $result = mysqli_query($conn, $sql1);
        return $result;
/*         $sql2 = "SELECT * FROM Floors";
        $result2 = mysqli_query($conn, $sql2);
        return $result2; */
    }

    function floorAdminWriteAmenities($conn,$desiredFloor,$floorNo,$fAmenities) {
        $sql2 = "UPDATE FloorAmenities SET FloorNo = $floorNo, FAmenities = \"$fAmenities\" WHERE FloorNo = $desiredFloor";
        $result = mysqli_query($conn, $sql2);
        return $result;
/*         $sql2 = "SELECT * FROM Floors";
        $result2 = mysqli_query($conn, $sql2);
        return $result2; */
    }

    // Admin endpoint 6.1; used when an admin adds new data to floors
    function floorAdminNew($conn,$floorNo,$numUtilities) {
        $sql1 = "INSERT INTO Floors VALUES ($floorNo,$numUtilities)";
        $result = mysqli_query($conn, $sql1);
        return $result;
    }

    function floorAdminNewAmenities($conn,$floorNo,$fAmenities) {
        $sql1 = "INSERT INTO FloorAmenities VALUES ($floorNo,\"$fAmenities\")";
        $result = mysqli_query($conn, $sql1);
        return $result;
    }

    // Admin endpoint 9; used when an admin views all employees
    function empAdminRead($conn) {
        $sql = "SELECT * FROM Employee";
        $result = mysqli_query($conn, $sql);
        return $result;
    }



?>