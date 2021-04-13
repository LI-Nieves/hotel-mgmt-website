<?php
    include 'C:\xampp\htdocs\Project\logic\helper.php';

    // Guest endpoint 4; used when a guest creates reservations for a room
    function resGuestNew($conn,$resFloor,$resRoom,$aDate,$dDate,$numPeople) {
        try {
            // handling user input
            $check1 = handleInputInteger($resFloor,$resRoom,$numPeople);
            $check2 = handleInputDate($aDate,$dDate);
            if (!$check1 and !$check2) {
                throw new TypeError;
            }
            if (($numPeople + 0) > 6 or ($numPeople + 0) < 1) {
                echo "1 to 6 people may stay in a room.<br>";
                return false;
            }
            if (strtotime($aDate) > strtotime($dDate)) {
                echo "Arrival date cannot be after departure date.<br>";
                return false;
            }

            $guestID = assignCookie();

            // generate Reservation ID
            $rID = rand(1000000000,9999999999);
            //generate Confirmation number
            $cNo = rand(1000000000,9999999999);

            // CHECK IF THE ROOM IS AVAILABLE
            //$available = checkAvailable()

            $sql = "INSERT INTO Reservation VALUES (\"$guestID\",\"$resFloor\",\"$resRoom\",\"$rID\",\"$aDate\",\"$dDate\",\"$cNo\",\"$numPeople\",NULL)";
            $result1 = mysqli_query($conn, $sql);

            if($result1) {
                echo "Successfully created reservation.<br>Here's the info:<br>";
                $sql2 = "UPDATE Room SET Availability = false WHERE FloorNo = $resFloor and RoomNo = \"$resRoom\"";
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

/*     function checkAvailable($start_one,$end_one,$start_two,$end_two) {
        if($start_one <= $end_two && $end_one >= $start_two) { //If the dates overlap
             return min($end_one,$end_two)->diff(max($start_two,$start_one))->days + 1; //return how many days overlap
        }
     
        return 0; //Return 0 if there is no overlap
     } */

    // Guest endpoint 4; used when a guest modifies a reservation for a room
    function resGuestWrite($conn,$rID,$aDate,$dDate,$numPeople) {
        try {
            // handle user input
            $check1 = handleInputInteger($rID);
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
            
            $guestID = assignCookie();
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
        $guestID = assignCookie();

        $sql = "SELECT * FROM Reservation WHERE GuestID = \"$guestID\"";
        $result = mysqli_query($conn, $sql);
        return $result;
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



?>

<!-- 

            $guestID = assignCookie();
            if ($guestID == 0) {
                return false;
            }

 -->