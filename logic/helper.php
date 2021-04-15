<?php

    function logOut() {
        $currentID = 0;
        session_destroy();
    }

    function assignCookie() {
        if (isset($_COOKIE["user"])) {
            $user = $_COOKIE["user"];
            return $user;
        }
        else {
            echo "Cookies have not been set.<br>";
            return 0;
        }
    }

    function handleInputInteger() {
        try {
            $numArgs = func_num_args();
            $argList = func_get_args();
            for ($i = 0; $i < $numArgs; $i++) {
                if ($argList[$i] != '') {
                    $argList[$i] + 0;
                }
            }
            //echo "int good<br>";
            return true;
        }
        catch (TypeError $e) {
            //echo "integer <br>";
            return false;
        }
    }

    function handleInputDate() {
        try {
            $numArgs = func_num_args();
            $argList = func_get_args();
            for ($i = 0; $i < $numArgs; $i++) {
                if ($argList[$i] != '') {
                    strtotime($argList[$i]);
                }
            }
            //echo "date good<br>";
            return true;
        }
        catch (TypeError $e) {
            //echo "dates <br>";
            return false;
        }
    }

    function countEntries($conn,$stmt) {
        $resultCheck = mysqli_query($conn,$stmt);
                    
        $count = 0;

        while ($row = mysqli_fetch_array($resultCheck)) {
            $count++;
        }

        return $count;
    }

    // Checks if a username is unique for a certain table.
    // $func = the type of table they're checking
    // $id = ignores the username if that same person already has it (i.e., they're not
    //  changing it and thus it already exists in the DB under their name)
    function dupUsername($conn,$name,$func,$id) {
        $count = 0;
        if ($func == 'Guest') {
            $sql = "SELECT GuestLogin FROM Guest WHERE GuestLogin = '$name' AND GuestID != '$id'";
            $result = mysqli_query($conn,$sql);
        }
        else if ($func == 'Employee') {
            $sql = "SELECT EmpLogin FROM Employee WHERE EmpLogin = '$name' AND SSN != '$id'";
            $result = mysqli_query($conn,$sql);
        }
        else if ($func == 'Admin') {
            $sql = "SELECT AdminLogin FROM Employee WHERE AdminLogin = '$name' AND SSN != '$id'";
            $result = mysqli_query($conn,$sql);
        }
        else if ($func == 'Receptionist') {
            $sql = "SELECT RecepLogin FROM Employee WHERE RecepLogin = '$name' AND SSN != '$id'";
            $result = mysqli_query($conn,$sql);
        }
        else {
            return false;
        }

        // counting the number of results with a GuestLogin the same as $gName
        if ($result) {
            while ($row = mysqli_fetch_array($result)) {
                $count++;
            }
        }

        if ($count > 0) {
            return true;
        }
        else {
            return false;
        }
        
    }

?>