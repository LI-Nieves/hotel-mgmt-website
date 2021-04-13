<?php
    include 'C:\xampp\htdocs\Project\logic\helper.php';

    // Admin/Receptionist endpoint 1; used to view all transactions
    function transEmpRead($conn) {
        $sql = "SELECT * FROM Transactions";
        $result = mysqli_query($conn, $sql);
        return $result;
    }

    // Admin/Receptionist endpoint 2; used to create transactions
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

            $eSSN = assignCookie();

            $tDate = !empty($tDate) ? "'$tDate'" : "NULL";
            $tType = !empty($tType) ? "'$tType'" : "NULL";
            $tGuestID = !empty($tGuestID) ? "'$tGuestID'" : "NULL";
            $tESSN = !empty($tESSN) ? "'$tESSN'" : "NULL";

            $sql = "INSERT INTO Transactions VALUES ($tID,$tDate,$tType,$tCost,$tGuestID,$eSSN)";
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
                Please also ensure that the transaction date is a valid date (if entered).<br>";
            return false;
        }
    }

?>