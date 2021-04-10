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
            else if (($numPeople + 0) < 0) {
                echo "The number of guests can't be negative.<br>";
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
            $rID = rand(1000000000,9999999999);
            //generate Confirmation number
            $cNo = rand(1000000000,9999999999);

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
            else if (($numPeople + 0) < 0) {
                echo "The number of guests can't be negative.<br>";
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
            $cNo = rand(1000000000,9999999999);

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
            if (($tCost + 0) < 0) {
                echo "The cost can't be negative.<br>";
                return false;
            }

            // generate Transaction ID
            $tID = rand(1000000000,9999999999);

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
            else if (($numPeople + 0) < 0) {
                echo "The number of guests can't be negative.<br>";
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
            $rID = rand(1000000000,9999999999);
            //generate Confirmation number
            $cNo = rand(1000000000,9999999999);

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

    // Admin/Receptionist endpoint 4; used to modify a reservation for a room
    function resEmpWrite($conn,$rID,$aDate,$dDate,$numPeople,$gID) {
        $toReturn = false;
        try {
            $eSSN = 0;
            // input catching SSNs
            gettype($rID + 0);
            strtotime($aDate);
            strtotime($dDate);
            gettype($numPeople + 0);
            if (($numPeople + 0) > 6) {
                echo "Only up to 6 people may stay in a room.<br>";
                return false;
            }
            else if (($numPeople + 0) < 0) {
                echo "The number of guests can't be negative.<br>";
                return false;
            }

            if (isset($_COOKIE["user"])) {
                $eSSN = $_COOKIE["user"];
            }
            else {
                echo "Cookies have not been set.<br>";
                return false;
            }

            //generate Confirmation number
            $cNo = rand(1000000000,9999999999);

            $sql = "UPDATE Reservation SET StartDate = \"$aDate\", EndDate = \"$dDate\", NumPeople = \"$numPeople\", ConfirmNo = \"$cNo\", EmpSSN = \"$eSSN\" WHERE GuestID = \"$gID\" AND ResID = \"$rID\"";
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

    // Admin/Receptionist endpoint 5; used to view all phone calls
    function phoneEmpRead($conn) {
        $sql = "SELECT * FROM PhoneCall";
        $result = mysqli_query($conn, $sql);
        return $result;
    }

    // Admin/Receptionist endpoint 6; used to create a phone call record
    function phoneEmpNew($conn,$gID,$duration,$pDate) {
        $toReturn = false;
        try {
            $eSSN = 0;
            // handling user input
            // date can be from before today
            gettype($gID + 0);
            gettype($duration + 0);
            strtotime($pDate);
            if ($duration < 0) {
                echo "The duration cannot be negative.<br>";
                return false;
            }

            // setting the EmpSSN on record to be the currently logged in employee
            if (isset($_COOKIE["user"])) {
                $eSSN = $_COOKIE["user"];
            }
            else {
                echo "Cookies have not been set.<br>";
                return false;
            }

            //generate CallID
            $cID = rand(1000000000,9999999999);

            $sql = "INSERT INTO PhoneCall VALUES (\"$cID\", $duration, \"$pDate\", \"$gID\", \"$eSSN\")";
            $result1 = mysqli_query($conn, $sql);

            if($result1) {
                echo "Successfully created phone call record.<br>Here's the info:<br>";
                $sql3 = "SELECT * FROM PhoneCall WHERE CallID = \"$cID\"";
                $result = mysqli_query($conn, $sql3);
                return $result;
            }
            else {
                return false;
            }
        }
        catch (TypeError $e) {
            echo "Please ensure that the duration is a number.<br>
                Please also ensure that the call date is a valid date.<br>";
            return false;
        }
    }

    // Admin/Employee endpoint 1; used to view all rooms
    function roomEmpRead($conn) {
        $sql = "SELECT * FROM Room";
        $result = mysqli_query($conn, $sql);
        return $result;
    }

    // Employee endpoint 2; used to modify clean status of room
    // I'm gonna have this one method update both the Room table and the MaintSSN table
    function roomEmpWrite($conn,$fNo,$rNo) {//,$stat) {
        $toReturn = false;
        try {
            $eSSN = 0;
            // input catching SSNs
            gettype($fNo + 0);
            gettype($rNo + 0);
            if (($fNo + 0) < 0) {
                echo "The floor number cannot be negative.<br>";
                return false;
            }
            if (($rNo + 0) < 0) {
                echo "The room number cannot be negative.<br>";
                return false;
            }

            if (isset($_COOKIE["user"])) {
                $eSSN = $_COOKIE["user"];
            }
            else {
                echo "Cookies have not been set.<br>";
                return false;
            };

            $sql = "UPDATE Room SET CleanStatus = TRUE WHERE FloorNo = $fNo AND RoomNo = $rNo";
            $result1 = mysqli_query($conn, $sql);

            if($result1) {
                echo "Successfully set the room as clean.<br>";
                maintEmpWrite($conn,$fNo,$eSSN);
                return $result1;
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

    // Admin/Receptionist 2; used to create room
    function roomRecepWrite($conn,$fNo,$rNo,$gID,$iDate,$oDate) {
        $toReturn = false;
        try {
            // handling user input
            gettype($fNo + 0);
            gettype($rNo + 0);
            strtotime($iDate);
            if (($fNo + 0) < 0) {
                echo "The floor number cannot be negative.<br>";
                return false;
            }
            if (($rNo + 0) < 0) {
                echo "The room number cannot be negative.<br>";
                return false;
            }

            if ($oDate == NULL) {
                $sql = "UPDATE Room SET Availability = 0, CleanStatus = 0, GCheckIn = \"$gID\", ChkInDate = \"$iDate\", GCheckOut = NULL, ChkOutDate = NULL WHERE FloorNo = $fNo AND RoomNo = $rNo";
                $result = mysqli_query($conn, $sql);
                return $result;
            }
            else {
                $sql = "UPDATE Room SET Availability = TRUE, GCheckIn = \"$gID\", ChkInDate = \"$iDate\", GCheckOut = \"$gID\", ChkOutDate = \"$oDate\" WHERE FloorNo = $fNo AND RoomNo = $rNo";
                $result = mysqli_query($conn, $sql);
                return $result;
            }
        }
        catch (TypeError $e) {
            echo "Ensure that the floor number and room number are numbers.<br>
                Please also ensure that the check-in date and check-out date are valid dates.<br>";
            return false;
        }
    }

    // Admin endpoint 2; used to create room
    function roomAdminNew($conn,$fNo,$rNo,$cost,$bed,$rType) {
        $toReturn = false;
        try {
            // handling user input
            gettype($fNo + 0);
            gettype($rNo + 0);
            gettype($cost + 0);
            gettype($bed + 0);
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

            $sql = "INSERT INTO Room VALUES ($fNo,$rNo,$cost,$bed,TRUE,TRUE,\"$rType\",NULL,NULL,NULL,NULL)";
            $result = mysqli_query($conn, $sql);
            return $result;
               
        }
        catch (TypeError $e) {
            echo "Ensure that the floor number, room number, cost, and number of beds are numbers.<br>";
            return false;
        }
    }

    // Admin endpoint 2; used to modify room details
    function roomAdminWrite($conn,$fNo,$rNo,$cost,$bed,$rType) {
        $toReturn = false;
        try {
            // handling user input
            gettype($fNo + 0);
            gettype($rNo + 0);
            gettype($cost + 0);
            gettype($bed + 0);
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

            $sql = "UPDATE Room SET Cost = $cost, Beds = $bed, RoomType = \"$rType\" WHERE FloorNo = $fNo AND RoomNo = $rNo";
            $result = mysqli_query($conn, $sql);
            return $result;
               
        }
        catch (TypeError $e) {
            echo "Ensure that the floor number, room number, cost, and number of beds are numbers.<br>";
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