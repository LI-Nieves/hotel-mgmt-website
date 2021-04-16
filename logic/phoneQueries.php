<?php
    include_once 'C:\xampp\htdocs\Project\logic\helper.php';
    // Admin/Receptionist endpoint 5; used to view all phone calls
    function phoneEmpRead($conn) {
        $result = mysqli_query($conn,"CALL phoneEmpRead()");
        return $result;
    }

    // Admin/Receptionist endpoint 6; used to create a phone call record
    function phoneEmpNew($conn,$gID,$duration,$pDate) {
        try {
            // handling user input
            $check1 = handleInputInteger($gID,$duration);
            $check2 = handleInputDate($pDate);
            if (!$check1 and !$check2) {
                throw new TypeError;
            }
            if ($duration < 0 and $duration != '') {
                echo "The duration cannot be negative.<br>";
                return false;
            }

            $duration = !empty($duration) ? $duration : NULL;

            // setting the EmpSSN on record to be the currently logged in employee
            $eSSN = assignCookie();

            //generate CallID
            $cID = rand(1000000000,9999999999);

            $stmt = $conn->prepare("CALL phoneEmpNew(?,?,?,?,?)");
            $stmt->bind_param("sisss",$cID, $duration,$pDate,$gID,$eSSN);
            $stmt->execute();

            if ($stmt->affected_rows < 1) {
                return false;
            }
            
            $result = $stmt->get_result();

            return $cID;

/*             $sql = "INSERT INTO PhoneCall VALUES ($cID, $duration,'$pDate',$gID,$eSSN)";
            $result1 = mysqli_query($conn, $sql);

            if($result1) {
                echo "Successfully created phone call record.<br>Here's the info:<br>";
                $sql3 = "SELECT * FROM PhoneCall WHERE CallID = \"$cID\"";
                $result = mysqli_query($conn, $sql3);
                return $result;
            }
            else {
                return false;
            } */
        }
        catch (TypeError $e) {
            echo "Please ensure that the duration is a number.<br>
                Please also ensure that the call date is a valid date.<br>";
            return false;
        }
    }

    // Admin/Receptionist endpoint: used to cancel a reservation
    function phoneAdminDel($conn,$cID) {
        $stmt = $conn->prepare("CALL phoneAdminDel(?)");
        $stmt->bind_param("s",$cID);
        $stmt->execute();

        if ($stmt->affected_rows < 1) {
            return false;
        }

        return true;

/*         $sql = "DELETE FROM PhoneCall WHERE CallID = $cID";
        $result = mysqli_query($conn,$sql);
        return $result; */
    }  

?>