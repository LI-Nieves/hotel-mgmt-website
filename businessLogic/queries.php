<?php

    // Guest endpoint 1; used when a guest logs in
    function guestAccountRead($conn,$gUser,$gPass) {
        $sql = "SELECT * FROM Guest WHERE GuestLogin = \"$gUser\" AND GuestPass = \"$gPass\"";
        $result = mysqli_query($conn, $sql);
        return $result;
    }

    // Guest endpoint 3; used when a guest views all available rooms
    function viewRoomsGuest($conn) {
        $sql = "SELECT * FROM Room WHERE Availability = true";
        $result = mysqli_query($conn, $sql);
        return $result;
    }

    // Guest endpoint 3; used when a guest views all available rooms
    function viewRoomsGuestAmen($conn) {
        $sql = "SELECT * FROM RoomAmenities WHERE (FloorNo, RoomNo) IN (SELECT (FloorNo, RoomNo) FROM Room WHERE Availability = true)";
        $result = mysqli_query($conn, $sql);
        return $result;
    }

    // Admin endpoint 5; used when an admin views all floors
    function floorAdminRead($conn) {
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