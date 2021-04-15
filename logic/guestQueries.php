<?php
    include_once 'C:\xampp\htdocs\Project\logic\helper.php';

    // Guest endpoint: used when a guest logs in
    function guestLogin($conn,$gUser,$gPass) {
        // SQL statement
        $sql = "SELECT * FROM Guest WHERE GuestLogin = \"$gUser\" AND GuestPass = \"$gPass\"";
        $result = mysqli_query($conn, $sql);

        // retrieving Guest's ID
        $sql1 = "SELECT GuestID FROM Guest WHERE GuestLogin = \"$gUser\" AND GuestPass = \"$gPass\"";
        $result1 = mysqli_query($conn, $sql);

        $currentID = 0;
        if ($result1) {
            header("Content-Type: JSON");

            while ($row = mysqli_fetch_array($result1)) {
                $currentID = $row['GuestID'];
            }
        }

        // setting this Guest's ID as the current session's ID
        setcookie("user", $currentID, 0, "/");

        return $result;
    }

    // Guest endpoint: used when a guest creates account
    function guestAccountNew($conn,$gName,$gUser,$gPass,$gCredit,$gPhone,$gAddress) {
        try {
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
            $gID = rand(0000000000,9999999999);

            // SQL statement
            $sql = "INSERT INTO Guest VALUES (\"$gID\",\"$gUser\",\"$gPass\",\"$gCredit\",\"$gPhone\",\"$gName\",\"$gAddress\")";
            $result = mysqli_query($conn, $sql);

            if ($result) {
                echo "Successfully created account.<br>Here's your info:<br>";
                $sql = "SELECT * FROM Guest WHERE GuestID = \"$gID\"";
                $info = mysqli_query($conn, $sql);

                header("Content-Type: JSON");
                $rowNumber = 0;
                $output = array();

                while ($row = mysqli_fetch_array($info)) {
                    $output[$rowNumber]['GuestID'] = $row['GuestID'];
                    $output[$rowNumber]['GuestName'] = $row['GuestName'];
                    $output[$rowNumber]['GuestLogin'] = $row['GuestLogin'];
                    $output[$rowNumber]['GuestPass'] = $row['GuestPass'];
                    $output[$rowNumber]['CreditCard'] = $row['CreditCard'];
                    $output[$rowNumber]['PhoneNo'] = $row['PhoneNo'];
                    $output[$rowNumber]['Address'] = $row['Address'];
                    $rowNumber++;
                }
                echo json_encode($output, JSON_PRETTY_PRINT);
            }

            return $result;
        }
        catch (TypeError $e) {
            echo "Ensure that credit card and phone numbers are valid.<br>";
            return false;
        }
    }

    // Admin endpoint: used when admin views all guests
    function guestAdminRead($conn) {
        $sql = "SELECT * FROM Guest";
        $result = mysqli_query($conn, $sql);
        return $result;
    }
    
    // Admin endpoint: used when admin modifies guest
    function guestAdminWrite($conn,$gID,$gLogin,$gCard,$gPhone,$gName,$gAddress) {
        try {
            // handling user input
            $output = handleInputInteger($gID,$gCard,$gPhone);
            if (!$output) {
                throw new TypeError(); 
            }
            if (strlen($gID) != 10) {
                echo "Invalid Guest ID.<br>";
                return false;
            }
            if (strlen($gCard) != 16) {
                echo "Invalid credit card.<br>";
                return false;
            }
            if (strlen($gPhone) != 11) {
                echo "Invalid phone number.<br>";
                return false;
            }
            $sql = "UPDATE Guest SET GuestLogin = \"$gLogin\", CreditCard = $gCard, 
                PhoneNo = $gPhone, GuestName = \"$gName\", Address = \"$gAddress\" WHERE GuestID = \"$gID\"";

            $result = mysqli_query($conn, $sql);
            return $result;
                
        }
        catch (TypeError $e) {
            echo "Ensure that the Guest's ID, credit card, and phone number are valid numbers.<br>";
            return false;
        }
    }

    // Admin endpoint: used when an admin deletes a guest record
    function guestAdminDel($conn,$gID) {

        $sql = "DELETE FROM Guest WHERE GuestID = $gID";
        $result = mysqli_query($conn,$sql);

        return $result;
    } 

?>