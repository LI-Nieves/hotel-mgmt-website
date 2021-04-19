<?php
    include_once 'C:\xampp\htdocs\Project\logic\helper.php';

    // Guest endpoint: used when a guest logs in
    function guestLogin($conn,$gUser,$gPass) {
        // SQL statement
        $stmt = $conn->prepare("CALL GetCurrentGuest(?,?)");
        $stmt->bind_param("ss", $gUser, $gPass);
        $stmt->execute();
        $result = $stmt->get_result();

        $resultRet = $result;

        $currentID = 0;
        if ($result) {
            $count = 0;
            while ($row = mysqli_fetch_array($result)) {
                $currentID = $row['GuestID'];
                $count++;
            }
            if ($count == 0) {
                return false;
            }
            // setting this Guest's ID as the current session's ID
            setcookie("user", $currentID, 0, "/");
        }
        
        return $resultRet;
    }

    // Guest endpoint: used when a guest creates account
    function guestAccountNew($conn,$gName,$gUser,$gPass,$gCredit,$gPhone,$gAddress) {
        try {
            $table = 'Guest';
            $dupUsername = dupUsername($conn,$gUser,$table,'');
            if ($dupUsername) {
                echo "This username already exists in the database.<br>";
                return false;
            }

            // handling user input
            $check = handleInputInteger($gCredit,$gPhone);
            if (!$check) {
                throw new TypeError(); 
            }
            if (strlen($gCredit) != 16) {
                echo "Invalid credit card.<br>";
                return false;
            }
            if (strlen($gPhone) > 11) {
                echo "Invalid phone number.<br>";
                return false;
            }

            // generating random GuestID
            $gID = rand(1000000000,9999999999);

            $stmt = $conn->prepare("CALL guestAccountNew(?,?,?,?,?,?,?)");
            $stmt->bind_param("sssssss",$gID,$gUser,$gPass,$gCredit,$gPhone,$gName,$gAddress);
            $stmt->execute();

            if ($stmt->affected_rows < 1) {
                return false;
            }

            return $gID;
        }
        catch (TypeError $e) {
            echo "Please ensure that credit card and phone numbers are valid.<br>";
            return true;
        }
    }

    // Admin endpoint: used when admin views all guests
    function guestAdminRead($conn) {
        $result = mysqli_query($conn,"CALL guestAdminRead()");
        return $result;
    }
    
    // Admin endpoint: used when admin modifies guest
    function guestAdminWrite($conn,$gID,$gUser,$gCredit,$gPhone,$gName,$gAddress) {
        try {
            $table = 'Guest';
            $dupUsername = dupUsername($conn,$gUser,$table,$gID);
            if ($dupUsername) {
                echo "This username already exists in the database.<br>";
                return false;
            }
            // handling user input
            $output = handleInputInteger($gID,$gCredit,$gPhone);
            if (!$output) {
                throw new TypeError; 
            }
            if (strlen($gID) != 10) {
                echo "Invalid Guest ID.<br>";
                return false;
            }
            if (strlen($gCredit) != 16) {
                echo "Invalid credit card.<br>";
                return false;
            }
            if (strlen($gPhone) != 11) {
                echo "Invalid phone number.<br>";
                return false;
            }

            $stmt = $conn->prepare("CALL guestAdminWrite(?,?,?,?,?,?)");
            $stmt->bind_param("ssssss",$gUser,$gCredit,$gPhone,$gName,$gAddress,$gID);
            $stmt->execute();

            if ($stmt->affected_rows < 1) {
                return false;
            }

            return true;
                
        }
        catch (TypeError $e) {
            echo "Please ensure that the Guest's ID, credit card, and phone number are valid numbers.<br>";
            return false;
        }
    }

    // Admin endpoint: used when an admin deletes a guest record
    function guestAdminDel($conn,$gID) {
        $stmt = $conn->prepare("CALL guestAdminDel(?)");
        $stmt->bind_param("s",$gID);
        $stmt->execute();

        if ($stmt->affected_rows < 1) {
            return false;
        }

        return true;
    } 

?>