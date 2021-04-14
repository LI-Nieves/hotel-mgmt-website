<?php
    include 'C:\xampp\htdocs\Project\logic\helper.php';

    // Guest endpoint: used when a guest views all their reservations
    function resGuestRead($conn) {
        $guestID = assignCookie();

        $sql = "SELECT * FROM Reservation WHERE GuestID = \"$guestID\"";
        $result = mysqli_query($conn, $sql);
        return $result;
    }

    // Guest endpoint: used when a guest cancels a reservation
    function resGuestDel($conn,$rID,$floorNo,$roomNo) {
        // getting ID of currently logged in Guest
        $guestID = assignCookie();

        $sql = "DELETE FROM Reservation WHERE ResID = $rID AND FloorNo = $floorNo AND RoomNo = $roomNo AND GuestID = $guestID";
        $result = mysqli_query($conn,$sql);

        return $result;
    } 

    // Guest endpoint: used when a guest creates reservations for a room
    function resGuestNew($conn,$aDate,$dDate,$numPeople,$numBeds) {
        try {
            // handling user input
            $check1 = handleInputInteger($numPeople,$numBeds);
            $check2 = handleInputDate($aDate,$dDate);
            if (!$check1 and !$check2) {
                throw new TypeError;
            }
            if (($numPeople + 0) > 4 or ($numPeople + 0) < 1) {
                echo "1 to 4 people may stay in a room.<br>";
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
            $assignFloor = checkAvailable($conn,$aDate,$dDate,$numBeds,0);
            $assignRoom = checkAvailable($conn,$aDate,$dDate,$numBeds,1);

            $sql = "INSERT INTO Reservation VALUES (\"$guestID\",\"$assignFloor\",\"$assignRoom\",\"$rID\",\"$aDate\",\"$dDate\",\"$cNo\",\"$numPeople\",NULL)";
            $result1 = mysqli_query($conn, $sql);

            if($result1) {
                echo "Successfully created reservation.<br>Here's the info:<br>";
                $sql3 = "SELECT * FROM Reservation WHERE ResID = \"$rID\"";
                $result = mysqli_query($conn, $sql3);
                return $result;
            }
            else {
                return false;
            }
            return false;
        }
        catch (TypeError $e) {
            echo "Ensure that the floor number, room number, and number of people staying are numbers.<br>
                Please also ensure that the arrival date and departure date are valid dates.<br>";
            return false;
        }
    } 

    // Admin/Receptionist endpoint: used to view all reservations
    function resEmpRead($conn) {
        $sql = "SELECT * FROM Reservation";
        $result = mysqli_query($conn, $sql);
        return $result;
    }

    // Admin/Receptionist endpoint: used to create a reservation for a room
    function resEmpNew($conn,$aDate,$dDate,$numPeople,$numBeds,$gID) {
        try {
            // handling user input
            $check1 = handleInputInteger($numPeople,$numBeds);
            $check2 = handleInputDate($aDate,$dDate);
            if (!$check1 and !$check2) {
                throw new TypeError;
            }
            if (($numPeople + 0) > 4 or ($numPeople + 0) < 1) {
                echo "1 to 4 people may stay in a room.<br>";
                return false;
            }
            if (strtotime($aDate) > strtotime($dDate)) {
                echo "Arrival date cannot be after departure date.<br>";
                return false;
            }
            
            $eSSN = assignCookie();

            // generate Reservation ID
            $rID = rand(1000000000,9999999999);
            //generate Confirmation number
            $cNo = rand(1000000000,9999999999);

            // CHECK IF THE ROOM IS AVAILABLE
            $assignFloor = checkAvailable($conn,$aDate,$dDate,$numBeds,0);
            $assignRoom = checkAvailable($conn,$aDate,$dDate,$numBeds,1);

            $sql = "INSERT INTO Reservation VALUES (\"$gID\",\"$assignFloor\",\"$assignRoom\",\"$rID\",\"$aDate\",\"$dDate\",\"$cNo\",\"$numPeople\",\"$eSSN\")";
            $result1 = mysqli_query($conn, $sql);

            if($result1) {
                echo "Successfully created reservation.<br>Here's the info:<br>";
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

    // Admin/Receptionist endpoint: used to cancel a reservation
    function resEmpDel($conn,$rID,$floorNo,$roomNo,$gID) {
        $sql = "DELETE FROM Reservation WHERE ResID = $rID AND FloorNo = $floorNo AND RoomNo = $roomNo AND GuestID = $gID";
        $result = mysqli_query($conn,$sql);

        return $result;
    }  

    //  algorithm used to check which rooms are suitable for reservation
    //  based on the indicated date range and number of beds
    //  date ranges cannot overlap and the number of beds should be equal
    function checkAvailable($conn,$aDate,$dDate,$numBeds,$func) {
        $sql =  "SELECT FloorNo, RoomNo FROM Room as r1 WHERE r1.Beds = $numBeds and (FloorNo, RoomNo) NOT IN
                (SELECT FloorNo, RoomNo FROM Reservation as r2 
                WHERE ('$aDate' <= r2.EndDate) and ('$dDate' >= r2.StartDate))";
        $result = mysqli_query($conn, $sql);

        $assignFloor;
        $assignRoom;

        if ($result) {
            $output = array();

            while ($row = mysqli_fetch_array($result)) {
                $assignFloor = $row['FloorNo'];
                $assignRoom = $row['RoomNo'];
            }

            // for floor
            if ($func == 0) {
                return $assignFloor;
            }
            // for room
            else if ($func == 1) {
                return $assignRoom;
            }
        }
        else {
            echo "Failed to find available room.<br>";
            return 0;
        }
        
    }

/*     // Guest endpoint 4; used when a guest modifies a reservation for a room
    function resGuestWrite($conn,$rID,$aDate,$dDate,$numPeople) {
        try {
            // handle user input
            $check1 = handleInputInteger($rID);
            gettype($rID + 0);
            strtotime($aDate);
            strtotime($dDate);
            gettype($numPeople + 0);
            if (($numPeople + 0) > 4 or ($numPeople + 0) < 1) {
                echo "1 to 4 people may stay in a room.<br>";
                return false;
            }
            if (strtotime($aDate) > strtotime($dDate)) {
                echo "Arrival date cannot be after departure date.<br>";
                return false;
            }
            
            $guestID = assignCookie();

            //generate Confirmation number
            $cNo = rand(1000000000,9999999999);

            // CHECK IF ROOM IS AVAILABLE FOR THAT DATE

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
    }  */

/*     // Admin/Receptionist endpoint 4; used to modify a reservation for a room
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
    }  */

?>

<!-- 

            $guestID = assignCookie();
            if ($guestID == 0) {
                return false;
            }

 -->

 