<?php
    include_once 'C:\xampp\htdocs\Project\logic\helper.php';

    // Guest endpoint: used when a guest views all their reservations
    function resGuestRead($conn) {
        $guestID = assignCookie();

        $result = mysqli_query($conn, "CALL resGuestRead($guestID)");
        return $result;
    }

    // Guest endpoint: used when a guest cancels a reservation
    function resGuestDel($conn,$rID,$floorNo,$roomNo) {
        // getting ID of currently logged in Guest
        $guestID = assignCookie();

        $stmt = $conn->prepare("CALL resDel(?,?,?,?)");
        $stmt->bind_param("siis",$rID,$floorNo,$roomNo,$guestID);
        $stmt->execute();

        if ($stmt->affected_rows < 1) {
            return false;
        }

        return true;
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
            if ($aDate < date("Y-m-d")) {
                echo "Cannot create a reservation for a past date.<br>";
                return false;
            }

            $guestID = assignCookie();

            // generate Reservation ID
            $rID = rand(1000000000,9999999999);
            //generate Confirmation number
            $cNo = rand(1000000000,9999999999);
            $eSSN = NULL;

            // CHECK IF THE ROOM IS AVAILABLE
            $assignFloor = checkAvailable($conn,$aDate,$dDate,$numBeds,0);
            $assignRoom = checkAvailable($conn,$aDate,$dDate,$numBeds,1);

            if ($assignFloor == 0 || $assignRoom == 0) {
                echo "Failed to find available room.<br>";
                return false;
            }

            $stmt = $conn->prepare("CALL resNew(?,?,?,?,?,?,?,?,?)");
            $stmt->bind_param("siissssis",$guestID,$assignFloor,$assignRoom,$rID,$aDate,$dDate,$cNo,$numPeople,$eSSN);
            $stmt->execute();

            if ($stmt->affected_rows < 1) {
                return false;
            }

            return array($guestID,$assignFloor,$assignRoom,$rID);
        }
        catch (TypeError $e) {
            echo "Please ensure that the floor number, room number, and number of people staying are numbers.<br>
                Please also ensure that the arrival date and departure date are valid dates in yyyy-mm-dd format.<br>";
            return false;
        }
    } 

    // Admin/Receptionist endpoint: used to view all reservations
    function resEmpRead($conn) {
        $result = mysqli_query($conn, "CALL resEmpRead()");
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

            if ($assignFloor == 0 || $assignRoom == 0) {
                echo "Failed to find available room.<br>";
                return false;
            }

            $stmt = $conn->prepare("CALL resNew(?,?,?,?,?,?,?,?,?)");
            $stmt->bind_param("siissssis",$gID,$assignFloor,$assignRoom,$rID,$aDate,$dDate,$cNo,$numPeople,$eSSN);
            $stmt->execute();

            if ($stmt->affected_rows < 1) {
                return false;
            }

            return array($gID,$assignFloor,$assignRoom,$rID);
        }
        catch (TypeError $e) {
            echo "Please ensure that the floor number, room number, and number of people staying are numbers.<br>
                Please also ensure that the arrival date and departure date are valid dates in yyyy-mm-dd format.<br>";
            return false;
        }
    } 

    // Admin/Receptionist endpoint: used to cancel a reservation
    function resEmpDel($conn,$rID,$floorNo,$roomNo,$gID) {

        $stmt = $conn->prepare("CALL resDel(?,?,?,?)");
        $stmt->bind_param("siis",$rID,$floorNo,$roomNo,$gID);
        $stmt->execute();

        if ($stmt->affected_rows < 1) {
            return false;
        }

        return true;
    }  

    //  algorithm used to check which rooms are suitable for reservation
    //  based on the indicated date range and number of beds
    //  date ranges cannot overlap and the number of beds should be equal
    function checkAvailable($conn,$aDate,$dDate,$numBeds,$func) {
        $sql =  "SELECT FloorNo, RoomNo FROM Room as r1 WHERE r1.Beds >= $numBeds and (FloorNo, RoomNo) NOT IN
                (SELECT FloorNo, RoomNo FROM Reservation as r2 
                WHERE ('$aDate' <= r2.EndDate) and ('$dDate' >= r2.StartDate))";
        $result = mysqli_query($conn, $sql);

        $assignFloor = 0;
        $assignRoom = 0;

        if ($result) {
            $output = array();
            $count = 0;

            while ($row = mysqli_fetch_array($result)) {
                $assignFloor = $row['FloorNo'];
                $assignRoom = $row['RoomNo'];
                $count++;
            }

            if ($count == 0) {
                return 0;
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
            return 0;
        }
        
    }

?>

 