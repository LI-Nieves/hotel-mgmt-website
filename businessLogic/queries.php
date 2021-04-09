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
    function roomGuestRead($conn) {
        $sql = "SELECT * FROM Room WHERE Availability = true";
        $result = mysqli_query($conn, $sql);
        return $result;
    }

    // Guest endpoint 4; used when a guest creates reservations for a room
    function resGuestNew($conn,$resFloor,$resRoom,$aDate,$dDate,$numPeople) {
        $toReturn = false;
        try {
            $guestID = 0;
            // input catching SSNs
            gettype($resFloor + 0);
            gettype($resRoom + 0);
            strtotime($aDate);
            strtotime($dDate);
            gettype($numPeople + 0);
            if (($numPeople + 0) > 6) {
                echo "Only up to 6 people may stay in a room.<br>";
                return false;
            }
            if (isset($_COOKIE["user"])) {
                $guestID = $_COOKIE["user"];
            }
            else {
                echo "Cookies have not been set.<br>";
                return false;
            }

            // generate Reservation ID
            $rID = rand(0000000000,9999999999);
            //generate Confirmation number
            $cNo = rand(0000000000,9999999999);

            $sql = "INSERT INTO Reservation VALUES (\"$guestID\",\"$resFloor\",\"$resRoom\",\"$rID\",\"$aDate\",\"$dDate\",\"$cNo\",\"$numPeople\",NULL)";
            $result1 = mysqli_query($conn, $sql);

            if($result1) {
                echo "Successfully created reservation.<br>Here's the info:<br>";
                $sql2 = "UPDATE Room SET Availability = false WHERE RoomNo = \"$resRoom\"";
                mysqli_query($conn, $sql2);
                $sql3 = "SELECT * FROM Reservation WHERE ResID = \"$rID\"";
                $result = mysqli_query($conn, $sql3);
                return $result;
            }
            else {
                return false;
            }
        }
        catch (TypeError $e) {
            echo "Ensure that the floor number, room number, and number of people staying are numbers.<br>
                Please also ensure that the arrival date and departure date are valid dates.<br>";
            return false;
        }
    } 

    // Guest endpoint 4; used when a guest modifies a reservation for a room
    function resGuestWrite($conn,$rID,$aDate,$dDate,$numPeople) {
        $toReturn = false;
        try {
            $guestID = 0;
            // input catching SSNs
            gettype($rID + 0);
            strtotime($aDate);
            strtotime($dDate);
            gettype($numPeople + 0);
            if (($numPeople + 0) > 6) {
                echo "Only up to 6 people may stay in a room.<br>";
                return false;
            }
            if (isset($_COOKIE["user"])) {
                $guestID = $_COOKIE["user"];
            }
            else {
                echo "Cookies have not been set.<br>";
                return false;
            }

            //generate Confirmation number
            $cNo = rand(0000000000,9999999999);

            $sql = "UPDATE Reservation SET StartDate = \"$aDate\", EndDate = \"$dDate\", NumPeople = \"$numPeople\", ConfirmNo = \"$cNo\" WHERE GuestID = \"$guestID\" AND ResID = \"$rID\"";
            $result1 = mysqli_query($conn, $sql);

            if($result1) {
                echo "Successfully updated reservation.<br>Here's the info:<br>";
                $sql3 = "SELECT * FROM Reservation WHERE ResID = \"$rID\"";
                $result = mysqli_query($conn, $sql3);
                return $result;
            }
            else {
                return false;
            }
        }
        catch (TypeError $e) {
            echo "Ensure that the floor number, room number, and number of people staying are numbers.<br>
                Please also ensure that the arrival date and departure date are valid dates.<br>";
            return false;
        }
    } 

    // Guest endpoint 5; used when a guest views all their reservations
    function resGuestRead($conn) {
        $guestID = 0;
        if (isset($_COOKIE["user"])) {
            $guestID = $_COOKIE["user"];
        }
        else {
            echo "Cookies have not been set.<br>";
            return false;
        }
        $sql = "SELECT * FROM Reservation WHERE GuestID = \"$guestID\"";
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

        setcookie("user", $currentID, 0, "/");

        return $result;
    }

    // Employee endpoint 1; used when an employee logs in
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

        setcookie("user", $currentID, 0, "/");

        return $result;
    }

    // Admin/Receptionist endpoint 1; used to view all transactions
    function transEmpRead($conn) {
        $sql = "SELECT * FROM Transactions";
        $result = mysqli_query($conn, $sql);
        return $result;
    }

    // Admin/Receptionist endpoint 2; used to create transactions
    function transEmpNew($conn,$tDate,$tType,$tCost,$tGuestID,$tMgrSSN,$tRecSSN) {
        $toReturn = false;
        try {
            $guestID = 0;
            // input catching SSNs
            gettype($tCost + 0);
            strtotime($tDate);

            // generate Transaction ID
            $tID = rand(0000000000,9999999999);

            $sql = "";
            if ($tMgrSSN == NULL && $tRecSSN != NULL) {
                $sql = "INSERT INTO Transactions VALUES (\"$tID\",\"$tDate\",\"$tType\",\"$tCost\",\"$tGuestID\",NULL,\"$tRecSSN\")";
            }
            else if ($tRecSSN == NULL && $tMgrSSN != NULL) {
                $sql = "INSERT INTO Transactions VALUES (\"$tID\",\"$tDate\",\"$tType\",\"$tCost\",\"$tGuestID\",\"$tMgrSSN\",NULL)";
            } 
            else if ($tRecSSN != NULL && $tMgrSSN != NULL) {
                $sql = "INSERT INTO Transactions VALUES (\"$tID\",\"$tDate\",\"$tType\",\"$tCost\",\"$tGuestID\",\"$tMgrSSN\",\"$tRecSSN\")";
            }
            else {
                return false;
            }
            $result1 = mysqli_query($conn, $sql);

            if($result1) {
                echo "Successfully created transaction.<br>Here's the Transaction ID:<br>";
                $sql3 = "SELECT * FROM Transactions WHERE TransID = \"$tID\"";
                $result = mysqli_query($conn, $sql3);
                return $result;
            }
            else {
                return false;
            }
        }
        catch (TypeError $e) {
            echo "Ensure that the transaction cost is a valid number.<br>
                Please also ensure that the transaction date date is a valid date.<br>";
            return false;
        }
    }

    // Admin/Receptionist endpoint 3; used to view all reservations
    function resEmpRead($conn) {
        $sql = "SELECT * FROM Reservation";
        $result = mysqli_query($conn, $sql);
        return $result;
    }

    // Admin/Receptionist endpoint 4; used to create a reservation for a room
    function resEmpNew($conn,$resFloor,$resRoom,$aDate,$dDate,$numPeople,$gID) {
        $toReturn = false;
        try {
            $eSSN = 0;
            // input catching SSNs
            gettype($resFloor + 0);
            gettype($resRoom + 0);
            strtotime($aDate);
            strtotime($dDate);
            gettype($numPeople + 0);
            if (($numPeople + 0) > 6) {
                echo "Only up to 6 people may stay in a room.<br>";
                return false;
            }
            if (isset($_COOKIE["user"])) {
                $eSSN = $_COOKIE["user"];
            }
            else {
                echo "Cookies have not been set.<br>";
                return false;
            }

            // generate Reservation ID
            $rID = rand(0000000000,9999999999);
            //generate Confirmation number
            $cNo = rand(0000000000,9999999999);

            $sql = "INSERT INTO Reservation VALUES (\"$gID\",\"$resFloor\",\"$resRoom\",\"$rID\",\"$aDate\",\"$dDate\",\"$cNo\",\"$numPeople\",\"$eSSN\")";
            $result1 = mysqli_query($conn, $sql);

            if($result1) {
                echo "Successfully created reservation.<br>Here's the info:<br>";
                $sql2 = "UPDATE Room SET Availability = false WHERE RoomNo = \"$resRoom\"";
                mysqli_query($conn, $sql2);
                $sql3 = "SELECT * FROM Reservation WHERE ResID = \"$rID\"";
                $result = mysqli_query($conn, $sql3);
                return $result;
            }
            else {
                return false;
            }
        }
        catch (TypeError $e) {
            echo "Ensure that the floor number, room number, and number of people staying are numbers.<br>
                Please also ensure that the arrival date and departure date are valid dates.<br>";
            return false;
        }
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
        $sql = "SELECT * FROM Floors";
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

    // Admin endpoint 9; used when an admin views all employees
    function empAdminRead($conn) {
        $sql = "SELECT * FROM Employee";
        $result = mysqli_query($conn, $sql);
        return $result;
    }



?>