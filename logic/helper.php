<?php
    // used to log out
    function logOut() {
        $currentID = 0;
        session_destroy();
    }

    // returns ID/SSN of the current user that's logged in
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

    // takes some number of variables as input
    // returns true if all non-NULL inputs are of type integer, returns false otherwise
    function handleInputInteger() {
        try {
            $numArgs = func_num_args();
            $argList = func_get_args();
            for ($i = 0; $i < $numArgs; $i++) {
                if ($argList[$i] != '') {   // checks for NULL inputs
                    $argList[$i] + 0;
                }
            }
            return true;
        }
        catch (TypeError $e) {
            return false;
        }
    }

    // takes some number of variables as input
    // returns true if all non-NULL inputs are of type date, returns false otherwise
    function handleInputDate() {
        try {
            $numArgs = func_num_args();
            $argList = func_get_args();
            for ($i = 0; $i < $numArgs; $i++) {
                if ($argList[$i] != '') {   // checks for NULL inputs
                    strtotime($argList[$i]);
                }
            }
            return true;
        }
        catch (TypeError $e) {
            return false;
        }
    }

    // takes an SQL statement as input
    // returns the number of records that SQL statement generates
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
    // $id = the ID/SSN of the the person updating their info
    //      this is so it ignores the username if that same person already has it (i.e., they're not
    //      changing it and thus it already exists in the DB under their name)
    // returns true if the desired username already exists in the database
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