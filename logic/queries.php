<?php
    include 'C:\xampp\htdocs\Project\logic\helper.php';

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

    // Admin endpoint 6.1; used when an admin modifies floors
    // THE AMENITIES AREN'T TREATED LIKE A MULTIVALUED ATTRIBUTE
    function floorAdminWrite($conn,$desiredFloor,$floorNo,$numUtilities) {
        $sql1 = "UPDATE Floors SET FloorNo = $floorNo, NumUtilities = $numUtilities WHERE FloorNo = $desiredFloor";
        $result = mysqli_query($conn, $sql1);
        return $result;
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

?>

<!-- 

            $guestID = assignCookie();
            if ($guestID == 0) {
                return false;
            }

 -->