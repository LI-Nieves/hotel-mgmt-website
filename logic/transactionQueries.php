<?php
    include_once 'C:\xampp\htdocs\Project\logic\helper.php';

    // Admin/Receptionist endpoint: used to view all transactions
    function transEmpRead($conn) {
        $result = mysqli_query($conn,"CALL transEmpRead()");
        return $result;
    }

    // Admin/Receptionist endpoint: used to create transactions
    function transEmpNew($conn,$tDate,$tType,$tCost,$tGuestID) {
        try {
            // handle user input
            $check1 = handleInputInteger($tCost,$tGuestID);
            $check2 = handleInputDate($tDate);
            if (!$check1 and !$check2) {
                throw new TypeError;
            }
            if (($tCost + 0) < 0) {
                echo "The cost can't be negative.<br>";
                return false;
            }

            // generate Transaction ID
            $tID = rand(1000000000,9999999999);

            $tESSN = assignCookie();

            $tDate = !empty($tDate) ? $tDate : NULL;
            $tType = !empty($tType) ? $tType : NULL;
            $tGuestID = !empty($tGuestID) ? $tGuestID : NULL;
            $tESSN = !empty($tESSN) ? $tESSN : NULL;

            $stmt = $conn->prepare("CALL transEmpNew(?,?,?,?,?,?)");
            $stmt->bind_param("sssiss",$tID,$tDate,$tType,$tCost,$tGuestID,$tESSN);
            $stmt->execute();
            $idk = $stmt->affected_rows;

            if ($stmt->affected_rows < 1) {
                return false;
            }

            $result = $stmt->get_result();

            return $tID;
        }
        catch (TypeError $e) {
            echo "Please ensure that the transaction cost is a valid number.<br>
                Please also ensure that the transaction date is a valid date in yyyy-mm-dd format (if entered).<br>";
            return false;
        }
    }

    // Admin endpoint: used to delete transaction record
    function transAdminDel($conn,$tID) {
        $stmt = $conn->prepare("CALL transAdminDel(?)");
        $stmt->bind_param("s",$tID);
        $stmt->execute();

        if ($stmt->affected_rows < 1) {
            return false;
        }

        return true;
    }  

?>